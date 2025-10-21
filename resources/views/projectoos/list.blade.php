@extends('adminlte::page')

@section('title', 'Lista de Projectos')

@section('content')

<style>
    .table { background-color: #e3f2fd; color: #333; }
    .table th { background-color: #90caf9; color: #fff; text-align: center; }
    .table td { background-color: #e3f2fd; color: #000; text-align: center; vertical-align: middle; }
    .btn-group { display: flex; justify-content: center; gap: 5px; }
    .button-container { display: flex; gap: 10px; margin-bottom: 20px; }
    .status-active { background-color: #4CAF50; padding: 5px 10px; border-radius: 5px; color: white; }
    .status-inactive { background-color: #2196F3; padding: 5px 10px; border-radius: 5px; color: white; }
    .color-preview { width: 30px; height: 30px; border-radius: 50%; display: inline-block; border: 2px solid #ddd; }
    
    /* ✅ ESTILOS CORRIGIDOS PARA IMAGENS */
    .image-container { 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        gap: 8px; 
        padding: 5px;
    }
    .image-preview {
        width: 50px !important; 
        height: 50px !important; 
        object-fit: cover !important;
        border-radius: 4px !important;
        border: 2px solid #28a745 !important;
        display: block !important;
    }
    .more-images {
        font-size: 12px;
        color: #666;
        font-weight: bold;
    }
</style>

<div class="container">
    <div class="row mb-3">
        <div class="col-12 button-container">
            <a href="{{ url('/home') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('projectoos.create') }}" class="btn btn-primary">Adicionar Projecto</a>
            <a href="{{ url('/test-images') }}" class="btn btn-info" target="_blank">🧪 Testar Imagens</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Projectos ({{ $projectoos->count() }})</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Tipografia</th>
                                    <th>Categoria</th>
                                    <th>Localização</th>
                                    <th>Estado</th>
                                    <th>Cor</th>
                                    <th>Imagens</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projectoos as $projectoo)
                                    @php
                                        $statusClass = $projectoo->estado == 'CONCLUIDO' ? 'status-inactive' : 'status-active';
                                        $statusText = $projectoo->estado == 'CONCLUIDO' ? 'CONCLUÍDO' : 'EM CURSO';
                                        $imagens = $projectoo->imagens ?? [];
                                        $totalImagens = count($imagens);
                                    @endphp

                                    <tr>
                                        <td>{{ $projectoo->id }}</td>
                                        <td>{{ $projectoo->nome }}</td>
                                        <td>{{ $projectoo->tipografia ?? 'N/A' }}</td>
                                        <td>{{ $projectoo->categoria->name ?? 'N/A' }}</td>
                                        <td>{{ $projectoo->localizacao->name ?? 'N/A' }}</td>
                                        <td><span class="{{ $statusClass }}">{{ $statusText }}</span></td>
                                        <td>
                                            @if($projectoo->cor)
                                                <div class="color-preview" style="background-color: {{ $projectoo->cor }}"></div>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($totalImagens > 0)
                                                <div class="image-container">
                                                    @if($totalImagens > 3)
                                                        {{-- Mostrar apenas 2 imagens quando há mais de 3 --}}
                                                        @for($i = 0; $i < 2; $i++)
                                                            <img src="{{ asset('storage/' . $imagens[$i]) }}" 
                                                                 class="image-preview"
                                                                 alt="Imagem {{ $i + 1 }}"
                                                                 title="{{ $imagens[$i] }}">
                                                        @endfor
                                                        <span class="badge badge-info more-images" title="Total de {{ $totalImagens }} imagens">
                                                            +{{ $totalImagens - 2 }}
                                                        </span>
                                                    @else
                                                        {{-- Mostrar todas as imagens quando há 3 ou menos --}}
                                                        @foreach($imagens as $imagem)
                                                            <img src="{{ asset('storage/' . $imagem) }}" 
                                                                 class="image-preview"
                                                                 alt="Imagem"
                                                                 title="{{ $imagem }}">
                                                        @endforeach
                                                        <span class="badge badge-success">{{ $totalImagens }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">📷 Sem imagens</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('projectoos.show', $projectoo->id) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('projectoos.edit', $projectoo->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('projectoos.delete', $projectoo->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    console.log('=== DEBUG IMAGENS ===');
    @foreach($projectoos as $projectoo)
        console.log('Projeto {{ $projectoo->id }}:', {
            nome: '{{ $projectoo->nome }}',
            imagens: @json($projectoo->imagens),
            total: {{ count($projectoo->imagens ?? []) }},
            urls: @json(array_map(function($img) { return asset('storage/' . $img); }, $projectoo->imagens ?? []))
        });
    @endforeach
</script>

@endsection