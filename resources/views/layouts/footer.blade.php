<!-- resources/views/layouts/footer.blade.php -->
<footer style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; padding: 40px 0 20px 0; margin-top: 50px;">
    <div class="container-fluid">
        <div class="row">
            <!-- Coluna 1: Sobre -->
            <div class="col-md-4 mb-4">
                <h5 style="color: #ecf0f1; margin-bottom: 20px;">
                    <i class="fas fa-building mr-2"></i>Escaleno
                </h5>
                <p style="color: #bdc3c7; line-height: 1.6;">
                    Especialistas em gestão de projectos de construção civil e arquitetura. 
                    Transformamos ideias em realidade com excelência e profissionalismo.
                </p>
                <div class="social-links" style="margin-top: 20px;">
                    <a href="#" style="color: #bdc3c7; margin-right: 15px; font-size: 1.2rem;">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" style="color: #bdc3c7; margin-right: 15px; font-size: 1.2rem;">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" style="color: #bdc3c7; margin-right: 15px; font-size: 1.2rem;">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" style="color: #bdc3c7; font-size: 1.2rem;">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Coluna 2: Links Rápidos -->
            <div class="col-md-2 mb-4">
                <h6 style="color: #ecf0f1; margin-bottom: 20px; text-transform: uppercase;">Links Rápidos</h6>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 8px;">
                        <a href="{{ url('/home') }}" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">
                            <i class="fas fa-home mr-2"></i>Home
                        </a>
                    </li>
                    <!--<li style="margin-bottom: 8px;">
                        <a href="{{ route('projectoos.list') }}" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">
                            <i class="fas fa-list mr-2"></i>Projectos
                        </a>
                    </li>-->
                    <li style="margin-bottom: 8px;">
                        <a href="#" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">
                            <i class="fas fa-info-circle mr-2"></i>Sobre
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="#" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s;">
                            <i class="fas fa-phone mr-2"></i>Contacto
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Coluna 3: Serviços -->
            <div class="col-md-3 mb-4">
                <h6 style="color: #ecf0f1; margin-bottom: 20px; text-transform: uppercase;">Nossos Serviços</h6>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 8px;">
                        <span style="color: #bdc3c7;">
                            <i class="fas fa-drafting-compass mr-2"></i>Projecto Arquitetónico
                        </span>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <span style="color: #bdc3c7;">
                            <i class="fas fa-hard-hat mr-2"></i>Gestão de Obras
                        </span>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <span style="color: #bdc3c7;">
                            <i class="fas fa-ruler-combined mr-2"></i>Fiscalização
                        </span>
                    </li>
                    <!--<li style="margin-bottom: 8px;">
                        <span style="color: #bdc3c7;">
                            <i class="fas fa-tools mr-2"></i>Consultoria Técnica
                        </span>
                    </li> -->
                </ul>
            </div>

            <!-- Coluna 4: Contactos -->
            <div class="col-md-3 mb-4">
                <h6 style="color: #ecf0f1; margin-bottom: 20px; text-transform: uppercase;">Contactos</h6>
                <div style="color: #bdc3c7;">
                    <p style="margin-bottom: 10px;">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Av 25 de Setembro, Cidade de Maputo
                    </p>
                    <p style="margin-bottom: 10px;">
                        <i class="fas fa-phone mr-2"></i>
                        (+258) 86 5550565
                    </p>
                    <p style="margin-bottom: 10px;">
                        <i class="fas fa-envelope mr-2"></i>
                        info@escaleno.com
                    </p>
                    <!--<p style="margin-bottom: 10px;">
                        <i class="fas fa-clock mr-2"></i>
                        Seg - Sex: 7:00 - 17:00
                    </p>-->
                </div>
            </div>
        </div>

        <!-- Linha Divisória -->
        <hr style="border-color: #34495e; margin: 30px 0 20px 0;">

        <!-- Copyright -->
        <div class="row">
            <div class="col-12 text-center">
                <p style="color: #95a5a6; margin: 0; font-size: 0.9rem;">
                    <i class="far fa-copyright"></i> {{ date('Y') }} Escaleno. Todos os direitos reservados.
                    <span style="margin: 0 10px;">|</span>
                    Desenvolvido por <span class="developer-credit">
                        <i class="fas fa-code mr-1"></i>Jacinto da Costa
                    </span>
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
    .social-links a:hover {
        color: #3498db !important;
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    footer a:hover {
        color: #3498db !important;
        text-decoration: none;
    }

    footer ul li {
        transition: transform 0.3s ease;
    }

    footer ul li:hover {
        transform: translateX(5px);
    }

    @media (max-width: 768px) {
        footer {
            padding: 30px 0 15px 0;
        }
        
        .social-links {
            text-align: center;
        }
        
        footer .col-md-4,
        footer .col-md-2,
        footer .col-md-3 {
            margin-bottom: 30px;
            text-align: center;
        }
        
        footer ul {
            text-align: center;
        }
    }

    
</style>