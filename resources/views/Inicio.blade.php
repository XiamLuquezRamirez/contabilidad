@extends('Plantilla.principal')
@section('title', 'Tablero Inicial')
@section('Contenido')
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li><a href="{{ url('/') }}">Dashboard</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">

        <div class="row">

            
        </div>
    </div><!-- .animated -->
</div><!-- .content -->


    <script>
        document.addEventListener("DOMContentLoaded", async function() {
            let menuP = document.getElementById("inicio");
            menuP.classList.add("active");
        });
    </script>
@endsection
