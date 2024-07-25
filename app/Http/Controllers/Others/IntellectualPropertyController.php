<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntellectualPropertiesTypes;
use App\Models\IntellectualProperty;
use Illuminate\Support\Facades\Auth;

class IntellectualPropertyController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Retrieve intellectual property types and intellectual properties created by the authenticated user
        $intellectualPropertyTypes = IntellectualPropertiesTypes::where('created_by', $user->created_by)->get();
        $intellectualProperties = IntellectualProperty::where('created_by', $user->created_by)->get();

        return view('others.assets.intellectual_properties', compact('intellectualProperties', 'intellectualPropertyTypes'));
    }
}
