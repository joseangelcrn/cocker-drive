@extends('layouts.app')

@section('title','Home')

@section('content')
    <home
        :size_disk_used="{{$sizeDiskUsed}}"
        :data="{{json_encode($parsedData)}}"

        :url_list_files="'{{route('fichero.mis-ficheros')}}'"
        :url_upload_files="'{{route('fichero.create')}}'"
        :url_download_all_compressed_files="'{{route('fichero.download-all-files')}}'"
        :url_delete_all="'{{route('fichero.delete-all-files-current-user')}}'"
        :url_logs="'{{route('log.index')}}'"

        ></home>
@endsection

