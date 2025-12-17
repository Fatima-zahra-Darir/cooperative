<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OncaController extends Controller
{
    public function index()
    {
        return view('onca.index');
    }
}

