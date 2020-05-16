@extends('templates.index')

@section('title','Crear Libro')

@section('css')
<link rel="stylesheet" href="{{ asset('css\bootstrap-select\bootstrap-select.min.css') }}">

@endsection

{{-- SECCION PARA CAMBIAR LA CLASE DE LA ETIQUETA BODY PARA EL INICIO DE SESION --}}
{{-- @section('type_page','login-page ls-closed') --}} 

{{-- breadcrumbs --}}

@section('breadcrumbs')
    <li><a href="{{ url('/') }}">Inicio</a></li>
        <li><a href="{{ route('backoffice.libro.index') }}">Libros</a></li>
        <li class="active">Subir</li>
@endsection

@section('content')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Subir Libro
                        <small>Los campos * son <b>OBLIGATORIOS</b></small>
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('backoffice.libro.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('models.libro.form')
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    {{-- <script>alert()</script> --}}

@endsection
