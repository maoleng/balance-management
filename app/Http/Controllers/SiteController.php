<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\View\View;

class SiteController extends Controller
{

    public function market(): View
    {
        return view('market');
    }

}
