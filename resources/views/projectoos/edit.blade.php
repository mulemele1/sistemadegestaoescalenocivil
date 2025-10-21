@extends('adminlte::page')

@section('title', 'Editar Projecto')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-secondary mt-3">
                <div class="card-header">
                    <h3 class="card-title">Editar: {{ $projectoo->nome }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action=" {{ route('projectoos.update', $projectoo->id) }} " method="post">
                    @method('put')
                    @include('projectoos.partials.form')
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection