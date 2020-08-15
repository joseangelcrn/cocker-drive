@extends('layouts.app')

@section('title','Inicio')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-4">
                <img class="img-fluid img-thumbnail" id="img_perro_welcome" src="{{url('storage/sistema/cocker.jpg')}}" alt="Imagen Cocker">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1 class=" mt-4 text-center text-white">Cocker Drive</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a class="btn btn-success w-75 mb-2" href="{{route('login')}}">Iniciar Sesión</a>
                <a class="btn btn-warning w-75 " href="{{route('register')}}">Registrarse</a>
            </div>
        </div>
    </div>
@endsection
