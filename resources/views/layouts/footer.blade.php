<!-- resources/views/layouts/footer.blade.php -->
<footer style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; padding: 20px 0 12px 0; margin-top: 25px;">
    <div class="container-fluid">
        <div class="row">
            <!-- Coluna 1: Sobre -->
            <div class="col-md-4 mb-2">
                <h6 style="color: #ecf0f1; margin-bottom: 12px; font-size: 0.95rem;">
                    <i class="fas fa-building mr-1"></i>Escaleno
                </h6>
                <p style="color: #bdc3c7; line-height: 1.4; font-size: 0.8rem; margin-bottom: 12px;">
                    Especialistas em gestão de projectos de construção civil e arquitetura. 
                    Transformamos ideias em realidade com excelência e profissionalismo.
                </p>
                <div class="social-links">
                    <a href="#" style="color: #bdc3c7; margin-right: 10px; font-size: 0.9rem;">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" style="color: #bdc3c7; margin-right: 10px; font-size: 0.9rem;">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" style="color: #bdc3c7; margin-right: 10px; font-size: 0.9rem;">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" style="color: #bdc3c7; font-size: 0.9rem;">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Coluna 2: Links Rápidos -->
            <div class="col-md-2 mb-2">
                <h6 style="color: #ecf0f1; margin-bottom: 12px; font-size: 0.85rem; text-transform: uppercase;">Links</h6>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 5px;">
                        <a href="{{ url('/home') }}" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s; font-size: 0.8rem;">
                            <i class="fas fa-home mr-1"></i>Home
                        </a>
                    </li>
                    <li style="margin-bottom: 5px;">
                        <a href="#" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s; font-size: 0.8rem;">
                            <i class="fas fa-info-circle mr-1"></i>Sobre
                        </a>
                    </li>
                    <li style="margin-bottom: 5px;">
                        <a href="#" style="color: #bdc3c7; text-decoration: none; transition: color 0.3s; font-size: 0.8rem;">
                            <i class="fas fa-phone mr-1"></i>Contacto
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Coluna 3: Serviços -->
            <div class="col-md-3 mb-2">
                <h6 style="color: #ecf0f1; margin-bottom: 12px; font-size: 0.85rem; text-transform: uppercase;">Serviços</h6>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 5px;">
                        <span style="color: #bdc3c7; font-size: 0.8rem;">
                            <i class="fas fa-drafting-compass mr-1"></i>Projecto Arquitetónico
                        </span>
                    </li>
                    <li style="margin-bottom: 5px;">
                        <span style="color: #bdc3c7; font-size: 0.8rem;">
                            <i class="fas fa-hard-hat mr-1"></i>Gestão de Obras
                        </span>
                    </li>
                    <li style="margin-bottom: 5px;">
                        <span style="color: #bdc3c7; font-size: 0.8rem;">
                            <i class="fas fa-ruler-combined mr-1"></i>Fiscalização
                        </span>
                    </li>
                </ul>
            </div>

            <!-- Coluna 4: Contactos -->
            <div class="col-md-3 mb-2">
                <h6 style="color: #ecf0f1; margin-bottom: 12px; font-size: 0.85rem; text-transform: uppercase;">Contactos</h6>
                <div style="color: #bdc3c7;">
                    <p style="margin-bottom: 6px; font-size: 0.8rem;">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Av 25 de Setembro, Maputo
                    </p>
                    <p style="margin-bottom: 6px; font-size: 0.8rem;">
                        <i class="fas fa-phone mr-1"></i>
                        (+258) 86 5550565
                    </p>
                    <p style="margin-bottom: 6px; font-size: 0.8rem;">
                        <i class="fas fa-envelope mr-1"></i>
                        info@escaleno.com
                    </p>
                </div>
            </div>
        </div>

        <!-- Linha Divisória -->
        <hr style="border-color: #34495e; margin: 15px 0 12px 0;">

        <!-- Copyright -->
        <div class="row">
            <div class="col-12 text-center">
                <p style="color: #95a5a6; margin: 0; font-size: 0.75rem;">
                    <i class="far fa-copyright"></i> {{ date('Y') }} Escaleno. Todos os direitos reservados.
                    <span style="margin: 0 6px;">|</span>
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
        transform: translateY(-1px);
        transition: all 0.3s ease;
    }

    footer a:hover {
        color: #3498db !important;
        text-decoration: none;
    }

    footer ul li {
        transition: transform 0.2s ease;
    }

    footer ul li:hover {
        transform: translateX(2px);
    }

    @media (max-width: 768px) {
        footer {
            padding: 15px 0 10px 0;
            margin-top: 15px;
        }
        
        .social-links {
            text-align: center;
        }
        
        footer .col-md-4,
        footer .col-md-2,
        footer .col-md-3 {
            margin-bottom: 15px;
            text-align: center;
        }
        
        footer ul {
            text-align: center;
        }

        footer h6 {
            font-size: 0.8rem !important;
        }

        footer p, footer span, footer a {
            font-size: 0.75rem !important;
        }
    }

    @media (max-width: 480px) {
        footer {
            padding: 12px 0 8px 0;
        }
        
        .row {
            margin: 0 -3px;
        }
        
        .col-md-4, .col-md-2, .col-md-3 {
            padding: 0 3px;
        }
        
        .social-links a {
            margin-right: 8px !important;
        }
    }
</style>