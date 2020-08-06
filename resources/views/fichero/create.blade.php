@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-12 bg-white rounded p-3">
                <form action="{{route('fichero.store')}}" method="post">
                    @method('POST')
                    @csrf
                    <div class="form-group">
                        <h3>Subida de fichero</h3>
                    </div>
                    <div class="form-group">
                        <label><b>Nombre del archivo:</b> (<i>*Solo disponible para cuando  subas un fichero, de lo contrario se guardara con el propio nombre del fichero</i>)</label>
                        <input class="form-control" type="text" name="nombre_real">
                        <span>(<i>Dejalo en blanco si quieres que se guarde con el nombre del propio fichero</i>)</span>
                     </div>
                    <div class="form-group">
                        <label><b>Fichero:</b></label>
                       <input class="form-control" type="file" name="ficheros" multiple>
                       <span>Extensiones permitidas: .jpg, .jpeg, .png, .pdf</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">
                            Guardar Fichero
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
