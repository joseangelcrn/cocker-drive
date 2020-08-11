@extends('layouts.app')

@section('title','Home')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center">
                <a href="{{route('fichero.mis-ficheros')}}" class="btn btn-secondary">Ver mis archivos subidos</a>
                <a href="{{route('fichero.create')}}" class="btn btn-success">Subir fichero</a>
            </div>
            <div class="col-12 text-center">
                <chart class="my-4" :size_disk_used="{{$sizeDiskUsed}}" :data_param="'{{json_encode($parsedData)}}'"></chart>
            </div>
        </div>
    </div>
@endsection
