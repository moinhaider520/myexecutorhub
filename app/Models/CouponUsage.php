<?php

namespace App\Models;

use App\Notifications\PartnerFirstSaleNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class CouponUsage extends Model
{
    use HasFactory;
    protected $fillable = ['partner_id', 'user_id'];

    protected static function booted()
    {
        static::created(function (CouponUsage $couponUsage) {
            $partner = $couponUsage->partner;

            if (!$partner) {
                return;
            }

            $referralCount = static::where('partner_id', $partner->id)->count();

            if ($referralCount === 1) {
                $customerName = $couponUsage->user?->name ?? 'Unknown Customer';

                $partner->notify(new PartnerFirstSaleNotification($customerName));

                Mail::raw(
                    "Subject: First Executor Hub Sale\nPartner: {$partner->name}\nCustomer: {$customerName}",
                    function ($message) {
                        $message->to('hello@executorhub.co.uk')
                            ->subject('First Executor Hub Sale');
                    }
                );
            }
        });
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
