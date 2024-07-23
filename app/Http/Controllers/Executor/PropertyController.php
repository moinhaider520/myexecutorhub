<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve property types and properties created by the authenticated user
        $propertyTypes = PropertyType::where('created_by', $user->created_by)->get();
        $properties = Property::where('created_by', $user->created_by)->get();
        
        return view('executor.assets.properties', compact('properties', 'propertyTypes'));
    }
}
