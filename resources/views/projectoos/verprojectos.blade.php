@extends('adminlte::page')

@section('title', 'SysEscaleno - Todos os Projectos')

@section('content')

@cannot('is_admin')
<style>
    /* ✅ ESTILOS PARA PREENCHER TODA A TELA SEM BARRA LATERAL */
    body {
        padding: 0 !important;
        margin: 0 !important;
        background: #f8f9fa;
    }
    
    .wrapper {
        margin-left: 0 !important;
    }
    
    .main-sidebar {
        display: none !important;
    }
    
    .content-wrapper {
        margin-left: 0 !important;
        background: #f8f9fa;
    }
    
    .main-header {
        display: none !important;
    }
    
    .full-screen-container {
        width: 100vw;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        background: #f8f9fa;
    }
    
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 80px 0 60px 0;
        text-align: center;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Filtros e Pesquisa */
    .filters-section {
        background: white;
        padding: 30px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }
    
    .filters-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 20px;
        align-items: end;
    }
    
    .search-box {
        position: relative;
    }
    
    .search-input {
        width: 100%;
        padding: 15px 50px 15px 20px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #2c3e50;
        background: white;
        box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.1);
    }
    
    .search-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 1.2rem;
    }
    
    .filter-select {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 1rem;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-select:focus {
        outline: none;
        border-color: #2c3e50;
        background: white;
    }
    
    /* Project Grid */
    .projects-section {
        padding: 40px 0 80px 0;
    }
    
    .projects-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }
    
    .project-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .project-image-container {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    
    .project-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .project-card:hover .project-image {
        transform: scale(1.05);
    }
    
    .project-status {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-active { background: #d4edda; color: #155724; }
    .status-progress { background: #fff3cd; color: #856404; }
    .status-completed { background: #e2e3e5; color: #383d41; }
    
    .no-image {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }
    
    .project-info {
        padding: 25px;
    }
    
    .project-name {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    
    .project-category {
        display: inline-block;
        background: #e9ecef;
        color: #495057;
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 15px;
    }
    
    .project-location {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }
    
    .project-description {
        color: #666;
        line-height: 1.5;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .project-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }
    
    .project-date {
        color: #6c757d;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .view-details-btn {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
    }
    
    .view-details-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
        color: white;
        text-decoration: none;
    }
    
    /* Paginação e Contadores */
    .projects-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .projects-count {
        font-size: 1.1rem;
        color: #495057;
        font-weight: 500;
    }
    
    .projects-count strong {
        color: #2c3e50;
    }
    
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .empty-icon {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 20px;
    }
    
    .empty-title {
        font-size: 1.5rem;
        color: #495057;
        margin-bottom: 10px;
    }
    
    .empty-description {
        color: #6c757d;
        font-size: 1.1rem;
    }
    
    /* Loading State */
    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px;
        grid-column: 1 / -1;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .filters-container {
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .projects-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.2rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .filters-container {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .projects-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .projects-container {
            padding: 0 15px;
        }
        
        .projects-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .project-info {
            padding: 20px;
        }
        
        .project-name {
            font-size: 1.3rem;
        }
    }
</style>

<!-- INCLUIR HEADER COMPARTILHADO -->
@include('layouts.header')

<div class="full-screen-container">
        <!-- Filtros e Pesquisa -->
    <section class="filters-section">
        <div class="filters-container">
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Pesquisar projectos..." id="searchInput">
                <i class="fas fa-search search-icon"></i>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Categoria</label>
                <select class="filter-select" id="categoryFilter">
                    <option value="">Todas as categorias</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Estado</label>
                <select class="filter-select" id="statusFilter">
                    <option value="">Todos os estados</option>
                    <option value="ACTIVO">Activo</option>
                    <option value="EM_ANDAMENTO">Em Andamento</option>
                    <option value="CONCLUIDO">Concluído</option>
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #2c3e50;">Ordenar por</label>
                <select class="filter-select" id="sortFilter">
                    <option value="newest">Mais Recentes</option>
                    <option value="oldest">Mais Antigos</option>
                    <option value="name">Nome A-Z</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Grid de Projectos -->
    <section class="projects-section">
        <div class="projects-container">
            <div class="projects-header">
                <div class="projects-count">
                    Mostrando <strong id="projectsCount">{{ $projectoos->count() }}</strong> projecto(s)
                </div>
            </div>
            
            <div class="projects-grid" id="projectsGrid">
                @if($projectoos->count() > 0)
                    @foreach($projectoos as $projectoo)
                    <div class="project-card" 
                         data-category="{{ $projectoo->categoria_id }}" 
                         data-status="{{ $projectoo->estado }}"
                         data-name="{{ strtolower($projectoo->nome) }}">
                        <div class="project-image-container" onclick="window.location.href='{{ route('projectoos.showuser', $projectoo->id) }}'">
                            @if(isset($projectoo->imagens) && count($projectoo->imagens) > 0)
                                <img src="{{ asset('storage/' . $projectoo->imagens[0]) }}" 
                                     alt="{{ $projectoo->nome }}" 
                                     class="project-image"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="no-image" style="display: none;">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                            
                            @php
                                $statusClass = $projectoo->estado == 'CONCLUIDO' ? 'status-completed' : 
                                             ($projectoo->estado == 'EM_ANDAMENTO' ? 'status-progress' : 'status-active');
                                $statusText = $projectoo->estado == 'CONCLUIDO' ? 'CONCLUÍDO' : 
                                            ($projectoo->estado == 'EM_ANDAMENTO' ? 'EM ANDAMENTO' : 'ACTIVO');
                            @endphp
                            <span class="project-status {{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                        
                        <div class="project-info">
                            <h3 class="project-name">{{ $projectoo->nome }}</h3>
                            
                            @if($projectoo->categoria)
                                <span class="project-category">{{ $projectoo->categoria->name }}</span>
                            @endif
                            
                            @if($projectoo->localizacao)
                                <div class="project-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $projectoo->localizacao->name }}
                                </div>
                            @endif
                            
                            @if($projectoo->descricao)
                                <p class="project-description">
                                    {{ Str::limit($projectoo->descricao, 120) }}
                                </p>
                            @else
                                <p class="project-description" style="color: #999;">
                                    Sem descrição disponível.
                                </p>
                            @endif
                            
                            <div class="project-meta">
                                <div class="project-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $projectoo->created_at->format('d/m/Y') }}
                                </div>
                                <a href="{{ route('projectoos.showuser', $projectoo->id) }}" class="view-details-btn">
                                    <i class="fas fa-eye"></i> Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3 class="empty-title">Nenhum projecto encontrado</h3>
                        <p class="empty-description">
                            Não existem projectos disponíveis para visualização no momento.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página VERPROJECTOS carregada com sucesso!');
        
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const sortFilter = document.getElementById('sortFilter');
        const projectsGrid = document.getElementById('projectsGrid');
        const projectsCount = document.getElementById('projectsCount');
        
        // Animação inicial dos cards
        const projectCards = document.querySelectorAll('.project-card');
        projectCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Função de filtragem
        function filterProjects() {
            const searchTerm = searchInput.value.toLowerCase();
            const categoryValue = categoryFilter.value;
            const statusValue = statusFilter.value;
            const sortValue = sortFilter.value;
            
            let visibleCount = 0;
            const cards = document.querySelectorAll('.project-card');
            
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const category = card.getAttribute('data-category');
                const status = card.getAttribute('data-status');
                
                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !categoryValue || category === categoryValue;
                const matchesStatus = !statusValue || status === statusValue;
                
                if (matchesSearch && matchesCategory && matchesStatus) {
                    card.style.display = 'block';
                    visibleCount++;
                    
                    // Re-animação ao mostrar
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.transition = 'all 0.4s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Atualizar contador
            projectsCount.textContent = visibleCount;
            
            // Mostrar estado vazio se necessário
            showEmptyState(visibleCount === 0);
        }
        
        function showEmptyState(show) {
            let emptyState = document.querySelector('.empty-state');
            
            if (show && !emptyState) {
                emptyState = document.createElement('div');
                emptyState.className = 'empty-state';
                emptyState.innerHTML = `
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-title">Nenhum projecto encontrado</h3>
                    <p class="empty-description">
                        Tente ajustar os filtros ou termos de pesquisa.
                    </p>
                `;
                projectsGrid.appendChild(emptyState);
            } else if (!show && emptyState) {
                emptyState.remove();
            }
        }
        
        // Event listeners para filtros
        searchInput.addEventListener('input', filterProjects);
        categoryFilter.addEventListener('change', filterProjects);
        statusFilter.addEventListener('change', filterProjects);
        sortFilter.addEventListener('change', filterProjects);
        
        // Clique em todo o card (exceto botões)
        projectCards.forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.classList.contains('view-details-btn') && 
                    !e.target.closest('.view-details-btn')) {
                    const link = this.querySelector('.view-details-btn');
                    if (link) {
                        window.location.href = link.href;
                    }
                }
            });
        });
    });
</script>

<!-- INCLUIR FOOTER COMPARTILHADO -->
@include('layouts.footer')

@endcannot
@endsection