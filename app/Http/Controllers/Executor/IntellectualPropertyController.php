<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntellectualPropertiesTypes;
use App\Models\IntellectualProperty;
use Illuminate\Support\Facades\Auth;

class IntellectualPropertyController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $intellectualPropertyTypes = IntellectualPropertiesTypes::where('created_by', $contextUser->id)->get();
        $intellectualProperties = IntellectualProperty::where('created_by', $contextUser->id)->get();

        return view('executor.assets.intellectual_properties', compact('intellectualProperties', 'intellectualPropertyTypes'));
    }
}
