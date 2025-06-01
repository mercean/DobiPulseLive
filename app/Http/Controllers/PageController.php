<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Show the Services Page
    public function services()
    {
        return view('pages.services');
    }

    // Show the About Us Page
    public function about()
    {
        return view('pages.about');
    }
}
