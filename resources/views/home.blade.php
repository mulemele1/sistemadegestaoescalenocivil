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
        --border-radius: 16px;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===========================================
        USUÁRIOS COMUNS - FULLSCREEN MODE
    =========================================== */
    body.user-fullscreen {
        padding: 0 !important;
        margin: 0 !important;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        overflow-x: hidden;
    }

    .user-fullscreen .wrapper,
    .user-fullscreen .main-sidebar,
    .user-fullscreen .main-header { display: none !important; }

    .user-fullscreen .content-wrapper { margin: 0 !important; background: transparent !important; }

    .fullscreen-hero {
        background: var(--primary-gradient);
        color: white;
        padding: clamp(60px, 15vw, 120px) 20px 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .fullscreen-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .hero-title {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 800;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        z-index: 1;
    }

    .hero-subtitle {
        font-size: clamp(1.1rem, 3vw, 1.5rem);
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto 2rem;
        line-height: 1.6;
        position: relative;
        z-index: 1;
    }

    .stats-grid-user {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        padding: 3rem 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .stat-card-user {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        padding: 2.5rem;
        text-align: center;
        box-shadow: var(--shadow-lg);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card-user::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
    }

    .stat-card-user:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .stat-number-user {
        font-size: clamp(2.5rem, 8vw, 4rem);
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        line-height: 1;
    }

    .stat-label-user {
        color: #6c757d;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .projects-section-title {
        text-align: center;
        margin: 4rem 0 3rem;
        color: #2c3e50;
        font-size: clamp(1.75rem, 4vw, 2.5rem);
        font-weight: 700;
        position: relative;
    }

    .projects-section-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: var(--primary-gradient);
        margin: 1rem auto 0;
        border-radius: 2px;
    }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2rem;
        padding: 0 2rem 4rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .project-card-user {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
    }

    .project-card-user::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: var(--transition);
    }

    .project-card-user:hover::before {
        transform: scaleX(1);
    }

    .project-card-user:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: var(--shadow-lg);
    }

    .project-image-container {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .project-image-user {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .project-card-user:hover .project-image-user {
        transform: scale(1.1);
    }

    .project-no-image {
        height: 220px;
        background: var(--primary-gradient);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        transition: var(--transition);
    }

    .project-no-image i { font-size: 3rem; margin-bottom: 1rem; opacity: 0.8; }

    .project-info-user {
        padding: 1.75rem;
    }

    .project-name-user {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-meta-user {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .project-category-user {
        background: rgba(44, 62, 80, 0.1);
        color: #2c3e50;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .project-status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-concluido { background: rgba(40, 167, 69, 0.1); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.2); }
    .status-andamento { background: rgba(255, 193, 7, 0.1); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.2); }
    .status-activo { background: rgba(0, 123, 255, 0.1); color: #007bff; border: 1px solid rgba(0, 123, 255, 0.2); }

    .project-date-user {
        font-size: 0.85rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .view-details-btn-user {
        width: 100%;
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1.25rem;
        transition: var(--transition);
        font-size: 0.95rem;
    }

    .view-details-btn-user:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(44, 62, 80, 0.3);
        text-decoration: none;
    }

    .empty-state-user {
        grid-column: 1 / -1;
        text-align: center;
        padding: 6rem 2rem;
        background: rgba(255, 255, 255, 0.7);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        backdrop-filter: blur(20px);
    }

    /* ===========================================
        ADMINISTRADORES - DASHBOARD PROFISSIONAL
    =========================================== */
    .dashboard-admin {
        --admin-primary: #2c3e50;
        --admin-card-bg: rgba(255, 255, 255, 0.95);
        --admin-border: rgba(44, 62, 80, 0.1);
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

    @keyframes rotate { 100% { transform: rotate(360deg); } }

    .admin-welcome {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .admin-title { 
        font-size: 2.25rem; 
        font-weight: 800; 
        margin: 0; 
    }

    .admin-subtitle { 
        opacity: 0.9; 
        font-size: 1.125rem; 
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

    /* Responsive */
    @media (max-width: 768px) {
        .projects-grid { grid-template-columns: 1fr; gap: 1.5rem; padding: 0 1rem; }
        .admin-welcome { flex-direction: column; text-align: center; }
        .admin-actions { justify-content: center; }
    }
</style>

{{-- ✅ INTERFACE USUÁRIO COMUM --}}


@cannot('is_admin')
<!-- 🎨 PAINEL USUÁRIO - TELA CHEIA MODERNA -->
<style>
    /* Layout Fullscreen */
    body { padding: 0 !important; margin: 0 !important; background: #f8f9fa; }
    .wrapper { margin-left: 0 !important; }
    .main-sidebar, .main-header { display: none !important; }
    .content-wrapper { margin-left: 0 !important; background: #f8f9fa; }

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
        padding: 80px 20px 60px;
        text-align: center;
    }
    .hero-title { font-size: clamp(2rem, 5vw, 3rem); font-weight: 700; margin-bottom: 20px; }
    .hero-subtitle { 
        font-size: 1.2rem; 
        opacity: 0.9; 
        max-width: 600px; 
        margin: 0 auto; 
        line-height: 1.6;
    }

    /* Stats Grid - MAIS COMPACTO E DISCRETO */
    .stats-grid {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 15px 20px;
        max-width: 1400px;
        margin: 0 auto;
    }
    .stat-card {
        background: rgba(255, 255, 255, 0.8);
        padding: 12px 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
        transition: all 0.2s ease;
        min-width: 100px;
        flex-shrink: 0;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .stat-card:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        background: white;
    }
    .stat-number { 
        font-size: 1.2rem; 
        font-weight: 700; 
        color: #2c3e50; 
        margin-bottom: 3px;
        line-height: 1;
    }
    .stat-label { 
        color: #6c757d; 
        font-size: 0.75rem; 
        font-weight: 500;
        line-height: 1.2;
    }

    /* Projects Grid */
    .recent-projects-title {
        text-align: center;
        margin: 30px 0 25px;
        color: #333;
        font-size: clamp(1.5rem, 4vw, 2.5rem);
        font-weight: 700;
    }
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        padding: 0 20px 40px;
        max-width: 1400px;
        margin: 0 auto;
    }
    .project-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .project-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .project-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .project-card:hover .project-image { transform: scale(1.05); }
    .no-image {
        width: 100%;
        height: 220px;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
        cursor: pointer;
    }
    .project-info {
        padding: 20px;
    }
    .project-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    .project-category {
        font-size: 0.9rem;
        color: #666;
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 500;
    }
    .view-details-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-top: 15px;
    }
    .view-details-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(44, 62, 80, 0.3);
        color: white !important;
    }

    /* Empty State */
    .empty-fullscreen {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 50vh;
        padding: 40px 20px;
    }
    .empty-card {
        background: white;
        border-radius: 20px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        max-width: 500px;
        width: 100%;
    }

    /* Status Badges */
    .badge { 
        font-size: 0.8rem; 
        padding: 6px 12px; 
        border-radius: 20px; 
        font-weight: 600;
    }
    .badge-success { background: #d4edda; color: #155724; }
    .badge-warning { background: #fff3cd; color: #856404; }
    .badge-primary { background: #cce7ff; color: #004085; }
    .badge-secondary { background: #e2e3e5; color: #383d41; }

    /* Responsive */
    @media (max-width: 768px) {
        .project-grid { grid-template-columns: 1fr; gap: 20px; padding: 0 15px 30px; }
        .stats-grid { 
            justify-content: center; 
            flex-wrap: wrap;
            padding: 10px 15px;
            gap: 8px;
        }
        .stat-card {
            min-width: 90px;
            padding: 10px 12px;
        }
        .stat-number { font-size: 1.1rem; }
        .stat-label { font-size: 0.7rem; }
        .hero-section { padding: 60px 15px 40px; }
    }

    @media (max-width: 480px) {
        .stats-grid {
            justify-content: space-between;
        }
        .stat-card {
            flex: 1;
            min-width: auto;
            margin: 0 2px;
            padding: 8px 10px;
        }
        .stat-number { font-size: 1rem; }
        .stat-label { font-size: 0.65rem; }
    }
</style>

@include('layouts.header')
<div class="full-screen-container">
    <!-- Estatísticas - MAIS COMPACTO E DISCRETO -->
    <div class="stats-grid">
        <div class="stat-card">
            @php $concluidos = App\Models\Projectoo::where('estado', 'CONCLUIDO')->count(); @endphp
            <div class="stat-number">{{ $concluidos }}</div>
            <div class="stat-label">Concluídos</div>
        </div>
        <div class="stat-card">
            @php $emCurso = App\Models\Projectoo::whereIn('estado', ['EM_CURSO', 'ACTIVO'])->count(); @endphp
            <div class="stat-number">{{ $emCurso }}</div>
            <div class="stat-label">Em Curso</div>
        </div>
        <div class="stat-card">
            @php $totalProjectos = App\Models\Projectoo::count(); @endphp
            <div class="stat-number">{{ $totalProjectos }}</div>
            <div class="stat-label">Total</div>
        </div>
    </div>

    <!-- Título -->
    <h3 class="recent-projects-title">Projectos Recentes</h3>

    <!-- Grid de Projectos -->
    <div class="project-grid">
        @if(isset($projectoos) && $projectoos->count() > 0)
            @foreach($projectoos as $projectoo)
            <div class="project-card">
                @if(isset($projectoo->imagens) && count($projectoo->imagens) > 0)
                    <img src="{{ asset('storage/' . $projectoo->imagens[0]) }}"
                         alt="{{ $projectoo->nome }}"
                         class="project-image"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="no-image" style="display: none;">
                        <i class="fas fa-image fa-3x mb-3"></i>
                        <span>Sem imagem</span>
                    </div>
                @else
                    <div class="no-image">
                        <i class="fas fa-image fa-3x mb-3"></i>
                        <span>Sem imagem</span>
                    </div>
                @endif

                <div class="project-info">
                    <div class="project-name">{{ $projectoo->nome }}</div>
                    <div class="project-category">{{ $projectoo->categoria->name ?? 'Sem categoria' }}</div>
                    
                    @if(isset($projectoo->estado))
                    @php
                        $statusClass = $projectoo->estado == 'CONCLUIDO' ? 'badge-success' :
                                     ($projectoo->estado == 'EM_CURSO' ? 'badge-warning' :
                                     ($projectoo->estado == 'ACTIVO' ? 'badge-primary' : 'badge-secondary'));
                        $statusText = $projectoo->estado == 'CONCLUIDO' ? 'CONCLUÍDO' :
                                    ($projectoo->estado == 'EM_CURSO' ? 'EM_CURSO' :
                                    ($projectoo->estado == 'ACTIVO' ? 'ACTIVO' : $projectoo->estado));
                    @endphp
                    <div style="margin-top: 12px;">
                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    @endif

                    <div style="margin-top: 12px; font-size: 0.9rem; color: #666;">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $projectoo->created_at->format('d/m/Y') }}
                    </div>

                    <a href="{{ route('projectoos.showuser', $projectoo->id) }}" class="view-details-btn">
                        <i class="fas fa-eye"></i>
                        Ver Detalhes
                    </a>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-fullscreen">
                <div class="empty-card">
                    <i class="fas fa-folder-open fa-4x text-muted mb-4"></i>
                    <h4 class="mb-3">Nenhum projecto encontrado</h4>
                    <p class="text-muted mb-4">Não existem projectos para mostrar no momento.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animação dos cards
    const cards = document.querySelectorAll('.project-card, .stat-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
    });

    // Clique no card inteiro
    document.querySelectorAll('.project-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.view-details-btn')) {
                const link = this.querySelector('.view-details-btn');
                if (link) window.location.href = link.href;
            }
        });
    });
});
</script>

@include('layouts.footer')
@endcannot




{{-- ✅ DASHBOARD ADMINISTRATIVO --}}
@can('is_admin')
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
                    <i class="fas fa-download"></i> Exportar
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
                            @forelse($projectoos->take(10) as $projecto)
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
                                    <td colspan="7" class="text-center py-5">
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
        initAnimations();
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

        // Gráfico de Categorias - MELHORADO
        const categoryCanvas = document.getElementById('categoryChart');
        if (categoryCanvas) {
            const categoryCtx = categoryCanvas.getContext('2d');
            const categoryData = @json(App\Models\Projectoo::with('categoria')->get()->groupBy('categoria_id')->map(fn($group) => [
                'name' => $group->first()->categoria->name ?? 'Sem Categoria',
                'count' => $group->count()
            ])->sortByDesc('count')->values()->toArray());

            if (categoryData.length > 0) {
                // Paleta de cores vibrantes e distintas
                const colors = [
                    '#2c3e50', '#e74c3c', '#3498db', '#2ecc71', '#f39c12',
                    '#9b59b6', '#1abc9c', '#d35400', '#34495e', '#27ae60',
                    '#2980b9', '#8e44ad', '#f1c40f', '#e67e22', '#16a085'
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
                            },
                            // Plugin para mostrar números no topo das barras
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                color: '#2c3e50',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                },
                                formatter: function(value) {
                                    return value;
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
                                    font: {
                                        size: 11
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Número de Projectos',
                                    color: '#6c757d',
                                    font: {
                                        size: 12,
                                        weight: '600'
                                    }
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
                                    font: {
                                        size: 11
                                    },
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },
                        // Configurações para mostrar valores nas barras
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        elements: {
                            bar: {
                                borderWidth: 2,
                            }
                        },
                        layout: {
                            padding: {
                                top: 20 // Espaço para os números no topo
                            }
                        }
                    },
                    plugins: [{
                        id: 'barLabels',
                        afterDraw: (chart) => {
                            const ctx = chart.ctx;
                            ctx.save();
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            ctx.font = 'bold 12px Arial';
                            ctx.fillStyle = '#2c3e50';
                            
                            chart.data.datasets.forEach((dataset, i) => {
                                const meta = chart.getDatasetMeta(i);
                                meta.data.forEach((bar, index) => {
                                    const data = dataset.data[index];
                                    if (data > 0) { // Só mostra se o valor for maior que 0
                                        ctx.fillText(
                                            data, 
                                            bar.x, 
                                            bar.y - 5
                                        );
                                    }
                                });
                            });
                            ctx.restore();
                        }
                    }]
                });
            } else {
                // Caso não haja dados, mostra uma mensagem
                categoryCtx.font = '16px Arial';
                categoryCtx.fillStyle = '#6c757d';
                categoryCtx.textAlign = 'center';
                categoryCtx.fillText('Não há dados disponíveis', categoryCanvas.width / 2, categoryCanvas.height / 2);
            }
        }
        @endcan
    }

    function initAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 150);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.project-card-user, .stat-card-user, .info-box-admin, .quick-action-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            observer.observe(el);
        });
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

    // Clique em cards (usuários comuns)
    @cannot('is_admin')
    document.addEventListener('click', (e) => {
        const card = e.target.closest('.project-card-user');
        if (card && !e.target.closest('.view-details-btn-user')) {
            const link = card.querySelector('.view-details-btn-user');
            if (link) window.location.href = link.href;
        }
    });
    @endcannot

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

    window.exportChart = exportChart;

    console.log('🚀 Dashboard Escaleno inicializado com sucesso!');
})();
</script>
@endsection
