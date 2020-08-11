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
        //if doesnt exist the key 'total' mean user still doesnt upload any file.
        $sizeDiskUsed =isset($fileUsageInfo['total'])?number_format($fileUsageInfo['total'],2) : 0;
        return view('home',compact('parsedData','sizeDiskUsed'));
    }
}
