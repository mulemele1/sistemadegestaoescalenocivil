@extends('adminlte::page')

@section('title', 'SysEscaleno - Sobre Nós')

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
    
    /* Content Sections */
    .content-section {
        padding: 60px 0;
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 600;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }
    
    .section-title:after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        margin: 15px auto;
        border-radius: 2px;
    }
    
    .about-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 40px;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
        border-left: 5px solid #2c3e50;
    }
    
    .about-card:hover {
        transform: translateY(-5px);
    }
    
    .card-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .card-title i {
        font-size: 2rem;
        color: #3498db;
    }
    
    .card-content {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #555;
    }
    
    /* Team Section */
    .team-section {
        background: #f8f9fa;
        padding: 80px 0;
    }
    
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .team-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 30px;
        text-align: center;
        transition: all 0.3s ease;
        border-top: 4px solid #2c3e50;
    }
    
    .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .team-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
    }
    
    .team-name {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    
    .team-role {
        font-size: 1.1rem;
        color: #3498db;
        font-weight: 500;
        margin-bottom: 15px;
        padding: 5px 15px;
        background: #ecf0f1;
        border-radius: 20px;
        display: inline-block;
    }
    
    .team-description {
        color: #666;
        line-height: 1.6;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.2rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .about-card {
            padding: 25px;
            margin: 15px;
        }
        
        .team-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 0 15px;
        }
        
        .content-section {
            padding: 40px 0;
        }
        
        .team-section {
            padding: 50px 0;
        }
    }
</style>

<!-- INCLUIR HEADER COMPARTILHADO -->
@include('layouts.header')

<div class="full-screen-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Sobre a Escaleno</h1>
            <p class="hero-subtitle">
                Especialistas em gestão de projectos de construção civil e arquitetura. 
                Transformamos ideias em realidade com excelência e profissionalismo.
            </p>
        </div>
    </section>

    <!-- Sobre a Empresa -->
    <section class="content-section">
        <div class="container">
            <h2 class="section-title">Sobre a Escaleno</h2>
            
            <div class="about-card">
                <h3 class="card-title">
                    <i class="fas fa-building"></i>Nossa História
                </h3>
                <br><br><br>
                <div class="card-content">
                    <p>
                        Fundada em 2019, a Escaleno estabeleceu-se rapidamente como a principal opção 
                        para a realização de projectos de construção civil e arquitetura de alto nível 
                        em Maputo, Moçambique. 
                    </p>
                    <p>
                        Situada estrategicamente na Av 25 de Setembro, Cidade de Maputo, a empresa 
                        destaca-se pela excelência, inovação e compromisso com a qualidade em todos 
                        os projectos que desenvolve.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visão, Missão e Valores -->
    <section class="content-section" style="background: #f8f9fa;">
        <div class="container">
            <h2 class="section-title">Nossos Pilares</h2>
            
            <div class="row">
                <!-- Visão -->
                <div class="col-md-4 mb-4">
                    <div class="about-card" style="height: 100%;">
                        <h3 class="card-title">
                            <i class="fas fa-eye"></i>Visão
                        </h3>
                        <br><br><br>
                        <div class="card-content">
                            <p>
                                Criando um mundo mais saudável e sustentável através de projectos 
                                de construção civil inovadores e de excelência para as gerações futuras.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Missão -->
                <div class="col-md-4 mb-4">
                    <div class="about-card" style="height: 100%;">
                        <h3 class="card-title">
                            <i class="fas fa-bullseye"></i>Missão
                        </h3>
                        <br><br><br>
                        <div class="card-content">
                            <p>
                                A Escaleno gera soluções arquitectónicas e de engenharia inovadoras, 
                                traduzindo-as em projectos executivos de qualidade para impactar 
                                positivamente o desenvolvimento urbano e comunitário.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Valores -->
                <div class="col-md-4 mb-4">
                    <div class="about-card" style="height: 100%;">
                        <h3 class="card-title">
                            <i class="fas fa-heart"></i>Valores
                        </h3>
                        <br><br><br>
                        <div class="card-content">
                            <ul style="list-style: none; padding: 0;">
                                <li style="margin-bottom: 10px;">✅ <strong>Excelência</strong></li>
                                <li style="margin-bottom: 10px;">💡 <strong>Inovação</strong></li>
                                <li style="margin-bottom: 10px;">⚖️ <strong>Integridade</strong></li>
                                <li style="margin-bottom: 10px;">🤝 <strong>Respeito</strong></li>
                                <li style="margin-bottom: 10px;">👥 <strong>Trabalho em Equipa</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nossa Equipa -->
    <section class="team-section">
        <div class="container">
            <h2 class="section-title">Nossa Equipa</h2>
            
            <div class="team-grid">
                <!-- Manuel Varela -->
                <div class="team-card">
                    <div class="team-avatar">MV</div>
                    <h3 class="team-name">Manuel Varela</h3>
                    <div class="team-role">Arquiteto e Planificador Físico</div>
                    <p class="team-description">
                        Especialista em planeamento urbano e projectos arquitectónicos sustentáveis.
                    </p>
                </div>
                
                <!-- Eduilson Netuse -->
                <div class="team-card">
                    <div class="team-avatar">EN</div>
                    <h3 class="team-name">Eduilson Netuse</h3>
                    <div class="team-role">Arquiteto e Planificador Físico</div>
                    <p class="team-description">
                        Experiência em design arquitectónico e gestão de projectos de construção.
                    </p>
                </div>
                
                <!-- Alan Álvaro -->
                <div class="team-card">
                    <div class="team-avatar">AA</div>
                    <h3 class="team-name">Alan Álvaro</h3>
                    <div class="team-role">Engenheiro Civil</div>
                    <p class="team-description">
                        Especialista em estruturas e fiscalização de obras civis.
                    </p>
                </div>
                
                <!-- Oldemiro Nolene -->
                <div class="team-card">
                    <div class="team-avatar">ON</div>
                    <h3 class="team-name">Oldemiro Nolene</h3>
                    <div class="team-role">Arquiteto Informático</div>
                    <p class="team-description">
                        Responsável pela integração de tecnologias nos projectos arquitectónicos.
                    </p>
                </div>
                
                <!-- Aldo Fazenda -->
                <div class="team-card">
                    <div class="team-avatar">AF</div>
                    <h3 class="team-name">Aldo Fazenda</h3>
                    <div class="team-role">Engenheiro Civil, RMP</div>
                    <p class="team-description">
                        Engenheiro civil registado com vasta experiência em gestão de projectos.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página SOBRE carregada com sucesso!');
        
        // Animação suave para os cards
        const cards = document.querySelectorAll('.about-card, .team-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });
</script>

<!-- INCLUIR FOOTER COMPARTILHADO -->
@include('layouts.footer')

@endcannot
@endsection