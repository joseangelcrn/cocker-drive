@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-4">
                <img class="img-fluid img-thumbnail" id="img_perro_welcome" src="{{url('storage/sistema/cocker.jpg')}}" alt="Imagen Cocker">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h1 class=" mt-4 text-white">Cocker Drive</h1>
            </div>
        </div>
    </div>
@endsection
