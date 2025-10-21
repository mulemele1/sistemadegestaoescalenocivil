@extends('adminlte::page')

@section('title', 'SysEscaleno - Dashboard')

@section('content')

@cannot('is_admin')
<!-- PAINEL PARA USUÁRIOS COMUNS SEM BARRA LATERAL -->
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
    
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .project-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 100%;
    }
    
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    
    .project-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 3px solid #f8f9fa;
    }
    
    .project-info {
        padding: 15px;
    }
    
    .project-name {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }
    
    .project-category {
        font-size: 0.9rem;
        color: #666;
        background: #f8f9fa;
        padding: 5px 10px;
        border-radius: 15px;
        display: inline-block;
    }
    
    .no-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }
    
    .navbar-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px 0;
        margin-bottom: 0;
        width: 100%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .nav-logo {
        color: white;
        font-size: 1.8rem;
        font-weight: bold;
        text-decoration: none;
    }
    
    .nav-links {
        display: flex;
        gap: 30px;
    }
    
    .nav-link {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
        padding: 8px 16px;
        border-radius: 5px;
    }
    
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #f8f9fa;
    }
    
    .welcome-section {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0;
        width: 100%;
        color: white;
    }
    
    .welcome-section h2 {
        font-size: 2.5rem;
        margin-bottom: 15px;
        font-weight: 700;
    }
    
    .welcome-section p {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .empty-fullscreen {
        width: 100%;
        min-height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 30px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        border-left: 4px solid #667eea;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 10px;
    }

    .stat-label {
        color: #666;
        font-size: 1rem;
    }

    .recent-projects-title {
        text-align: center;
        margin: 40px 0 20px 0;
        color: #333;
        font-size: 2rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .project-grid {
            grid-template-columns: 1fr;
            gap: 15px;
            padding: 15px;
        }
        
        .nav-links {
            gap: 15px;
        }
        
        .nav-link {
            font-size: 0.9rem;
            padding: 6px 12px;
        }
        
        .welcome-section {
            padding: 40px 15px;
        }
        
        .nav-container {
            padding: 0 15px;
            flex-direction: column;
            gap: 15px;
        }
        
        .welcome-section h2 {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
            padding: 20px 15px;
        }
        
        .recent-projects-title {
            font-size: 1.5rem;
            margin: 30px 0 15px 0;
        }
    }
</style>

<!-- Barra de Navegação Superior -->
<nav class="navbar-custom">
    <div class="nav-container">
        <a href="#" class="nav-logo">SysEscaleno</a>
        <div class="nav-links">
            <a href="{{ url('/home') }}" class="nav-link">🏠 Home</a>
            @if(Route::has('projectoos.list'))
                <a href="{{ route('projectoos.list') }}" class="nav-link">📋 Projectos</a>
            @else
                <a href="{{ url('/projectoos') }}" class="nav-link">📋 Projectos</a>
            @endif
            <a href="#" class="nav-link">ℹ️ Sobre</a>
            <a href="#" class="nav-link">📞 Contacto</a>
        </div>
    </div>
</nav>

<div class="full-screen-container">
    <!-- Estatísticas Rápidas -->
    <div class="stats-grid">
        
        <div class="stat-card">
            @php
                $concluidos = App\Models\Projectoo::where('estado', 'CONCLUIDO')->count();
            @endphp
            <div class="stat-number">{{ $concluidos }}</div>
            <div class="stat-label">Projectos Concluídos</div>
        </div>
        <div class="stat-card">
            @php
                // CONTAGEM CORRIGIDA: Projectos em curso inclui EM_ANDAMENTO e ACTIVO
                $emCurso = App\Models\Projectoo::whereIn('estado', ['EM_CURSO', 'ACTIVO'])->count();
            @endphp
            <div class="stat-number">{{ $emCurso }}</div>
            <div class="stat-label">Projectos em Curso</div>
        </div>
        <div class="stat-card">
            @php
                $totalProjectos = App\Models\Projectoo::count();
            @endphp
            <div class="stat-number">{{ $totalProjectos }}</div>
            <div class="stat-label">Total de Projectos</div>
        </div>
    </div>

    <!-- Título dos Projectos Recentes -->
    <h3 class="recent-projects-title">Projectos Recentes</h3>

    <!-- Grid de Projectos (apenas últimos 3) -->
    <div class="project-grid">
        @if(isset($projectoos) && $projectoos->count() > 0)
            @foreach($projectoos as $projectoo)
            <div class="project-card">
                @if(isset($projectoo->imagens) && count($projectoo->imagens) > 0)
                    <img src="{{ asset('storage/' . $projectoo->imagens[0]) }}" 
                         alt="{{ $projectoo->nome }}" 
                         class="project-image">
                @else
                    <div class="no-image">
                        📷 Sem imagem
                    </div>
                @endif
                
                <div class="project-info">
                    <div class="project-name">{{ $projectoo->nome }}</div>
                    <div class="project-category">
                        {{ $projectoo->categoria->name ?? 'Sem categoria' }}
                    </div>
                    @if(isset($projectoo->estado))
                    <div style="margin-top: 10px;">
                        <span class="badge 
                            @if($projectoo->estado == 'CONCLUIDO') badge-success
                            @elseif($projectoo->estado == 'EM_ANDAMENTO') badge-warning
                            @elseif($projectoo->estado == 'ACTIVO') badge-primary
                            @else badge-secondary @endif">
                            {{ ucfirst($projectoo->estado) }}
                        </span>
                    </div>
                    @endif
                    <div style="margin-top: 8px; font-size: 0.8rem; color: #666;">
                        <i class="fas fa-calendar"></i> 
                        {{ $projectoo->created_at->format('d/m/Y') }}
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="empty-fullscreen" style="grid-column: 1 / -1;">
            <div class="alert alert-info text-center" style="width: 100%; max-width: 500px;">
                <h4>📭 Nenhum projecto encontrado</h4>
                <p>Não existem projectos para mostrar no momento.</p>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🎉 Painel do usuário carregado com sucesso!');
        
        // Adicionar animação suave aos cards
        const cards = document.querySelectorAll('.project-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

@endcannot

@can('is_admin')
<!-- PAINEL PARA ADMINISTRADORES COM BARRA LATERAL -->
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="m-0 text-dark">Dashboard Administrativo</h1>
            <small class="text-muted">Bem-vindo, {{ Auth::user()->name ?? 'Administrador' }}</small>
        </div>
        <div class="btn-group">
            <button class="btn btn-lightblue" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            <a href="{{ route('projectoos.export.csv') }}" class="btn btn-lightblue">
                <i class="fas fa-download"></i> Exportar
            </a>
        </div>
    </div>

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <!-- Bloco de informação para Projectos Concluídos -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-check-circle"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Projectos Concluídos</span>
                    @php
                        $totalProjectos = App\Models\Projectoo::count();
                        $concluidos = App\Models\Projectoo::where('estado', 'CONCLUIDO')->count();
                    @endphp
                    <span class="info-box-number">
                        {{ $concluidos }}
                    </span>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-success" style="width: {{ $totalProjectos > 0 ? ($concluidos / $totalProjectos) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloco de informação para Projectos em Curso -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-tasks"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Projectos em Curso</span>
                    @php
                        // CONTAGEM CORRIGIDA: Projectos em curso inclui EM_ANDAMENTO
                        $totalProjectos = App\Models\Projectoo::count();
                        $emCurso = App\Models\Projectoo::whereIn('estado', ['EM_CURSO', 'ATIVO'])->count();
                    @endphp
                    <span class="info-box-number">
                        {{ $emCurso }}
                    </span>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-warning" style="width: {{ $totalProjectos > 0 ? ($emCurso / $totalProjectos) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloco de informação para Total de Projectos -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1">
                    <i class="fas fa-folder-open"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Projectos</span>
                    <span class="info-box-number">{{ $totalProjectos }}</span>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-info" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bloco de informação para Projectos com Imagens -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1">
                    <i class="fas fa-images"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Com Imagens</span>
                    @php
                        $comImagens = App\Models\Projectoo::whereNotNull('imagens')->count();
                    @endphp
                    <span class="info-box-number">
                        {{ $comImagens }}
                    </span>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-primary" style="width: {{ $totalProjectos > 0 ? ($comImagens / $totalProjectos) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Últimos Projectos (APENAS 3 REGISTROS) -->
    <div class="row">
        <div class="col-12">
            <div class="card card-lightblue card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock mr-2"></i>
                        Últimos 3 Projectos Adicionados
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('projectoos.list') }}" class="btn btn-lightblue btn-sm">
                            <i class="fas fa-list mr-1"></i> Ver Todos
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome do Projecto</th>
                                    <th>Categoria</th>
                                    <th>Localização</th>
                                    <th>Estado</th>
                                    <th>Data Criação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projectoos as $projecto)
                                <tr>
                                    <td>{{ $projecto->id }}</td>
                                    <td>
                                        <strong>{{ $projecto->nome }}</strong>
                                        @if($projecto->descricao)
                                        <br><small class="text-muted">{{ Str::limit($projecto->descricao, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $projecto->categoria->name ?? 'Sem categoria' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $projecto->localizacao->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($projecto->estado == 'CONCLUIDO') badge-success
                                            @elseif($projecto->estado == 'EM_ANDAMENTO') badge-warning
                                            @elseif($projecto->estado == 'ACTIVO') badge-primary
                                            @else badge-secondary @endif">
                                            {{ $projecto->estado }}
                                        </span>
                                    </td>
                                    <td>{{ $projecto->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('projectoos.show', $projecto->id) }}" class="btn btn-sm btn-info" title="Ver detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('projectoos.edit', $projecto->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Nenhum projecto encontrado</h5>
                                        <p class="text-muted">Não existem projectos para mostrar.</p>
                                        <a href="{{ route('projectoos.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus mr-2"></i>Criar Primeiro Projecto
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Estatísticas Adicionais -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>
                        Distribuição por Estado
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="projectStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2"></i>
                        Projectos por Categoria
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="projectCategoryChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-2"></i>
                        Ações Rápidas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('projectoos.create') }}" class="btn btn-success btn-block mb-2">
                                <i class="fas fa-plus mr-2"></i>Novo Projecto
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('projectoos.list') }}" class="btn btn-info btn-block mb-2">
                                <i class="fas fa-list mr-2"></i>Ver Todos
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('projectoos.export.csv') }}" class="btn btn-warning btn-block mb-2">
                                <i class="fas fa-file-export mr-2"></i>Exportar Dados
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('users.list') }}" class="btn btn-primary btn-block mb-2">
                                <i class="fas fa-users mr-2"></i>Gerir Utilizadores
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-lightblue {
        border-top: 3px solid #3c8dbc;
    }
    .card-lightblue .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(60, 141, 188, 0.1);
    }
    .btn-block {
        padding: 12px;
        font-weight: 500;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Dashboard administrativo carregado');
        
        // Gráfico de distribuição por estado
        const statusCtx = document.getElementById('projectStatusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Concluídos', 'Em Andamento', 'Activos', 'Outros'],
                datasets: [{
                    data: [
                        {{ $concluidos }},
                        {{ App\Models\Projectoo::where('estado', 'EM_ANDAMENTO')->count() }},
                        {{ App\Models\Projectoo::where('estado', 'ACTIVO')->count() }},
                        {{ App\Models\Projectoo::whereNotIn('estado', ['CONCLUIDO', 'EM_ANDAMENTO', 'ACTIVO'])->count() }}
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#007bff',
                        '#6c757d'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de categorias
        const categoryCtx = document.getElementById('projectCategoryChart').getContext('2d');
        
        // Agrupar projetos por categoria
        const categories = {!! json_encode(App\Models\Projectoo::with('categoria')->get()->groupBy('categoria_id')->map(function($group) {
            return $group->count();
        })) !!};
        
        const categoryNames = {!! json_encode(App\Models\Projectoo::with('categoria')->get()->groupBy('categoria_id')->map(function($group) {
            return $group->first()->categoria->name ?? 'Sem Categoria';
        })) !!};
        
        const categoryChart = new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: Object.values(categoryNames),
                datasets: [{
                    label: 'Número de Projectos',
                    data: Object.values(categories),
                    backgroundColor: '#3c8dbc',
                    borderColor: '#367fa9',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endcan

@endsection