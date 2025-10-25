@extends('adminlte::page')

@section('title', 'Escaleno - Dashboard')

@section('content')

{{-- ✅ OTIMIZAÇÕES GLOBAIS --}}
@php
    // Cache das estatísticas para performance
    $stats = cache()->remember('dashboard_stats', 300, function() {
        return [
            'total' => App\Models\Projectoo::count(),
            'concluidos' => App\Models\Projectoo::where('estado', 'CONCLUIDO')->count(),
            'em_andamento' => App\Models\Projectoo::where('estado', 'EM_CURSO')->count(),
            'activos' => App\Models\Projectoo::where('estado', 'ACTIVO')->count(),
            'com_imagens' => App\Models\Projectoo::whereJsonLength('imagens', '>', 0)->count(),
        ];
    });

    $percentConcluidos = $stats['total'] > 0 ? round(($stats['concluidos'] / $stats['total']) * 100, 1) : 0;
    $percentEmAndamento = $stats['total'] > 0 ? round(($stats['em_andamento'] / $stats['total']) * 100, 1) : 0;

    // Obter projetos ordenados por data de criação (mais recentes primeiro)
    $projectosRecentes = App\Models\Projectoo::with(['categoria', 'localizacao'])
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        --success-gradient: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        --warning-gradient: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        --info-gradient: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        --shadow-sm: 0 2px 10px rgba(0,0,0,0.08);
        --shadow-md: 0 8px 25px rgba(0,0,0,0.12);
        --shadow-lg: 0 20px 40px rgba(0,0,0,0.1);
        --border-radius: 8px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===========================================
        REMOÇÃO COMPLETA DA BARRA LATERAL PARA USUÁRIOS COMUNS
    =========================================== */
    @cannot('is_admin')
    body {
        padding: 0 !important;
        margin: 0 !important;
        background: #ffffff !important;
        overflow-x: hidden;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .wrapper {
        margin-left: 0 !important;
        padding-top: 0 !important;
    }

    .main-sidebar {
        display: none !important;
    }

    .main-header {
        display: none !important;
    }

    .content-wrapper {
        margin-left: 0 !important;
        background: transparent !important;
        padding: 0 !important;
        min-height: 100vh;
    }

    .main-footer {
        display: none !important;
    }
    @endcannot

    /* ===========================================
        LAYOUT ARCHDAILY STYLE - USUÁRIOS COMUNS
    =========================================== */
    .archdaily-layout {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 180px;
        background: #ffffff;
        min-height: 100vh;
    }

    /* Header */
    .archdaily-header {
        margin-bottom: 50px;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 30px;
    }

    .archdaily-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #000000;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .archdaily-subtitle {
        font-size: 1.1rem;
        color: #666666;
        max-width: 600px;
        line-height: 1.5;
    }

    /* Layout Principal - Featured Grid */
    .featured-grid {
        display: grid;
        grid-template-columns: 70% 28%;
        gap: 2%;
        margin-bottom: 60px;
    }

    /* Container de Imagem com Navegação */
    .image-container {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        margin-bottom: 15px;
    }

    .image-container:hover .image-nav-btn {
        opacity: 1;
        transform: translateX(0);
    }

    /* Projeto Principal (70%) */
    .main-featured {
        transition: var(--transition);
        cursor: pointer;
        background: #f8f9fa;
    }

    .main-featured:hover {
        transform: translateY(-5px);
    }

    .main-image-container {
        height: 500px;
    }

    .main-featured-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .main-featured:hover .main-featured-img {
        transform: scale(1.02);
    }

    .main-featured-info {
        padding: 25px 0 0 0;
    }

    .main-featured-category {
        font-size: 1rem;
        font-weight: 600;
        color: #000000;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .main-featured-location {
        font-size: 0.95rem;
        color: #666666;
        font-weight: 400;
    }

    /* Projetos Secundários (30%) */
    .secondary-featured {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .secondary-item {
        transition: var(--transition);
        cursor: pointer;
    }

    .secondary-item:hover {
        transform: translateY(-3px);
    }

    .secondary-image-container {
        height: 220px;
    }

    .secondary-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .secondary-item:hover .secondary-img {
        transform: scale(1.02);
    }

    .secondary-info {
        padding: 0;
    }

    .secondary-category {
        font-size: 0.9rem;
        font-weight: 600;
        color: #000000;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .secondary-location {
        font-size: 0.85rem;
        color: #666666;
        font-weight: 400;
    }

    /* Grid de 3 Colunas - ESTILO ARCHDAILY */
    .projects-grid-archdaily {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px 30px;
        margin-top: 40px;
    }

    .project-card-archdaily {
        transition: var(--transition);
        cursor: pointer;
    }

    .project-card-archdaily:hover {
        transform: translateY(-5px);
    }

    .project-image-container {
        height: 220px;
    }

    .project-image-archdaily {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .project-card-archdaily:hover .project-image-archdaily {
        transform: scale(1.02);
    }

    .project-info-archdaily {
        padding: 0;
    }

    .project-category-archdaily {
        font-size: 0.85rem;
        font-weight: 600;
        color: #000000;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.3;
    }

    .project-location-archdaily {
        font-size: 0.8rem;
        color: #666666;
        font-weight: 400;
        line-height: 1.4;
    }

    /* Botões de Navegação */
    .image-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 10;
    }

    .image-nav-btn:hover {
        background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transform: translateY(-50%) scale(1.1);
    }

    .image-nav-btn.prev {
        left: 15px;
        transform: translateY(-50%) translateX(-10px);
    }

    .image-nav-btn.next {
        right: 15px;
        transform: translateY(-50%) translateX(10px);
    }

    .image-nav-btn i {
        font-size: 1rem;
        color: #333;
    }

    .image-nav-btn:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .image-nav-btn:disabled:hover {
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    /* Indicador de múltiplas imagens */
    .image-counter {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .image-container:hover .image-counter {
        opacity: 1;
    }

    /* Placeholder para imagens */
    .image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 0.9rem;
        border: 1px solid #eaeaea;
    }

    .image-placeholder i {
        font-size: 2rem;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    /* Estado Vazio */
    .empty-state-archdaily {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state-archdaily i {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    /* ===========================================
        ADMINISTRADORES - DASHBOARD PROFISSIONAL
    =========================================== */
    .dashboard-admin {
        --admin-primary: #2c3e50;
        --admin-card-bg: rgba(255, 255, 255, 0.95);
        --admin-border: rgba(44, 62, 80, 0.1);
        padding: 20px;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .admin-header {
        background: linear-gradient(135deg, var(--admin-primary) 0%, #34495e 100%);
        color: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .admin-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate { 
        100% { transform: rotate(360deg); } 
    }

    .admin-welcome {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        position: relative;
        z-index: 2;
    }

    .admin-title { 
        font-size: 2.25rem; 
        font-weight: 800; 
        margin: 0; 
    }

    .admin-subtitle { 
        opacity: 0.9; 
        font-size: 1.125rem; 
        margin-top: 0.5rem;
    }

    .admin-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-admin {
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-admin-primary {
        background: var(--success-gradient);
        color: white;
    }

    .btn-admin-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-admin:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        color: inherit;
    }

    .info-box-admin {
        background: var(--admin-card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: 1px solid var(--admin-border);
        overflow: hidden;
        position: relative;
    }

    .info-box-admin:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .info-box-icon-admin {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }

    .info-box-content-admin {
        flex: 1;
    }

    .info-box-number-admin {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--admin-primary);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .info-box-text-admin {
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .progress-admin {
        height: 6px;
        background: rgba(0,0,0,0.05);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 0.75rem;
    }

    .progress-bar-admin {
        border-radius: 3px;
        transition: width 1s ease;
    }

    .chart-container-admin {
        background: var(--admin-card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        padding: 2rem;
        border: 1px solid var(--admin-border);
        position: relative;
        overflow: hidden;
    }

    .chart-container-admin::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--admin-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chart-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-chart-export {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(0,0,0,0.1);
        background: white;
        transition: var(--transition);
        cursor: pointer;
    }

    .btn-chart-export:hover {
        background: var(--admin-primary);
        color: white;
        border-color: var(--admin-primary);
        transform: translateY(-1px);
    }

    .recent-projects-table {
        background: var(--admin-card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--admin-border);
        overflow: hidden;
    }

    .table-admin {
        margin: 0;
        font-size: 0.95rem;
    }

    .table-admin thead th {
        background: var(--primary-gradient);
        color: white;
        border: none;
        font-weight: 600;
        padding: 1.25rem 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }

    .table-admin tbody tr {
        transition: var(--transition);
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .table-admin tbody tr:hover {
        background: rgba(44, 62, 80, 0.04);
        transform: scale(1.01);
    }

    .table-admin tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
    }

    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    .quick-action-card {
        background: var(--admin-card-bg);
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        border: 1px solid var(--admin-border);
        transition: var(--transition);
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow-sm);
    }

    .quick-action-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
        text-decoration: none;
        color: inherit;
    }

    .quick-action-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1.25rem;
    }

    .quick-action-title {
        font-weight: 700;
        color: var(--admin-primary);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    /* ===========================================
        RESPONSIVIDADE
    =========================================== */
    @media (max-width: 1600px) {
        .archdaily-layout {
            padding: 40px 120px;
        }
    }

    @media (max-width: 1400px) {
        .archdaily-layout {
            padding: 40px 100px;
        }
    }

    @media (max-width: 1200px) {
        .featured-grid {
            grid-template-columns: 65% 32%;
            gap: 3%;
        }
        
        .projects-grid-archdaily {
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }
        
        .archdaily-layout {
            padding: 40px 80px;
        }
    }

    @media (max-width: 992px) {
        .archdaily-layout {
            padding: 30px 60px;
        }
        
        .featured-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        .secondary-featured {
            flex-direction: row;
            gap: 30px;
        }
        
        .main-image-container {
            height: 400px;
        }
        
        .archdaily-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .projects-grid-archdaily {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .secondary-featured {
            flex-direction: column;
            gap: 30px;
        }
        
        .main-image-container {
            height: 300px;
        }
        
        .secondary-image-container,
        .project-image-container {
            height: 200px;
        }
        
        .admin-welcome {
            flex-direction: column;
            text-align: center;
        }
        
        .admin-actions {
            justify-content: center;
        }
        
        .archdaily-layout {
            padding: 30px 40px;
        }
        
        .image-nav-btn {
            width: 35px;
            height: 35px;
        }
        
        .image-nav-btn i {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .archdaily-layout {
            padding: 20px 30px;
        }
        
        .main-featured-info {
            padding: 20px 0 0 0;
        }
        
        .archdaily-title {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .archdaily-layout {
            padding: 20px 20px;
        }
        
        .image-nav-btn {
            width: 30px;
            height: 30px;
        }
        
        .image-nav-btn i {
            font-size: 0.8rem;
        }
    }
</style>

{{-- ✅ INTERFACE USUÁRIO COMUM - LAYOUT ARCHDAILY --}}
@cannot('is_admin')
@include('projectoos.home_user')
@endcannot





{{-- ✅ DASHBOARD ADMINISTRATIVO COMPLETO --}}
@can('is_admin')
@include('projectoos.home_admin')
@endcan

{{-- ✅ JAVASCRIPT OTIMIZADO --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    'use strict';

    let charts = {};
    let isInitialized = false;

    const chartData = {
        status: {
            labels: ['Concluídos', 'Em Andamento', 'Activos'],
            data: [{{ $stats['concluidos'] }}, {{ $stats['em_andamento'] }}, {{ $stats['activos'] }}]
        }
    };

    function initDashboard() {
        if (isInitialized) return;
        isInitialized = true;

        initCharts();
        initExport();
    }

    function initCharts() {
        @can('is_admin')
        // Gráfico de Estados
        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            const statusCtx = statusCanvas.getContext('2d');
            charts.status = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: chartData.status.labels,
                    datasets: [{
                        data: chartData.status.data,
                        backgroundColor: ['#28a745', '#ffc107', '#007bff'],
                        borderColor: '#fff',
                        borderWidth: 4,
                        hoverBorderWidth: 6,
                        hoverOffset: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 30,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { size: 13, weight: '600' }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(44, 62, 80, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            cornerRadius: 12,
                            displayColors: true,
                            callbacks: {
                                label: (ctx) => {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total ? ((ctx.raw / total) * 100).toFixed(1) : 0;
                                    return `${ctx.label}: ${ctx.raw} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1500,
                        easing: 'easeOutQuart'
                    }
                }
            });
        }

        // Gráfico de Categorias
        const categoryCanvas = document.getElementById('categoryChart');
        if (categoryCanvas) {
            const categoryCtx = categoryCanvas.getContext('2d');
            const categoryData = @json(App\Models\Projectoo::with('categoria')->get()->groupBy('categoria_id')->map(fn($group) => [
                'name' => $group->first()->categoria->name ?? 'Sem Categoria',
                'count' => $group->count()
            ])->sortByDesc('count')->values()->toArray());

            if (categoryData.length > 0) {
                const colors = [
                    '#2c3e50', '#e74c3c', '#3498db', '#2ecc71', '#f39c12',
                    '#9b59b6', '#1abc9c', '#d35400', '#34495e', '#27ae60'
                ];
                
                charts.category = new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: categoryData.map(item => item.name),
                        datasets: [{
                            label: 'Número de Projectos',
                            data: categoryData.map(item => item.count),
                            backgroundColor: categoryData.map((_, i) => colors[i % colors.length]),
                            borderColor: categoryData.map((_, i) => colors[i % colors.length]),
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                display: false 
                            },
                            tooltip: {
                                backgroundColor: 'rgba(44, 62, 80, 0.95)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                cornerRadius: 12,
                                callbacks: {
                                    label: function(context) {
                                        return `Projectos: ${context.parsed.y}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { 
                                    color: 'rgba(0,0,0,0.05)',
                                    drawBorder: false
                                },
                                ticks: { 
                                    stepSize: 1, 
                                    precision: 0,
                                    color: '#6c757d',
                                    font: { size: 11 }
                                }
                            },
                            x: {
                                grid: { 
                                    display: false 
                                },
                                border: { 
                                    display: false 
                                },
                                ticks: {
                                    color: '#6c757d',
                                    font: { size: 11 },
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            } else {
                categoryCtx.font = '16px Arial';
                categoryCtx.fillStyle = '#6c757d';
                categoryCtx.textAlign = 'center';
                categoryCtx.fillText('Não há dados disponíveis', categoryCanvas.width / 2, categoryCanvas.height / 2);
            }
        }
        @endcan
    }

    function exportChart(chartId, filename) {
        const chart = charts[chartId.replace('Chart', '').toLowerCase()] || 
                     Chart.getChart(chartId);
        
        if (chart) {
            const link = document.createElement('a');
            link.download = `${filename}-${new Date().toISOString().split('T')[0]}.png`;
            link.href = chart.toBase64Image();
            link.click();
            
            const btn = event.target.closest('.btn-chart-export');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Exportado!';
            btn.classList.add('btn-success');
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('btn-success');
            }, 2000);
        }
    }

    function initExport() {
        window.exportChart = exportChart;
    }

    // Inicializar
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDashboard);
    } else {
        initDashboard();
    }

    // Resize handler
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            Object.values(charts).forEach(chart => chart?.resize());
        }, 250);
    });

    console.log('🚀 Dashboard Escaleno inicializado com sucesso!');
})();
</script>
@endsection