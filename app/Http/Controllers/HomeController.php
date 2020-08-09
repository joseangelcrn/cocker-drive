<?php

namespace App\Http\Controllers;

use App\Fichero;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rootDir = auth()->user()->getRootDir();
        $espacioTotalUsado = Fichero::getEspacioUsado($rootDir);
        return view('home',compact('espacioTotalUsado'));
    }
}
