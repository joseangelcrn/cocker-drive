<?php

namespace App\Http\Controllers;

use App\Fichero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        $fileUsageInfo = $user->getUsedSpaceDisk();
        $parsedData = Fichero::parseToCircleChart($fileUsageInfo);
        $sizeDiskUsed =isset($fileUsageInfo['total'])?$fileUsageInfo['total'] : 0;


        return view('home',compact('parsedData','sizeDiskUsed'));
    }
}
