@extends('adminlte::page')

@section('title', 'SysEscaleno - Lista de Projectos')

@section('content')

<style>
    .card-custom {
        border: 1px solid #dee2e6;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .table-custom thead th {
        background-color: #343a40;
        color: white;
        text-align: center;
        border: none;
        padding: 12px 10px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .table-custom tbody td {
        background-color: white;
        color: #000;
        text-align: center;
        vertical-align: middle;
        padding: 10px 8px;
        border-bottom: 1px solid #dee2e6;
    }
    
    .table-custom tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .btn-group { 
        display: flex; 
        justify-content: center; 
        gap: 4px; 
    }
    
    .button-container { 
        display: flex; 
        gap: 10px; 
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-active { 
        background-color: #d4edda; 
        color: #155724; 
        border: 1px solid #c3e6cb;
    }
    
    .status-inactive { 
        background-color: #e2e3e5; 
        color: #383d41; 
        border: 1px solid #d6d8db;
    }
    
    .status-progress { 
        background-color: #fff3cd; 
        color: #856404; 
        border: 1px solid #ffeaa7;
    }
    
    .color-preview { 
        width: 25px; 
        height: 25px; 
        border-radius: 50%; 
        display: inline-block; 
        border: 1px solid #ddd;
        margin: 0 auto;
    }
    
    .image-container { 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        gap: 5px; 
        padding: 3px;
    }
    
    .image-preview {
        width: 40px; 
        height: 40px; 
        object-fit: cover;
        border-radius: 3px;
        border: 1px solid #ced4da;
    }
    
    .more-images {
        font-size: 10px;
        color: white;
        font-weight: bold;
        background: #6c757d;
        padding: 2px 6px;
        border-radius: 8px;
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 10px;
        opacity: 0.5;
    }
    
    .stats-header {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
    }
    
    .filter-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
    }

    @media (max-width: 768px) {
        .button-container {
            flex-direction: column;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .image-container {
            flex-wrap: wrap;
        }
        
        .btn-group {
            flex-wrap: wrap;
        }
    }
</style>

<div class="container-fluid">
    <!-- Cabeçalho com Estatísticas -->
    <div class="row">
        <div class="col-12">
            <div class="stats-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h3 class="mb-1">Gestão de Projectos</h3>
                        <p class="mb-0 text-muted">
                            @if($projectoos->count() > 0)
                                Mostrando {{ $projectoos->firstItem() }} - {{ $projectoos->lastItem() }} de {{ $projectoos->total() }} registos
                            @else
                                Nenhum registo encontrado
                            @endif
                        </p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="badge badge-success">Concluídos: {{ $projectoos->where('estado', 'CONCLUIDO')->count() }}</span>
                        <span class="badge badge-warning">Em Curso: {{ $projectoos->where('estado', '!=', 'CONCLUIDO')->count() }}</span>
                        <span class="badge badge-info">Total: {{ $projectoos->total() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Pesquisa -->
    <div class="row">
        <div class="col-12">
            <div class="filter-section">
                <form action="{{ route('projectoos.list') }}" method="GET" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Pesquisar em todos os campos..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="estado" class="form-control">
                            <option value="">Todos os estados</option>
                            <option value="CONCLUIDO" {{ request('estado') == 'CONCLUIDO' ? 'selected' : '' }}>Concluído</option>
                            <option value="EM_ANDAMENTO" {{ request('estado') == 'EM_ANDAMENTO' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="ACTIVO" {{ request('estado') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="categoria" class="form-control">
                            <option value="">Todas categorias</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Pesquisar
                            </button>
                            <a href="{{ route('projectoos.list') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh"></i> Limpar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Botões de Ação -->
    <div class="row">
        <div class="col-12">
            <div class="button-container">
                <a href="{{ url('/home') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <a href="{{ route('projectoos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Novo Projecto
                </a>
                
                <!-- Exportação CSV -->
                <a href="{{ route('projectoos.export.csv') }}" class="btn btn-success">
                    <i class="fas fa-file-csv"></i> Exportar CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Tabela de Projectos -->
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-list-alt mr-2"></i>
                        Lista de Projectos
                    </h3>
                </div>
                
                <div class="card-body p-0">
                    @if($projectoos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-custom table-hover" id="projectsTable">
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
                                        $statusClass = $projectoo->estado == 'CONCLUIDO' ? 'status-inactive' : 
                                                     ($projectoo->estado == 'EM_ANDAMENTO' ? 'status-progress' : 'status-active');
                                        $statusText = $projectoo->estado == 'CONCLUIDO' ? 'CONCLUÍDO' : 
                                                    ($projectoo->estado == 'EM_ANDAMENTO' ? 'EM ANDAMENTO' : 'ACTIVO');
                                        $imagens = $projectoo->imagens ?? [];
                                        $totalImagens = count($imagens);
                                    @endphp

                                    <tr>
                                        <td><strong>{{ $projectoo->id }}</strong></td>
                                        <td class="text-left">
                                            <strong>{{ $projectoo->nome }}</strong>
                                            @if($projectoo->descricao)
                                            <br><small class="text-muted">{{ Str::limit($projectoo->descricao, 30) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $projectoo->tipografia ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-secondary">
                                                {{ $projectoo->categoria->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ $projectoo->localizacao->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            @if($projectoo->cor)
                                                <div class="color-preview" 
                                                     style="background-color: {{ $projectoo->cor }}"
                                                     title="{{ $projectoo->cor }}">
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($totalImagens > 0)
                                                <div class="image-container">
                                                    @if($totalImagens > 3)
                                                        @for($i = 0; $i < 2; $i++)
                                                            @if(isset($imagens[$i]))
                                                            <img src="{{ asset('storage/' . $imagens[$i]) }}" 
                                                                 class="image-preview"
                                                                 alt="Imagem {{ $i + 1 }}"
                                                                 onerror="this.style.display='none'">
                                                            @endif
                                                        @endfor
                                                        <span class="more-images">+{{ $totalImagens - 2 }}</span>
                                                    @else
                                                        @foreach($imagens as $imagem)
                                                            <img src="{{ asset('storage/' . $imagem) }}" 
                                                                 class="image-preview"
                                                                 alt="Imagem"
                                                                 onerror="this.style.display='none'">
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('projectoos.show', $projectoo->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Ver detalhes">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('projectoos.edit', $projectoo->id) }}" 
                                                   class="btn btn-sm btn-warning"
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-secondary"
                                                        onclick="printProject({{ $projectoo->id }})"
                                                        title="Imprimir">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <form action="{{ route('projectoos.delete', $projectoo->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Tem certeza que deseja eliminar este projecto?')"
                                                            title="Eliminar">
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
                    @else
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h4>Nenhum projecto encontrado</h4>
                        <p>Não existem projectos que correspondam aos seus critérios de pesquisa.</p>
                        <a href="{{ route('projectoos.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus mr-2"></i>Criar Novo Projecto
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- Paginação -->
                @if($projectoos->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            Página {{ $projectoos->currentPage() }} de {{ $projectoos->lastPage() }}
                        </div>
                        <div>
                            {{ $projectoos->links() }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function printProject(projectId) {
        // Criar um modal ou redirecionar para uma página de impressão específica do projeto
        const projectRow = document.querySelector(`tr:has(td:first-child strong:contains("${projectId}"))`);
        
        if (projectRow) {
            const printContent = `
                <html>
                    <head>
                        <title>Projecto ${projectId} - SysEscaleno</title>
                        <style>
                            body { font-family: Arial, sans-serif; margin: 20px; }
                            .project-header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
                            .project-details { margin-bottom: 15px; }
                            .project-details strong { display: inline-block; width: 120px; }
                            .images-container { display: flex; gap: 10px; margin-top: 10px; }
                            .image-print { width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd; }
                        </style>
                    </head>
                    <body>
                        <div class="project-header">
                            <h2>Ficha do Projecto - SysEscaleno</h2>
                            <p>Data de emissão: ${new Date().toLocaleDateString('pt-PT')}</p>
                        </div>
                        
                        <div class="project-details">
                            <strong>ID:</strong> ${projectId}<br>
                            <strong>Nome:</strong> ${projectRow.cells[1].querySelector('strong').innerText}<br>
                            <strong>Tipografia:</strong> ${projectRow.cells[2].innerText}<br>
                            <strong>Categoria:</strong> ${projectRow.cells[3].innerText}<br>
                            <strong>Localização:</strong> ${projectRow.cells[4].innerText}<br>
                            <strong>Estado:</strong> ${projectRow.cells[5].innerText}
                        </div>
                        
                        <div class="project-details">
                            <strong>Imagens:</strong>
                            <div class="images-container">
                                ${Array.from(projectRow.cells[7].querySelectorAll('img')).map(img => 
                                    `<img src="${img.src}" class="image-print" alt="Imagem do projeto">`
                                ).join('')}
                            </div>
                        </div>
                    </body>
                </html>
            `;
            
            const printWindow = window.open('', '_blank');
            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        } else {
            alert('Projeto não encontrado para impressão');
        }
    }

    function printTable() {
        const printContent = document.getElementById('projectsTable').outerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = `
            <html>
                <head>
                    <title>Lista de Projectos - SysEscaleno</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f2f2f2; }
                        img { width: 30px; height: 30px; object-fit: cover; }
                    </style>
                </head>
                <body>
                    <h2>Lista de Projectos - SysEscaleno</h2>
                    <p>Data de emissão: ${new Date().toLocaleDateString('pt-PT')}</p>
                    ${printContent}
                </body>
            </html>
        `;
        
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
    }

    // Debug no console
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== DADOS DOS PROJECTOS ===');
        @foreach($projectoos as $projectoo)
            console.log('Projeto {{ $projectoo->id }}:', {
                nome: '{{ $projectoo->nome }}',
                estado: '{{ $projectoo->estado }}',
                categoria: '{{ $projectoo->categoria->name ?? 'N/A' }}',
                localizacao: '{{ $projectoo->localizacao->name ?? 'N/A' }}',
                imagens: {{ count($projectoo->imagens ?? []) }}
            });
        @endforeach
    });
</script>

@endsection