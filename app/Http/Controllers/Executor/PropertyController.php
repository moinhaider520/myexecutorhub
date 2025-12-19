<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $propertyTypes = PropertyType::where('created_by', $contextUser->id)->get();
        $properties = Property::where('created_by', $contextUser->id)->get();

        return view('executor.assets.properties', compact('properties', 'propertyTypes'));
    }
}
