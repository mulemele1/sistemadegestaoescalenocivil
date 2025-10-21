@extends('adminlte::page')

@section('title', 'Formulário de Projecto')

@section('content')

<style>
    .btn-custom {
        width: 70px;
        height: 30px;
        margin-top: 6px;
        justify-content: center;
        align-items: center;
        display: flex;
        margin-right: 10px;
    }
    .button-container {
        display: flex;
        margin-top: 2px;
    }
</style>

<div class="row mb-3">
    <div class="col-12 button-container">
        <!--<button onclick="window.history.back();" class="btn btn-secondary btn-custom" style="margin-right: 10px;">Voltar</button>-->
    </div>
</div>

<div class="container">
    @yield('content')
</div>

<div class="card-body">
    @include('projectoos.partials.validations')
    
    @if(isset($projectoo))
        <form action="{{ route('projectoos.update', $projectoo->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
    @else
        <form action="{{ route('projectoos.store') }}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf

        <div class="form-group">
            <label for="nome">Nome *</label>
            <input type="text" name="nome" value="{{ $projectoo->nome ?? old('nome') }}" class="form-control" id="nome"
                placeholder="Digite o Nome" required>
        </div>

        <div class="form-group">
            <label for="tipografia">Tipografia</label>
            <input type="text" name="tipografia" value="{{ $projectoo->tipografia ?? old('tipografia') }}" class="form-control" id="tipografia"
                placeholder="Digite a Tipografia">
        </div>

        <div class="form-group">
            <label for="area">Área</label>
            <input type="number" step="0.01" name="area" value="{{ $projectoo->area ?? old('area') }}" class="form-control" id="area"
                placeholder="Coloque a Área">
        </div>

        <div class="form-group">
            <label for="nome_cliente">Nome do Cliente *</label>
            <input type="text" name="nome_cliente" value="{{ $projectoo->nome_cliente ?? old('nome_cliente') }}" class="form-control" id="nome_cliente"
                placeholder="Digite o Nome do Cliente" required>
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoria *</label>
            <select class="form-control" name="categoria_id" id="categoria_id" required>
                <option value="">Selecione uma categoria</option>
                @foreach ($fontes as $item)
                    <option value="{{ $item->id }}" {{ (isset($projectoo) && $projectoo->categoria_id == $item->id) || old('categoria_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="localizacao_id">Localização *</label>
            <select class="form-control" name="localizacao_id" id="localizacao_id" required>
                <option value="">Selecione uma localização</option>
                @foreach ($gestaos as $item)
                    <option value="{{ $item->id }}" {{ (isset($projectoo) && $projectoo->localizacao_id == $item->id) || old('localizacao_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="ano_id">Ano *</label>
            <select class="form-control" name="ano_id" id="ano_id" required>
                <option value="">Selecione um ano</option>
                @foreach ($gerencias as $item)
                    <option value="{{ $item->id }}" {{ (isset($projectoo) && $projectoo->ano_id == $item->id) || old('ano_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="estado">Estado do Projeto *</label>
            <select name="estado" class="form-control" id="estado" required>
                <option value="EM_CURSO" {{ (isset($projectoo) && $projectoo->estado == 'EM_CURSO') || old('estado') == 'EM_CURSO' ? 'selected' : '' }}>Em Curso</option>
                <option value="CONCLUIDO" {{ (isset($projectoo) && $projectoo->estado == 'CONCLUIDO') || old('estado') == 'CONCLUIDO' ? 'selected' : '' }}>Concluído</option>
            </select>
        </div>

        <div class="form-group">
            <label for="cor">Cor</label>
            <input type="color" name="cor" value="{{ $projectoo->cor ?? old('cor') }}" class="form-control" id="cor">
        </div>

        <div class="form-group">
            <label for="imagens">Imagens</label>
            {{-- ✅ CORREÇÃO: name="imagens[]" e multiple --}}
            <input type="file" name="imagens[]" multiple class="form-control" id="imagens"
                accept="image/*">
            <small class="form-text text-muted">
                Selecione múltiplas imagens (Ctrl+Click)
            </small>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="{{ route('projectoos.list') }}" class="btn btn-default">Cancelar</a>
    </form>
</div>

{{-- ✅ REMOVER CÓDIGO PHP ANTIGO (não é necessário no Laravel) --}}
{{-- 
<?php
if (isset($_FILES['imagem']) && !empty ($_FILES["imagem"])) {
    $imagem = "./projectos/imagens/".$_FILES["imagem"]["name"];
    move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem);
} else {
    $imagem  = "Nenhum arquivo foi enviado";
}
?>
--}}

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
<script>
    function salvar() {
        Swal.fire({
            title: "Salvo",
            text: "Bom trabalho!",
            icon: "success",
            timer: 15000
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Usuário clicou em OK");
            }
        });
    }
</script>
@endsection