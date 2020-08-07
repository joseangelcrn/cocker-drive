@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center">
                <a href="{{route('fichero.mis-ficheros')}}" class="btn btn-secondary">Ver mis archivos subidos</a>
                <a href="{{route('fichero.create')}}" class="btn btn-success">Subir fichero</a>
            </div>
        </div>
    </div>
@endsection
