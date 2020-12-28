<?php

namespace Garavel\Controller;

use App\Http\Controllers\Controller;

class GaravelHomeController extends Controller {

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('adminlte::home');
    }
}
