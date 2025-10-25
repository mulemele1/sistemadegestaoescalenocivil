<div class="dashboard-admin">
    <!-- Header -->
    <section class="admin-header">
        <div class="admin-welcome">
            <div>
                <h1 class="admin-title">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Dashboard Administrativo
                </h1>
                <p class="admin-subtitle">
                    Bem-vindo de volta, <strong>{{ Auth::user()->name }}</strong>
                    | {{ now()->format('d M Y \à\s H:i') }}
                </p>
            </div>
            <div class="admin-actions">
                <a href="#" class="btn-admin btn-admin-secondary" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Actualizar
                </a>
                <a href="{{ route('projectoos.export.csv') }}" class="btn-admin btn-admin-primary">
                    <i class="fas fa-download"></i> Exportar Dados
                </a>
            </div>
        </div>
    </section>

    <!-- Estatísticas Principais -->
    <section class="row g-4 mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="info-box-admin d-flex align-items-center p-4 h-100">
                <div class="info-box-icon-admin bg-success text-white">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="info-box-content-admin">
                    <div class="info-box-text-admin">Projectos Concluídos</div>
                    <div class="info-box-number-admin">{{ $stats['concluidos'] }}</div>
                    <div class="progress-admin">
                        <div class="progress-bar-admin bg-success" style="width: {{ $percentConcluidos }}%"></div>
                    </div>
                    <small class="text-success fw-bold">{{ $percentConcluidos }}% do total</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="info-box-admin d-flex align-items-center p-4 h-100">
                <div class="info-box-icon-admin bg-warning text-white">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="info-box-content-admin">
                    <div class="info-box-text-admin">Em Andamento</div>
                    <div class="info-box-number-admin">{{ $stats['em_andamento'] }}</div>
                    <div class="progress-admin">
                        <div class="progress-bar-admin bg-warning" style="width: {{ $percentEmAndamento }}%"></div>
                    </div>
                    <small class="text-warning fw-bold">{{ $percentEmAndamento }}% do total</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="info-box-admin d-flex align-items-center p-4 h-100">
                <div class="info-box-icon-admin bg-info text-white">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="info-box-content-admin">
                    <div class="info-box-text-admin">Total Projectos</div>
                    <div class="info-box-number-admin">{{ $stats['total'] }}</div>
                    <div class="progress-admin">
                        <div class="progress-bar-admin bg-info" style="width: 100%"></div>
                    </div>
                    <small class="text-info fw-bold">Actualizado agora</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="info-box-admin d-flex align-items-center p-4 h-100">
                <div class="info-box-icon-admin bg-primary text-white">
                    <i class="fas fa-images"></i>
                </div>
                <div class="info-box-content-admin">
                    <div class="info-box-text-admin">Com Imagens</div>
                    @php
                        $percentImagens = $stats['total'] > 0 ? round(($stats['com_imagens'] / $stats['total']) * 100, 1) : 0;
                    @endphp
                    <div class="info-box-number-admin">{{ $stats['com_imagens'] }}</div>
                    <div class="progress-admin">
                        <div class="progress-bar-admin bg-primary" style="width: {{ $percentImagens }}%"></div>
                    </div>
                    <small class="text-primary fw-bold">{{ $percentImagens }}% do total</small>
                </div>
            </div>
        </div>
    </section>

    <!-- Gráficos -->
    <section class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="chart-container-admin">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-pie text-success"></i>
                        Distribuição por Estado
                    </h3>
                    <div class="chart-actions">
                        <button class="btn-chart-export" onclick="exportChart('statusChart', 'estados-projetos')">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="chart-container-admin">
                <div class="chart-header">
                    <h3 class="chart-title">
                        <i class="fas fa-chart-bar text-primary"></i>
                        Projectos por Categoria
                    </h3>
                    <div class="chart-actions">
                        <button class="btn-chart-export" onclick="exportChart('categoryChart', 'categorias-projetos')">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Tabela Recentes -->
    <section class="row mb-4">
        <div class="col-12">
            <div class="recent-projects-table">
                <div class="card-header d-flex justify-content-between align-items-center p-4" style="background: var(--primary-gradient); color: white;">
                    <h3 class="card-title mb-0" style="font-size: 1.25rem; font-weight: 700;">
                        <i class="fas fa-clock me-3"></i>
                        Últimos Projectos
                    </h3>
                    <a href="{{ route('projectoos.list') }}" class="btn btn-light btn-sm fw-bold">
                        <i class="fas fa-list me-2"></i>Ver Todos
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-admin mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-project-diagram me-2"></i>Projecto</th>
                                <th><i class="fas fa-tag me-2"></i>Categoria</th>
                                <th><i class="fas fa-map-marker-alt me-2"></i>Localização</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                <th><i class="fas fa-calendar me-2"></i>Data</th>
                                <th><i class="fas fa-cogs me-2"></i>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projectosRecentes->take(10) as $projecto)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($projecto->nome, 30) }}</div>
                                        @if($projecto->descricao)
                                            <small class="text-muted">{{ Str::limit($projecto->descricao, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                                            {{ $projecto->categoria->name ?? 'Sem categoria' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                            {{ $projecto->localizacao->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($projecto->estado) {
                                                'CONCLUIDO' => 'bg-success-subtle text-success',
                                                'EM_CURSO' => 'bg-warning-subtle text-warning',
                                                'ACTIVO' => 'bg-primary-subtle text-primary',
                                                default => 'bg-secondary-subtle text-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill fw-semibold">
                                            {{ $projecto->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            {{ $projecto->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('projectoos.show', $projecto->id) }}" 
                                               class="btn btn-outline-info" 
                                               title="Ver detalhes">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('projectoos.edit', $projecto->id) }}" 
                                               class="btn btn-outline-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                                            <h4>Nenhum projecto encontrado</h4>
                                            <p class="mb-4">Comece criando o primeiro projecto!</p>
                                            <a href="{{ route('projectoos.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-2"></i>Criar Projecto
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Ações Rápidas -->
    <section class="row">
        <div class="col-12">
            <div class="card chart-container-admin">
                <div class="card-header p-4" style="background: var(--primary-gradient); color: white;">
                    <h3 class="card-title mb-0" style="font-size: 1.25rem; font-weight: 700;">
                        <i class="fas fa-bolt me-3"></i>
                        Ações Rápidas
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="quick-actions-grid">
                        <a href="{{ route('projectoos.create') }}" class="quick-action-card">
                            <div class="quick-action-icon bg-success text-white">
                                <i class="fas fa-plus"></i>
                            </div>
                            <h4 class="quick-action-title">Novo Projecto</h4>
                            <p class="text-muted mb-0 small">Criar projecto em 2 min</p>
                        </a>
                        <a href="{{ route('projectoos.list') }}" class="quick-action-card">
                            <div class="quick-action-icon bg-info text-white">
                                <i class="fas fa-list"></i>
                            </div>
                            <h4 class="quick-action-title">Ver Todos</h4>
                            <p class="text-muted mb-0 small">Lista completa</p>
                        </a>
                        <a href="{{ route('projectoos.export.csv') }}" class="quick-action-card">
                            <div class="quick-action-icon bg-warning text-white">
                                <i class="fas fa-file-export"></i>
                            </div>
                            <h4 class="quick-action-title">Exportar</h4>
                            <p class="text-muted mb-0 small">CSV/Excel</p>
                        </a>
                        <a href="{{ route('users.list') }}" class="quick-action-card">
                            <div class="quick-action-icon bg-primary text-white">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="quick-action-title">Utilizadores</h4>
                            <p class="text-muted mb-0 small">Gerir equipas</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
