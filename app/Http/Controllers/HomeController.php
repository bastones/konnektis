<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the front view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('index');
    }
}
