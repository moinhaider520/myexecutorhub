<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    public function show($slug)
    {
        $caseStudies = [
            'preventing-5-year-will-challenge' => 'case-studies.preventing-5-year-will-challenge',
            'saving-executors-30-60-hours' => 'case-studies.saving-executors-30-60-hours',
            '400000-hidden-asset' => 'case-studies.400000-hidden-asset',
        ];

        if (!isset($caseStudies[$slug])) {
            abort(404);
        }

        return view($caseStudies[$slug], compact('slug'));
    }
}

