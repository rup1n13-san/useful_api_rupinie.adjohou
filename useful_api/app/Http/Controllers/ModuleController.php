<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the modules.
     */
    public function index()
    {
        return response()->json(Module::all(), 200);
    }
}