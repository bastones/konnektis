<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    /**
     * Show the view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('app');
    }
}
