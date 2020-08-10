@extends('layouts.app')

@section('title','Mis archivos')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <buscador root_dir="{{auth()->user()->getRootDir()}}"></buscador>
            </div>
        </div>
    </div>
    {{-- <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Mis Archivos</h1>
            </div>
        </div>
    </div> --}}
    {{-- <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach ($ficheros as $fichero)
                <div class="col-lg-4 col-md-6 col-sm-12  my-2">
                    <fichero-miniatura root_dir="{{auth()->user()->getRootDir()}}" fichero_param="{{$fichero->toJson()}}"></fichero-miniatura>
                </div>
            @endforeach
        </div>
    </div> --}}

@endsection
