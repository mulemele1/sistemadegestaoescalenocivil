@extends('adminlte::page')

@section('title', 'SysEscaleno')

@cannot('is_admin')
@section('content')
<style>
    /* ✅ ESTILOS PARA PREENCHER TODA A TELA */
    .full-screen-container {
        width: 100vw;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
        width: 100%;
        max-width: 100%;
        margin: 0;
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
        padding: 10px 0;
        margin-bottom: 0;
        width: 100%;
    }
    
    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .nav-logo {
        color: white;
        font-size: 1.5rem;
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
    }
    
    .nav-link:hover {
        color: #f8f9fa;
    }
    
    .welcome-section {
        text-align: center;
        padding: 40px 20px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        margin: 0;
        width: 100%;
    }
    
    .content-wrapper {
        width: 68%;
        min-height: calc(100vh - 80px);
    }

    .full-width-content {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
    }

    .chart-section {
        width: 100%;
        padding: 20px;
        background: white;
        margin-top: 20px;
    }

    .chart-container {
        width: 100%;
        max-width: 100%;
    }

    /* Estados vazios em tela cheia */
    .empty-fullscreen {
        width: 100%;
        min-height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
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
        }
        
        .welcome-section {
            padding: 30px 15px;
        }
        
        .nav-container {
            padding: 0 15px;
        }
    }

    @media (max-width: 480px) {
        .project-grid {
            padding: 10px;
        }
        
        .welcome-section {
            padding: 25px 10px;
        }
        
        .project-image {
            height: 180px;
        }
        
        .no-image {
            height: 180px;
        }
    }
</style>

<!-- Barra de Navegação Superior -->
<nav class="navbar-custom">
    <div class="nav-container">
        <a href="#" class="nav-logo">SysEscaleno</a>
        <div class="nav-links">
            <a href="{{ url('/home') }}" class="nav-link">Home</a>
            {{-- Link seguro para Projectos --}}
            @if(Route::has('projectoos.index'))
                <a href="{{ route('projectoos.index') }}" class="nav-link">Projectos</a>
            @else
                <a href="{{ url('/projectoos') }}" class="nav-link">Projectos</a>
            @endif
            <a href="#" class="nav-link">Sobre</a>
            <a href="#" class="nav-link">Contacto</a>
        </div>
    </div>
</nav>

<div class="full-screen-container">
    <div class="content-wrapper">
        <!-- Seção de Boas-vindas -->
        <div class="welcome-section">
            <h2 class="text-primary">Bem-vindo ao Escaleno!</h2>
            <p class="text-muted">Explore os nossos projectos em destaque</p>
        </div>

        <!-- Grid de Projectos -->
        <div class="project-grid">
            @isset($projectoos)
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
                    </div>
                </div>
                @endforeach
                
                @if($projectoos->count() === 0)
                <div class="empty-fullscreen" style="grid-column: 1 / -1;">
                    <div class="alert alert-info text-center" style="width: 100%; max-width: 500px;">
                        <h4>Nenhum projecto encontrado</h4>
                        <p>Não existem projectos para mostrar no momento.</p>
                    </div>
                </div>
                @endif
            @else
            <div class="empty-fullscreen" style="grid-column: 1 / -1;">
                <div class="alert alert-warning text-center" style="width: 100%; max-width: 500px;">
                    <h4>Projectos não disponíveis</h4>
                    <p>Os projectos não foram carregados.</p>
                </div>
            </div>
            @endisset
        </div>

        <!-- Gráfico de Pizza -->
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Código para o gráfico (mantido)
    document.addEventListener('DOMContentLoaded', function() {
        console.log('📊 Página em tela cheia carregada');
        
        // Inicializar gráfico se necessário
        const ctx = document.getElementById('recepcaoDespesasChart');
        if (ctx) {
            // Código do gráfico aqui
            console.log('Gráfico pronto para inicialização');
        }
    });
</script>
@endsection
@endcannot


@section('content')
<div class="row">
    <!-- Verifica se o usuário é administrador -->
    @can('is_admin')

            @section('content_header')
            <h2 class="text-primary text-left">Bem-vindo ao Escaleno!</h2>
            <h1 class="m-0 text-dark">Dashboard</h1>
            @endsection

            <!-- Bloco de informação para Desembolso -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-lightblue elevation-1">
                        <i class="fas fa-fw fa-money-bill-wave"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Projectos Concluidos</span>
                        <span class="info-box-number">{{ number_format($desembolsos->sum('valor')) }}</span>
                    </div>
                </div>
            </div>

            <!-- Bloco de informação para Despesa -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-lightblue elevation-1">
                        <i class="fas fa-fw fa-money-bill-wave"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Projectos em curso</span>
                        <span
                            class="info-box-number">{{ number_format($dispensas->sum('valor') + $dispensas->sum('valor_variavel'))}}</span>
                    </div>
                </div>
            </div>

            <div class="clearfix hidden-md-up"></div>

            

            <!-- Bloco de informação para Projectos -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-lightblue elevation-1">
                        <i class="fas fa-fw fa-list"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Projectos Total</span>
                        <span class="info-box-number">{{ $projectos->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Bloco de informação para Distribuições -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-lightblue elevation-1">
                        <i class="fas fa-fw fa-users"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Colaboradores</span>
                        <span class="info-box-number">{{ $distribuicaos->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Projectos -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="card mt-3">
                                    <form action="{{ route('recuperar') }}" method="get">
                                        <div class="card-header">
                                            <h3 class="card-title">Projectos</h3>
                                            <div class="card-tools">
                                                <!-- Campo de pesquisa por ano -->
                                                <div class="input-group">
                                                    <input type="number" class="form-control" min="1980" max="{{ date('Y') }}"
                                                        name="ano" placeholder="Pesquisar por ano">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn bg-lightblue">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table">
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
    @endcan