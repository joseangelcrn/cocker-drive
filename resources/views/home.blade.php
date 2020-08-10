@extends('layouts.app')

@section('title','Home')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-12 text-center">
                <p class="text-white">Espacio total usado: <b>{{$espacioTotalUsado}} MB</b> </p>
            </div>
            <div class="col-12 text-center">
                @if ($espacioTotalUsado > 0)
                    <a href="{{route('fichero.mis-ficheros')}}" class="btn btn-secondary">Ver mis archivos subidos</a>
                @else
                    <button disabled class="btn btn-secondary">Ver mis archivos subidos</button>
                @endif
                <a href="{{route('fichero.create')}}" class="btn btn-success">Subir fichero</a>
            </div>
        </div>
    </div>
@endsection
