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
        $fileUsageInfo = auth()->user()->getEspacioTotalUsado();
        $parsedData = Fichero::parseToCircleChart($fileUsageInfo);
        $sizeDiskUsed =number_format($fileUsageInfo['total'],2);
        // dd($parsedData);
        return view('home',compact('parsedData','sizeDiskUsed'));
    }
}
