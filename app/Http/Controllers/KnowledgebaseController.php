<?php

namespace App\Http\Controllers;

use App\Notifications\PartnerActivatedNotification;
use App\Support\PartnerActivationJourney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class KnowledgebaseController extends Controller
{
    public function index()
    {
        $this->authorizePartnerActivationStep(PartnerActivationJourney::STEP_WHAT_EXECUTOR_HUB_IS);
        PartnerActivationJourney::markVisited(Auth::user(), PartnerActivationJourney::STEP_WHAT_EXECUTOR_HUB_IS);
        return view('knowledgebase.index');
    }

    public function email_templates()
    {
        return view('knowledgebase.email_templates');
    }
    public function suggested_scripts()
    {
        return view('knowledgebase.suggested_scripts');
    }

    public function short_call_openers()
    {
        return view('knowledgebase.short_call_openers');
    }
    public function whatsapp_texts()
    {
        return view('knowledgebase.whatsapp_texts');
    }
    public function social_media_direct_messages()
    {
        return view('knowledgebase.social_media_direct_messages');
    }
    public function social_media_posts()
    {
        return view('knowledgebase.social_media_posts');
    }

    public function quick_start_guide()
    {
        $partner = Auth::user();

        if (PartnerActivationJourney::currentStep($partner) < PartnerActivationJourney::STEP_FIRST_SALE_BLUEPRINT) {
            return redirect()->route(PartnerActivationJourney::nextRouteName($partner))
                ->with('error', 'Please complete the activation steps in order.');
        }

        $progress = PartnerActivationJourney::complete($partner);

        if (!$progress->partner_activation_notified_at) {
            $partner->notify(new PartnerActivatedNotification($partner->name));

            Mail::raw(
                "Subject: Partner Activated\nPartner: {$partner->name}\nCompany: {$partner->company_name}\nOnboarding completed: Yes\nReferral link activated: Yes",
                function ($message) {
                    $message->to('hello@executorhub.co.uk')
                        ->subject('Partner Activated');
                }
            );

            $progress->partner_activation_notified_at = now();
            $progress->save();
        }

        return view('knowledgebase.quick_start_guide');
    }
    public function why_clients_buy_it()
    {
        $this->authorizePartnerActivationStep(PartnerActivationJourney::STEP_WHY_CLIENTS_BUY_IT);
        PartnerActivationJourney::markVisited(Auth::user(), PartnerActivationJourney::STEP_WHY_CLIENTS_BUY_IT);
        return view('knowledgebase.why_clients_buy_it');
    }
    public function first_sale_blueprint()
    {
        $this->authorizePartnerActivationStep(PartnerActivationJourney::STEP_FIRST_SALE_BLUEPRINT);
        PartnerActivationJourney::markVisited(Auth::user(), PartnerActivationJourney::STEP_FIRST_SALE_BLUEPRINT);
        return view('knowledgebase.first_sale_blueprint');
    }
    public function recruit_partners()
    {
        return view('knowledgebase.recruit_partners');
    }
    public function growth_plan()
    {
        return view('knowledgebase.growth_plan');
    }
    public function best_practices()
    {
        $this->authorizePartnerActivationStep(PartnerActivationJourney::STEP_HOW_TO_INTRODUCE_IT);
        PartnerActivationJourney::markVisited(Auth::user(), PartnerActivationJourney::STEP_HOW_TO_INTRODUCE_IT);
        return view('knowledgebase.best_practices');
    }
    public function client_reactivation()
    {
        return view('knowledgebase.client_reactivation');
    }
    public function entry_example()
    {
        return view('knowledgebase.entry_example');
    }
    protected function authorizePartnerActivationStep(int $step)
    {
        $partner = Auth::user();

        if (!$partner || !$partner->hasRole('partner')) {
            return null;
        }

        if (!PartnerActivationJourney::canAccess($partner, $step)) {
            return redirect()->route(PartnerActivationJourney::nextRouteName($partner))
                ->with('error', 'Please complete the activation steps in order.')
                ->send();
        }

        return null;
    }

}
