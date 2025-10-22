@extends('adminlte::page')

@section('title', 'SysEscaleno - Detalhes do Projecto')

@section('content')

<style>
    .project-detail-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    .project-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 8px 8px 0 0;
    }
    
    .info-card {
        border-left: 4px solid #007bff;
        background: #f8f9fa;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 4px;
    }
    
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .image-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .image-item:hover {
        transform: translateY(-5px);
    }
    
    .image-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        cursor: pointer;
    }
    
    .image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 8px;
        text-align: center;
        font-size: 0.8rem;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-active { 
        background-color: #d4edda; 
        color: #155724; 
    }
    
    .status-inactive { 
        background-color: #e2e3e5; 
        color: #383d41; 
    }
    
    .status-progress { 
        background-color: #fff3cd; 
        color: #856404; 
    }
    
    .color-display {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        border: 2px solid #dee2e6;
        display: inline-block;
        vertical-align: middle;
        margin-right: 10px;
    }
    
    /* Modal para imagem ampliada */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
    }
    
    .modal-content {
        margin: auto;
        display: block;
        max-width: 80%;
        max-height: 80%;
    }
    
    .close-modal {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .nav-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid">
    <!-- Botões de Navegação -->
    <div class="nav-buttons">
        <a href="{{ route('projectoos.list') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar à Lista
        </a>
        <a href="{{ route('projectoos.edit', $projectoo->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar Projecto
        </a>
        <button onclick="window.print()" class="btn btn-info">
            <i class="fas fa-print"></i> Imprimir
        </button>
    </div>

    <!-- Card Principal -->
    <div class="card project-detail-card">
        <!-- Cabeçalho -->
        <div class="project-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-1">
                        <i class="fas fa-project-diagram mr-2"></i>
                        {{ $projectoo->nome }}
                    </h2>
                    <p class="mb-0 opacity-75">
                        ID: {{ $projectoo->id }} | 
                        Criado em: {{ $projectoo->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
                <div class="col-md-4 text-right">
                    @php
                        $statusClass = $projectoo->estado == 'CONCLUIDO' ? 'status-inactive' : 
                                     ($projectoo->estado == 'EM_ANDAMENTO' ? 'status-progress' : 'status-active');
                        $statusText = $projectoo->estado == 'CONCLUIDO' ? 'CONCLUÍDO' : 
                                    ($projectoo->estado == 'EM_ANDAMENTO' ? 'EM ANDAMENTO' : 'ACTIVO');
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Informações Básicas -->
                <div class="col-md-6">
                    <div class="info-card">
                        <h5><i class="fas fa-info-circle mr-2"></i>Informações Básicas</h5>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <strong>Nome:</strong><br>
                                {{ $projectoo->nome }}
                            </div>
                            <div class="col-6">
                                <strong>Tipografia:</strong><br>
                                {{ $projectoo->tipografia ?? 'N/A' }}
                            </div>
                        </div>
                        
                        @if($projectoo->descricao)
                        <div class="mt-2">
                            <strong>Descrição:</strong><br>
                            {{ $projectoo->descricao }}
                        </div>
                        @endif
                    </div>

                    <!-- Categoria e Localização -->
                    <div class="info-card">
                        <h5><i class="fas fa-tags mr-2"></i>Categoria e Localização</h5>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <strong>Categoria:</strong><br>
                                <span class="badge badge-primary">
                                    {{ $projectoo->categoria->name ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="col-6">
                                <strong>Localização:</strong><br>
                                <span class="badge badge-secondary">
                                    {{ $projectoo->localizacao->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalhes Adicionais -->
                <div class="col-md-6">
                    <!-- Cor do Projeto -->
                    <div class="info-card">
                        <h5><i class="fas fa-palette mr-2"></i>Cor do Projecto</h5>
                        <hr>
                        @if($projectoo->cor)
                            <div class="color-display" style="background-color: {{ $projectoo->cor }}"></div>
                            <strong>{{ $projectoo->cor }}</strong>
                        @else
                            <span class="text-muted">Nenhuma cor definida</span>
                        @endif
                    </div>

                    <!-- Estatísticas -->
                    <div class="info-card">
                        <h5><i class="fas fa-chart-bar mr-2"></i>Estatísticas</h5>
                        <hr>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="text-primary">
                                    <i class="fas fa-images fa-2x"></i>
                                    <h5 class="mt-2">{{ count($projectoo->imagens ?? []) }}</h5>
                                    <small>Imagens</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-success">
                                    <i class="fas fa-calendar fa-2x"></i>
                                    <h5 class="mt-2">{{ $projectoo->created_at->format('d/m/Y') }}</h5>
                                    <small>Criação</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="text-info">
                                    <i class="fas fa-sync fa-2x"></i>
                                    <h5 class="mt-2">{{ $projectoo->updated_at->format('d/m/Y') }}</h5>
                                    <small>Actualização</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Galeria de Imagens -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="info-card">
                        <h5>
                            <i class="fas fa-camera mr-2"></i>
                            Galeria de Imagens 
                            <span class="badge badge-primary ml-2">
                                {{ count($projectoo->imagens ?? []) }} imagens
                            </span>
                        </h5>
                        <hr>
                        
                        @if(!empty($projectoo->imagens) && count($projectoo->imagens) > 0)
                            <div class="image-gallery">
                                @foreach($projectoo->imagens as $index => $imagem)
                                    <div class="image-item">
                                        <img src="{{ asset('storage/' . $imagem) }}" 
                                             alt="Imagem {{ $index + 1 }} do projecto {{ $projectoo->nome }}"
                                             onclick="openModal('{{ asset('storage/' . $imagem) }}')"
                                             onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                        <div class="image-overlay">
                                            Imagem {{ $index + 1 }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhuma imagem disponível</h5>
                                <p class="text-muted">Este projecto não possui imagens associadas.</p>
                                <a href="{{ route('projectoos.edit', $projectoo->id) }}" class="btn btn-primary">
                                    <i class="fas fa-plus mr-2"></i>Adicionar Imagens
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <div class="btn-group">
                        <a href="{{ route('projectoos.edit', $projectoo->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-2"></i>Editar Projecto
                        </a>
                        <form action="{{ route('projectoos.delete', $projectoo->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Tem certeza que deseja eliminar este projecto?')">
                                <i class="fas fa-trash mr-2"></i>Eliminar Projecto
                            </button>
                        </form>
                        <a href="{{ route('projectoos.list') }}" class="btn btn-secondary">
                            <i class="fas fa-list mr-2"></i>Voltar à Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para imagem ampliada -->
<div id="imageModal" class="image-modal">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script>
    // Funções para o modal de imagem
    function openModal(imageSrc) {
        document.getElementById('imageModal').style.display = 'block';
        document.getElementById('modalImage').src = imageSrc;
    }

    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
    }

    // Fechar modal ao clicar fora da imagem
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Fechar modal com tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Navegação por teclado entre imagens
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('imageModal');
        if (modal.style.display === 'block') {
            if (e.key === 'ArrowLeft') {
                // Navegar para imagem anterior (implementar se necessário)
            } else if (e.key === 'ArrowRight') {
                // Navegar para próxima imagem (implementar se necessário)
            }
        }
    });

    // Debug no console
    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== DETALHES DO PROJECTO ===');
        console.log('Projeto:', {
            id: {{ $projectoo->id }},
            nome: '{{ $projectoo->nome }}',
            estado: '{{ $projectoo->estado }}',
            categoria: '{{ $projectoo->categoria->name ?? 'N/A' }}',
            localizacao: '{{ $projectoo->localizacao->name ?? 'N/A' }}',
            total_imagens: {{ count($projectoo->imagens ?? []) }},
            imagens: {!! json_encode($projectoo->imagens ?? []) !!}
        });
    });
</script>

@endsection