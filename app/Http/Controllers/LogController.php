<?php

namespace App\Http\Controllers;

use App\Log;
use App\PaginationCustom;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('log.index');
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function searching(Request $request)
    {

        $length = $request->input('length');
        $orderBy = $request->input('column','created_at'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search','');
        $userId = auth()->user()->id;
        $logType = $request->input('logType',null);
        $request = $request->all();


        $data = Log::filterDataByUserChoise($userId,$searchValue,$length,$orderBy,$orderByDir,$logType);


        return new DataTableCollectionResource($data);

    }

}
