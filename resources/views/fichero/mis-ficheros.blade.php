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
@endsection
