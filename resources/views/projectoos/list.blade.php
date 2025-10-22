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
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .image-preview:hover {
        transform: scale(1.1);
    }
    
    .more-images {
        font-size: 10px;
        color: white;
        font-weight: bold;
        background: #6c757d;
        padding: 2px 6px;
        border-radius: 8px;
        cursor: pointer;
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

    /* Modal para detalhes do projeto */
    .project-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        overflow-y: auto;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 2% auto;
        padding: 0;
        border-radius: 10px;
        width: 90%;
        max-width: 1000px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .close-modal {
        position: absolute;
        top: 15px;
        right: 25px;
        color: white;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10001;
        background: rgba(0,0,0,0.5);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-modal:hover {
        background: rgba(0,0,0,0.7);
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 10px 10px 0 0;
        position: relative;
    }

    .modal-body {
        padding: 30px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .project-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .detail-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }

    .detail-section h5 {
        color: #333;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .image-gallery-modal {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .gallery-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .gallery-image:hover {
        transform: scale(1.05);
    }

    .status-badge-modal {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    .status-active { background-color: #d4edda; color: #155724; }
    .status-inactive { background-color: #e2e3e5; color: #383d41; }
    .status-progress { background-color: #fff3cd; color: #856404; }

    .color-display-modal {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 2px solid #dee2e6;
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
    }

    /* Estilos para anexos/documentos */
    .attachments-section {
        margin-top: 30px;
    }

    .attachments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .attachment-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .attachment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #667eea;
    }

    .attachment-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #667eea;
    }

    .attachment-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
        word-break: break-word;
    }

    .attachment-size {
        font-size: 0.8rem;
        color: #666;
    }

    .file-preview-modal {
        display: none;
        position: fixed;
        z-index: 10002;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
    }

    .file-preview-content {
        background-color: white;
        margin: 5% auto;
        padding: 20px;
        border-radius: 10px;
        width: 80%;
        max-width: 800px;
        max-height: 80vh;
        overflow-y: auto;
    }

    .file-preview-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .file-preview-body {
        text-align: center;
    }

    .file-preview-body img {
        max-width: 100%;
        max-height: 60vh;
        border-radius: 8px;
    }

    .file-preview-body iframe {
        width: 100%;
        height: 60vh;
        border: none;
        border-radius: 8px;
    }

    .download-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 10px;
    }

    .download-btn:hover {
        background: #218838;
        color: white;
        text-decoration: none;
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

        .project-detail-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .modal-content {
            width: 95%;
            margin: 5% auto;
        }

        .image-gallery-modal {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }

        .attachments-grid {
            grid-template-columns: 1fr;
        }

        .file-preview-content {
            width: 95%;
            margin: 10% auto;
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
                                                                 onclick="openProjectModal({{ $projectoo->id }})"
                                                                 onerror="this.style.display='none'">
                                                            @endif
                                                        @endfor
                                                        <span class="more-images" onclick="openProjectModal({{ $projectoo->id }})">+{{ $totalImagens - 2 }}</span>
                                                    @else
                                                        @foreach($imagens as $imagem)
                                                            <img src="{{ asset('storage/' . $imagem) }}" 
                                                                 class="image-preview"
                                                                 alt="Imagem"
                                                                 onclick="openProjectModal({{ $projectoo->id }})"
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
                                                <!-- Botão VER com modal -->
                                                <button type="button" 
                                                        class="btn btn-sm btn-info" 
                                                        title="Ver detalhes"
                                                        onclick="openProjectModal({{ $projectoo->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                
                                                <!-- Botão VER página show -->
                                                <a href="{{ route('projectoos.show', $projectoo->id) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="Ver página completa">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>

                                                <a href="{{ route('projectoos.edit', $projectoo->id) }}" 
                                                   class="btn btn-sm btn-warning"
                                                   title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
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

<!-- Modal para detalhes do projeto -->
<div id="projectModal" class="project-modal">
    <span class="close-modal" onclick="closeProjectModal()">&times;</span>
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalProjectName" class="mb-0"></h2>
            <p id="modalProjectInfo" class="mb-0 opacity-75"></p>
        </div>
        <div class="modal-body">
            <div id="modalProjectContent">
                <!-- Conteúdo será carregado via JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualização de arquivos -->
<div id="filePreviewModal" class="file-preview-modal">
    <div class="file-preview-content">
        <div class="file-preview-header">
            <h4 id="fileNamePreview"></h4>
            <span class="close-modal" onclick="closeFilePreview()">&times;</span>
        </div>
        <div class="file-preview-body" id="filePreviewBody">
            <!-- Conteúdo do arquivo será carregado aqui -->
        </div>
    </div>
</div>

<script>
    // Dados dos projetos para o modal
    const projectsData = {!! json_encode($projectoos->map(function($project) {
        return [
            'id' => $project->id,
            'nome' => $project->nome,
            'tipografia' => $project->tipografia,
            'descricao' => $project->descricao,
            'categoria' => $project->categoria->name ?? 'Sem categoria',
            'localizacao' => $project->localizacao->name ?? 'N/A',
            'estado' => $project->estado,
            'cor' => $project->cor,
            'imagens' => $project->imagens ?? [],
            'anexos' => $project->anexos ?? [],
            'created_at' => $project->created_at->format('d/m/Y H:i'),
            'updated_at' => $project->updated_at->format('d/m/Y H:i')
        ];
    })) !!};

    // Função para obter ícone baseado na extensão do arquivo
    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const iconMap = {
            'pdf': '📄',
            'doc': '📝',
            'docx': '📝',
            'xls': '📊',
            'xlsx': '📊',
            'ppt': '📽️',
            'pptx': '📽️',
            'txt': '📃',
            'zip': '📦',
            'rar': '📦',
            'jpg': '🖼️',
            'jpeg': '🖼️',
            'png': '🖼️',
            'gif': '🖼️',
            'mp4': '🎬',
            'avi': '🎬',
            'mov': '🎬'
        };
        return iconMap[ext] || '📎';
    }

    function openProjectModal(projectId) {
        const project = projectsData.find(p => p.id === projectId);
        if (!project) return;

        // Atualizar header do modal
        document.getElementById('modalProjectName').textContent = project.nome;
        document.getElementById('modalProjectInfo').textContent = 
            `ID: ${project.id} | Criado em: ${project.created_at}`;

        // Determinar classe do status
        let statusClass = 'status-progress';
        let statusText = project.estado;
        
        if (project.estado === 'CONCLUIDO') {
            statusClass = 'status-inactive';
            statusText = 'CONCLUÍDO';
        } else if (project.estado === 'ACTIVO') {
            statusClass = 'status-active';
            statusText = 'ACTIVO';
        }

        // Construir conteúdo do modal
        const modalContent = `
            <div class="project-detail-grid">
                <div class="detail-section">
                    <h5><i class="fas fa-info-circle mr-2"></i>Informações Básicas</h5>
                    <p><strong>Nome:</strong> ${project.nome}</p>
                    <p><strong>Tipografia:</strong> ${project.tipografia || 'N/A'}</p>
                    ${project.descricao ? `<p><strong>Descrição:</strong> ${project.descricao}</p>` : ''}
                </div>

                <div class="detail-section">
                    <h5><i class="fas fa-tags mr-2"></i>Categoria e Localização</h5>
                    <p><strong>Categoria:</strong> 
                        <span class="badge badge-primary">${project.categoria}</span>
                    </p>
                    <p><strong>Localização:</strong> 
                        <span class="badge badge-secondary">${project.localizacao}</span>
                    </p>
                    <p><strong>Estado:</strong> 
                        <span class="status-badge-modal ${statusClass}">${statusText}</span>
                    </p>
                </div>
            </div>

            <div class="project-detail-grid">
                <div class="detail-section">
                    <h5><i class="fas fa-palette mr-2"></i>Detalhes do Projecto</h5>
                    ${project.cor ? `
                        <p><strong>Cor:</strong> 
                            <div class="color-display-modal" style="background-color: ${project.cor}"></div>
                            ${project.cor}
                        </p>
                    ` : '<p><strong>Cor:</strong> Nenhuma cor definida</p>'}
                    <p><strong>Data de Criação:</strong> ${project.created_at}</p>
                    <p><strong>Última Actualização:</strong> ${project.updated_at}</p>
                </div>

                <div class="detail-section">
                    <h5><i class="fas fa-chart-bar mr-2"></i>Estatísticas</h5>
                    <p><strong>Total de Imagens:</strong> ${project.imagens.length}</p>
                    <p><strong>Total de Anexos:</strong> ${project.anexos ? project.anexos.length : 0}</p>
                    <p><strong>Estado do Projecto:</strong> ${project.estado}</p>
                </div>
            </div>

            <div class="detail-section">
                <h5>
                    <i class="fas fa-camera mr-2"></i>
                    Galeria de Imagens 
                    <span class="badge badge-primary ml-2">${project.imagens.length} imagens</span>
                </h5>
                
                ${project.imagens.length > 0 ? `
                    <div class="image-gallery-modal">
                        ${project.imagens.map((imagem, index) => `
                            <img src="{{ asset('storage/') }}/${imagem}" 
                                 alt="Imagem ${index + 1} do projecto ${project.nome}"
                                 class="gallery-image"
                                 onclick="previewFile('{{ asset('storage/') }}/${imagem}', 'Imagem ${index + 1}')"
                                 onerror="this.style.display='none'">
                        `).join('')}
                    </div>
                ` : `
                    <div class="text-center py-3">
                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Nenhuma imagem disponível para este projecto.</p>
                    </div>
                `}
            </div>

            ${project.anexos && project.anexos.length > 0 ? `
            <div class="attachments-section">
                <div class="detail-section">
                    <h5>
                        <i class="fas fa-paperclip mr-2"></i>
                        Documentos e Anexos
                        <span class="badge badge-info ml-2">${project.anexos.length} arquivos</span>
                    </h5>
                    
                    <div class="attachments-grid">
                        ${project.anexos.map((anexo, index) => {
                            const fileName = anexo.split('/').pop();
                            const fileIcon = getFileIcon(fileName);
                            return `
                                <div class="attachment-card" onclick="previewFile('{{ asset('storage/') }}/${anexo}', '${fileName}')">
                                    <div class="attachment-icon">${fileIcon}</div>
                                    <div class="attachment-name">${fileName}</div>
                                    <div class="attachment-size">Documento ${index + 1}</div>
                                    <a href="{{ asset('storage/') }}/${anexo}" 
                                       class="download-btn" 
                                       download="${fileName}"
                                       onclick="event.stopPropagation()">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </div>
                            `;
                        }).join('')}
                    </div>
                </div>
            </div>
            ` : `
            <div class="attachments-section">
                <div class="detail-section">
                    <h5><i class="fas fa-paperclip mr-2"></i>Documentos e Anexos</h5>
                    <div class="text-center py-3">
                        <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">Nenhum documento anexado a este projecto.</p>
                    </div>
                </div>
            </div>
            `}

            <div class="text-center mt-4">
                <a href="/projectoos/${project.id}" class="btn btn-primary">
                    <i class="fas fa-external-link-alt mr-2"></i>Ver Página Completa
                </a>
            </div>
        `;

        document.getElementById('modalProjectContent').innerHTML = modalContent;
        document.getElementById('projectModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeProjectModal() {
        document.getElementById('projectModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function previewFile(fileUrl, fileName) {
        const fileExt = fileName.split('.').pop().toLowerCase();
        const previewBody = document.getElementById('filePreviewBody');
        const fileNamePreview = document.getElementById('fileNamePreview');
        
        fileNamePreview.textContent = fileName;
        
        // Limpar conteúdo anterior
        previewBody.innerHTML = '';
        
        // Verificar tipo de arquivo e mostrar preview apropriado
        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
            previewBody.innerHTML = `
                <img src="${fileUrl}" alt="${fileName}" style="max-width: 100%; max-height: 60vh;">
                <br>
                <a href="${fileUrl}" class="download-btn" download="${fileName}">
                    <i class="fas fa-download"></i> Download da Imagem
                </a>
            `;
        } else if (['pdf'].includes(fileExt)) {
            previewBody.innerHTML = `
                <iframe src="${fileUrl}" width="100%" height="500px"></iframe>
                <br>
                <a href="${fileUrl}" class="download-btn" download="${fileName}">
                    <i class="fas fa-download"></i> Download do PDF
                </a>
            `;
        } else if (['mp4', 'avi', 'mov', 'webm'].includes(fileExt)) {
            previewBody.innerHTML = `
                <video controls style="max-width: 100%; max-height: 60vh;">
                    <source src="${fileUrl}" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                </video>
                <br>
                <a href="${fileUrl}" class="download-btn" download="${fileName}">
                    <i class="fas fa-download"></i> Download do Vídeo
                </a>
            `;
        } else {
            previewBody.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-file fa-3x text-muted mb-3"></i>
                    <h5>Pré-visualização não disponível</h5>
                    <p>Este tipo de arquivo não pode ser pré-visualizado no navegador.</p>
                    <a href="${fileUrl}" class="download-btn" download="${fileName}">
                        <i class="fas fa-download"></i> Download do Arquivo
                    </a>
                </div>
            `;
        }
        
        document.getElementById('filePreviewModal').style.display = 'block';
    }

    function closeFilePreview() {
        document.getElementById('filePreviewModal').style.display = 'none';
    }

    // Fechar modais ao clicar fora do conteúdo
    document.getElementById('projectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProjectModal();
        }
    });

    document.getElementById('filePreviewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeFilePreview();
        }
    });

    // Fechar modais com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProjectModal();
            closeFilePreview();
        }
    });

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