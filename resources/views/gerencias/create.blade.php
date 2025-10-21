@extends('adminlte::page')

@section('title', 'Adicionar Ano')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-secondary mt-3">
                <div class="card-header">
                    <h3 class="card-title">Novo Cadastro</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('gerencias.store') }}" method="post">
                    @csrf
                    @include('gerencias/partials/form')
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
