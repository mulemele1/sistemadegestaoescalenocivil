@extends('adminlte::page')

@section('title', 'SysEscaleno - ' . $projectoo->nome)

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

    /* Layout Principal */
    .project-detail-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .project-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .project-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .project-subtitle {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 20px;
    }

    .project-price {
        font-size: 2rem;
        font-weight: 700;
        color: #28a745;
        margin-bottom: 15px;
    }

    /* Layout de Duas Colunas */
    .project-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }

    /* Slideshow de Imagens */
    .slideshow-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .main-slide {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 15px 15px 0 0;
    }

    .thumbnails-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
        padding: 15px;
    }

    .thumbnail {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.3s ease;
        border: 2px solid transparent;
    }

    .thumbnail:hover {
        transform: scale(1.05);
    }

    .thumbnail.active {
        border-color: #2c3e50;
    }

    /* Detalhes do Projeto */
    .details-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        padding: 30px;
    }

    /* Tabs de Navegação */
    .tabs-container {
        margin-bottom: 30px;
    }

    .tabs {
        display: flex;
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 20px;
    }

    .tab {
        padding: 12px 25px;
        background: none;
        border: none;
        font-weight: 600;
        color: #6c757d;
        cursor: pointer;
        transition: all 0.3s ease;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
    }

    .tab.active {
        color: #2c3e50;
        border-bottom-color: #2c3e50;
    }

    .tab:hover {
        color: #2c3e50;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Tabela de Características */
    .features-table {
        width: 100%;
        border-collapse: collapse;
    }

    .features-table tr {
        border-bottom: 1px solid #e9ecef;
    }

    .features-table td {
        padding: 15px 10px;
        vertical-align: top;
    }

    .features-table .feature-label {
        font-weight: 600;
        color: #333;
        width: 40%;
    }

    .features-table .feature-value {
        color: #666;
        width: 60%;
    }

    /* Seção de Contactos */
    .contact-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        margin-top: 30px;
    }

    .contact-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .contact-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .contact-details h4 {
        margin: 0 0 5px 0;
        color: #333;
    }

    .contact-details p {
        margin: 0;
        color: #666;
    }

    /* Formulário de Visita */
    .visit-form {
        margin-top: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #2c3e50;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
        width: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
    }

    /* Anexos e Documentos */
    .attachments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .attachment-card {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .attachment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: #2c3e50;
    }

    .attachment-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .attachment-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
        word-break: break-word;
    }

    .download-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 10px;
        font-size: 0.8rem;
    }

    .download-btn:hover {
        background: #218838;
        color: white;
        text-decoration: none;
    }

    /* Projetos Relacionados */
    .related-projects {
        margin-top: 50px;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 30px;
        text-align: center;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .related-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .related-card:hover {
        transform: translateY(-5px);
    }

    .related-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .related-info {
        padding: 20px;
    }

    .related-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .related-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #28a745;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-active { background-color: #d4edda; color: #155724; }
    .status-inactive { background-color: #e2e3e5; color: #383d41; }
    .status-progress { background-color: #fff3cd; color: #856404; }

    /* Responsividade */
    @media (max-width: 1024px) {
        .project-layout {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .project-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .project-detail-container {
            padding: 20px 15px;
        }
        
        .project-title {
            font-size: 1.8rem;
        }
        
        .tabs {
            flex-wrap: wrap;
        }
        
        .tab {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
        
        .thumbnails-container {
            grid-template-columns: repeat(3, 1fr);
        }
        
        .attachments-grid {
            grid-template-columns: 1fr;
        }
        
        .related-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- INCLUIR HEADER COMPARTILHADO -->
@include('layouts.header')

<div class="full-screen-container">
    <div class="project-detail-container">
        <!-- Cabeçalho do Projeto -->
        <div class="project-header">
            <h1 class="project-title">{{ $projectoo->nome }}</h1>
            <p class="project-subtitle">
                {{ $projectoo->categoria->name ?? 'Sem categoria' }} • 
                {{ $projectoo->localizacao->name ?? 'N/A' }}
            </p>
            @php
                $statusClass = $projectoo->estado == 'CONCLUIDO' ? 'status-inactive' : 
                             ($projectoo->estado == 'EM_ANDAMENTO' ? 'status-progress' : 'status-active');
                $statusText = $projectoo->estado == 'CONCLUIDO' ? 'CONCLUÍDO' : 
                            ($projectoo->estado == 'EM_ANDAMENTO' ? 'EM ANDAMENTO' : 'ACTIVO');
            @endphp
            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
        </div>

        <!-- Layout Principal: Slideshow + Detalhes -->
        <div class="project-layout">
            <!-- Slideshow de Imagens -->
            <div class="slideshow-container">
                @if(isset($projectoo->imagens) && count($projectoo->imagens) > 0)
                    <img id="mainImage" src="{{ asset('storage/' . $projectoo->imagens[0]) }}" 
                         alt="{{ $projectoo->nome }}" 
                         class="main-slide">
                    
                    <div class="thumbnails-container">
                        @foreach($projectoo->imagens as $index => $imagem)
                            <img src="{{ asset('storage/' . $imagem) }}" 
                                 alt="Imagem {{ $index + 1 }}" 
                                 class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                 onclick="changeImage('{{ asset('storage/' . $imagem) }}', this)"
                                 onerror="this.style.display='none'">
                        @endforeach
                    </div>
                @else
                    <div class="main-slide" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem;">
                        <i class="fas fa-image fa-3x mb-3"></i><br>
                        Sem imagens disponíveis
                    </div>
                @endif
            </div>

            <!-- Detalhes do Projeto -->
            <div class="details-container">
                <!-- Tabs de Navegação -->
                <div class="tabs-container">
                    <div class="tabs">
                        <button class="tab active" onclick="openTab('details')">DETALHES</button>
                        <button class="tab" onclick="openTab('description')">DESCRIÇÃO</button>
                        <button class="tab" onclick="openTab('attachments')">ANEXOS</button>
                        <button class="tab" onclick="openTab('contact')">CONTACTO</button>
                    </div>

                    <!-- Tab: Detalhes -->
                    <div id="details" class="tab-content active">
                        <h3 style="margin-bottom: 20px; color: #333;">Características do Projecto</h3>
                        <table class="features-table">
                            <tr>
                                <td class="feature-label">Nome do Projecto</td>
                                <td class="feature-value">{{ $projectoo->nome }}</td>
                            </tr>
                            <tr>
                                <td class="feature-label">Tipografia</td>
                                <td class="feature-value">{{ $projectoo->tipografia ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="feature-label">Categoria</td>
                                <td class="feature-value">
                                    <span class="badge badge-primary">{{ $projectoo->categoria->name ?? 'Sem categoria' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="feature-label">Localização</td>
                                <td class="feature-value">{{ $projectoo->localizacao->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="feature-label">Estado</td>
                                <td class="feature-value">
                                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                            </tr>
                            @if($projectoo->cor)
                            <tr>
                                <td class="feature-label">Cor</td>
                                <td class="feature-value">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 25px; height: 25px; border-radius: 50%; background-color: {{ $projectoo->cor }}; border: 2px solid #ddd;"></div>
                                        <span>{{ $projectoo->cor }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="feature-label">Data de Criação</td>
                                <td class="feature-value">{{ $projectoo->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="feature-label">Última Actualização</td>
                                <td class="feature-value">{{ $projectoo->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Tab: Descrição -->
                    <div id="description" class="tab-content">
                        <h3 style="margin-bottom: 20px; color: #333;">Descrição do Projecto</h3>
                        @if($projectoo->descricao)
                            <p style="line-height: 1.6; color: #666; font-size: 1.1rem;">
                                {{ $projectoo->descricao }}
                            </p>
                        @else
                            <p style="color: #999; font-style: italic;">
                                Nenhuma descrição disponível para este projecto.
                            </p>
                        @endif
                    </div>

                    <!-- Tab: Anexos -->
                    <div id="attachments" class="tab-content">
                        <h3 style="margin-bottom: 20px; color: #333;">Documentos e Anexos</h3>
                        @if(isset($projectoo->anexos) && count($projectoo->anexos) > 0)
                            <div class="attachments-grid">
                                @foreach($projectoo->anexos as $index => $anexo)
                                    @php
                                        $fileName = basename($anexo);
                                        $fileIcon = getFileIcon($fileName);
                                    @endphp
                                    <div class="attachment-card">
                                        <div class="attachment-icon">{{ $fileIcon }}</div>
                                        <div class="attachment-name">{{ $fileName }}</div>
                                        <a href="{{ asset('storage/' . $anexo) }}" 
                                           class="download-btn" 
                                           download="{{ $fileName }}">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p style="color: #999; text-align: center; padding: 40px;">
                                <i class="fas fa-file-alt fa-3x mb-3" style="color: #ddd;"></i><br>
                                Nenhum documento anexado a este projecto.
                            </p>
                        @endif
                    </div>

                    <!-- Tab: Contacto -->
                    <div id="contact" class="tab-content">
                        <h3 style="margin-bottom: 20px; color: #333;">Informações de Contacto</h3>
                        
                        <div class="contact-section">
                            <div class="contact-info">
                                <div class="contact-avatar">
                                    SC
                                </div>
                                <div class="contact-details">
                                    <h4>SysEscaleno</h4>
                                    <p>Especialista em Gestão de Projectos</p>
                                    <p><i class="fas fa-phone mr-2"></i> +258 86 5550565</p>
                                    <p><i class="fas fa-envelope mr-2"></i> info@sysescaleno.com</p>
                                </div>
                            </div>

                            <div class="visit-form">
                                <h4 style="margin-bottom: 20px;">Deseja mais informações?</h4>
                                <form>
                                    <div class="form-group">
                                        <label for="name">Nome</label>
                                        <input type="text" id="name" class="form-control" placeholder="Seu nome completo">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" class="form-control" placeholder="seu@email.com">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Telefone</label>
                                        <input type="tel" id="phone" class="form-control" placeholder="+258 ...">
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Mensagem</label>
                                        <textarea id="message" class="form-control" rows="4" placeholder="Escreva sua mensagem..."></textarea>
                                    </div>
                                    <button type="submit" class="btn-primary">
                                        <i class="fas fa-paper-plane"></i> Enviar Mensagem
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projetos Relacionados -->
        @php
            $relatedProjects = App\Models\Projectoo::where('categoria_id', $projectoo->categoria_id)
                ->where('id', '!=', $projectoo->id)
                ->take(3)
                ->get();
        @endphp
        
        @if($relatedProjects->count() > 0)
        <div class="related-projects">
            <h2 class="section-title">Projectos Relacionados</h2>
            <div class="related-grid">
                @foreach($relatedProjects as $related)
                <div class="related-card" onclick="window.location.href='{{ route('projectoos.showuser', $related->id) }}'">
                    @if(isset($related->imagens) && count($related->imagens) > 0)
                        <img src="{{ asset('storage/' . $related->imagens[0]) }}" 
                             alt="{{ $related->nome }}" 
                             class="related-image">
                    @else
                        <div class="related-image" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-image fa-2x"></i>
                        </div>
                    @endif
                    <div class="related-info">
                        <h3 class="related-name">{{ $related->nome }}</h3>
                        <div class="related-price">{{ $related->categoria->name ?? 'Sem categoria' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script>
    // Função para obter ícone baseado na extensão do arquivo
    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const iconMap = {
            'pdf': '📄',
            'doc': '📝',
            'docx': '📝',
            'xls': '📊',
            'xlsx': '📊',
            'ppt': '📽️',
            'pptx': '📽️',
            'txt': '📃',
            'zip': '📦',
            'rar': '📦',
            'jpg': '🖼️',
            'jpeg': '🖼️',
            'png': '🖼️',
            'gif': '🖼️'
        };
        return iconMap[ext] || '📎';
    }

    // Slideshow functions
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        
        // Remove active class from all thumbnails
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        
        // Add active class to clicked thumbnail
        element.classList.add('active');
    }

    // Tab functions
    function openTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Show the selected tab content
        document.getElementById(tabName).classList.add('active');
        
        // Add active class to the clicked tab
        event.currentTarget.classList.add('active');
    }

    // Auto-rotate images every 5 seconds
    let currentImageIndex = 0;
    const images = @json($projectoo->imagens ?? []);
    
    function autoRotateImages() {
        if (images.length > 1) {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            const imageSrc = '{{ asset('storage/') }}/' + images[currentImageIndex];
            changeImage(imageSrc, document.querySelectorAll('.thumbnail')[currentImageIndex]);
        }
    }
    
    // Start auto-rotation if there are multiple images
    if (images.length > 1) {
        setInterval(autoRotateImages, 5000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Página de detalhes do projeto carregada:', @json($projectoo));
    });
</script>

<!-- INCLUIR FOOTER COMPARTILHADO -->
@include('layouts.footer')

@endcannot

@endsection