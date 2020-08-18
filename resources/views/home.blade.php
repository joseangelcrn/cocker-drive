@extends('layouts.app')

@section('title','Home')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center">
                <a href="{{route('fichero.mis-ficheros')}}" class="btn btn-secondary" title="Ver mis archivos"><i class="fas fa-list"></i></a>
                <a href="{{route('fichero.create')}}" class="btn btn-success" title="Subir archivos"><i class="fas fa-cloud-upload-alt"></i></a>
                <a href="{{route('fichero.download-all-files')}}" class="btn btn-warning" title="Descargar todos los archivo en carpeta comprimida."><i class="far fa-file-archive"></i></a>
            </div>
            <div class="col-12 text-center">
                <chart-donut class="my-4" :size_disk_used="{{$sizeDiskUsed}}" :data_param="'{{json_encode($parsedData)}}'"></chart-donut>
            </div>
        </div>
    </div>
@endsection
