<?php

namespace App\Http\Controllers;

use App\Fichero;
use App\Seguridad;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use File;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FicheroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('fichero.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $resultado = false;

        if ($user != null) {

            $ficheros = $request->ficheros;
            $user = Auth()->user();
            $resultado = Fichero::fullGuardado($ficheros,$user);
        }

        return response()->json(['resultado'=>$resultado]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Fichero $fichero)
    {
        //
        $rootDirPath = $fichero->user->hash_root_dir;
        $url = public_path('storage\\ficheros\\'.$rootDirPath.'\\'.$fichero->nombre_hash);
        return response()->file($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * At this point, we will be able to change just the real_name field
     * of the model, if you want to change photo you need delete this
     * and re store new one.
     */
    public function update(Request $request,$id)
    {
        //
        $result = false;
        $newFileName = $request->new_name;
        $file = Fichero::findOrFail($id);

        if ($newFileName != null  and $newFileName != '') {
            $updatedFile = $file->updateFileNameDb($newFileName);
            $newFileName == $updatedFile->nombre_real ? $result = true: $result = false;
        }

        return response()->json([
            'result' => $result,
            'file' => $file
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $file = Fichero::findOrFail($id);

        $result = $file->fullDelete();

        return response()->json(['result'=>$result]);

    }

    /**
     * Custom Functions
     */

     /**
      * Return view : mis-ficheros (my files)
      */
    public function misFicheros()
    {
        return view('fichero.mis-ficheros');
    }

    /**
     * Delete all files of logged user
     */

    public function fullDelete(Request $request)
    {
        $result = false;

        $user = auth()->user();
        $files = $user->ficheros;
        $arrayDeletingStatus = array();

        foreach ($files as $file) {
            $deleted = $file->fullDelete();
            array_push($arrayDeletingStatus,$deleted);
        }

        //if all status are true, every file was successfully uploaded.
        if (count(array_unique($arrayDeletingStatus)) === 1 && end($arrayDeletingStatus) === true) {
            $result = true;
        }
        return response()->json($result);
    }

    /**
     * Returns all matching files by user search
     */

    public function advancedSearching(Request $request)
    {
        $user = auth()->user();
        $fileNameToFind = $request->file_name_to_find;
        $filters = json_decode($request->filters);
        $filesPerPage = 3;

        // $matchedFiles = $user->ficheros()->where('nombre_real','like',$fileNameToFind.'%')->paginate($filesPerPage);
        $preSearching = $user->ficheros()->where('nombre_real','like',$fileNameToFind.'%');

        //Additionals filters which users can select for a better searching.
        $preSearching = Fichero::applyFilters($preSearching,$filters);
        $matchedFiles = $preSearching->paginate($filesPerPage);

        return response()->json(['result'=>$matchedFiles]);
    }

    /**
     * Return all files of current user comprissed in zip package.
     */

    public function downloadCompressedFiles()
    {
        $user = auth()->user();
        $path = Fichero::compressAllFilesByUser($user);

        if ($path != null) {
            return response()->download($path);
        }
        else{
            return response()->json(false);
        }


    }
    /**
     * Return selected file of current user comprissed in zip package.
     */

    public function downloadSingleFile(Request $request)
    {
        $fileId = $request->file_id;
        $user = auth()->user();
        $file = $user->ficheros()->find($fileId);
        $pathFile = $file->getPublicPath();

        if (file_exists($pathFile)) {
            $fullRealFileName = $file->nombre_real.'.'.$file->extension;
            return response()->download($pathFile, $fullRealFileName,[]);
        }

        return response()->json([false]);



    }

}
