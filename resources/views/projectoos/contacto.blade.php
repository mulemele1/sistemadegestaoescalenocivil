@extends('adminlte::page')

@section('title', 'SysEscaleno - Contactos')

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
    
    /* Contact Layout */
    .contact-section {
        padding: 80px 0;
    }
    
    .section-title {
        font-size: 2.5rem;
        font-weight: 600;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 50px;
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
    
    .contact-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Info Card */
    .info-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 40px;
        height: fit-content;
    }
    
    .info-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .info-title i {
        font-size: 2rem;
        color: #3498db;
    }
    
    .contact-info {
        margin-bottom: 30px;
    }
    
    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 25px;
        padding: 15px;
        border-radius: 10px;
        transition: background 0.3s ease;
    }
    
    .contact-item:hover {
        background: #f8f9fa;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .contact-details h4 {
        margin: 0 0 5px 0;
        color: #2c3e50;
        font-weight: 600;
    }
    
    .contact-details p {
        margin: 0;
        color: #666;
        line-height: 1.5;
    }
    
    /* Social Links */
    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }
    
    .social-link {
        width: 45px;
        height: 45px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2c3e50;
        font-size: 1.2rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .social-link:hover {
        background: #2c3e50;
        color: white;
        transform: translateY(-3px);
    }
    
    /* Form Card */
    .form-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 40px;
    }
    
    .form-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .form-title i {
        font-size: 2rem;
        color: #3498db;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 1rem;
    }
    
    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
        background: #f8f9fa;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #2c3e50;
        background: white;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border: none;
        padding: 18px 40px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(44, 62, 80, 0.3);
    }
    
    /* Map Section */
    .map-section {
        padding: 60px 0;
        background: #f8f9fa;
    }
    
    .map-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        padding: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .map-placeholder {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border-radius: 10px;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .contact-layout {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .hero-title {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
        }
        
        .section-title {
            font-size: 2rem;
        }
        
        .info-card,
        .form-card {
            padding: 25px;
            margin: 0 15px;
        }
        
        .contact-layout {
            padding: 0 15px;
        }
        
        .contact-section {
            padding: 50px 0;
        }
        
        .contact-item {
            flex-direction: column;
            text-align: center;
        }
        
        .social-links {
            justify-content: center;
        }
    }
</style>

<!-- INCLUIR HEADER COMPARTILHADO -->
@include('layouts.header')

<div class="full-screen-container">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Contacte-nos</h1>
            <p class="hero-subtitle">
                Estamos aqui para ajudar. Entre em contacto connosco para mais informações sobre os nossos serviços.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <h2 class="section-title">Informações de Contacto</h2>
        
        <div class="contact-layout">
            <!-- Informações de Contacto -->
            <div class="info-card">
                <h3 class="info-title">
                    <i class="fas fa-building"></i>Escaleno
                </h3>
                
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Endereço</h4>
                            <p>
                                Av 25 de Setembro<br>
                                Cidade de Maputo<br>
                                Moçambique
                            </p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Telefone</h4>
                            <p>(+258) 86 5550565</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>E-mail</h4>
                            <p>info@escaleno.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Em Funcionamento</h4>
                            <p>Entre em contacto</p>
                        </div>
                    </div>
                </div>
                
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            
            <!-- Formulário de Contacto -->
            <div class="form-card">
                <h3 class="form-title">
                    <i class="fas fa-paper-plane"></i>Deseja mais informações?
                </h3>
                
                <form id="contactForm">
                    <div class="form-group">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" id="name" class="form-control" placeholder="Seu nome completo" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="seu@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="tel" id="phone" class="form-control" placeholder="(+258) ...">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">Assunto</label>
                        <input type="text" id="subject" class="form-control" placeholder="Assunto da mensagem" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Mensagem</label>
                        <textarea id="message" class="form-control" placeholder="Escreva sua mensagem..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Enviar Mensagem
                    </button>
                </form>
            </div>
        </div>
    </section>
    
    <!-- Map Section -->
    <section class="map-section">
        <div class="map-container">
            <h3 class="section-title">Nossa Localização</h3>
            <div class="map-placeholder">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                    <p>Mapa - Av 25 de Setembro, Cidade de Maputo</p>
                    <small>Localização da Escaleno</small>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página de contacto carregada com sucesso!');
        
        // Animação suave para os elementos
        const elements = document.querySelectorAll('.info-card, .form-card, .contact-item');
        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                element.style.transition = 'all 0.6s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Validação do formulário
        const contactForm = document.getElementById('contactForm');
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validação simples
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;
            
            if (name && email && message) {
                // Simulação de envio
                const submitBtn = contactForm.querySelector('.btn-submit');
                const originalText = submitBtn.innerHTML;
                
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
                submitBtn.disabled = true;
                
                setTimeout(() => {
                    alert('Mensagem enviada com sucesso! Entraremos em contacto em breve.');
                    contactForm.reset();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            } else {
                alert('Por favor, preencha todos os campos obrigatórios.');
            }
        });
    });
</script>

<!-- INCLUIR FOOTER COMPARTILHADO -->
@include('layouts.footer')

@endcannot
@endsection