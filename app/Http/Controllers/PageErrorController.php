<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageErrorController extends Controller
{
    public function showNotAllowedForm()
    {
        return view('errors.not_allowed');
    }
}
