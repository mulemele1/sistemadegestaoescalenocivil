{{-- resources/views/layouts/header.blade.php --}}
@include('layouts.header')

{{-- Conteúdo Principal com padding para header fixo --}}
<div class="content-with-fixed-header">
    <div class="archdaily-layout">

        @if($projectosRecentes->count() > 0)
            @php
                $projetoPrincipal = $projectosRecentes->first();
                $projetosSecundarios = $projectosRecentes->slice(1, 2);
                $outrosProjetos = $projectosRecentes->slice(3);
            @endphp

            <!-- Layout Principal: Destaque + 2 Secundários -->
            <div class="featured-grid">
                <!-- Projeto Principal (70%) -->
                <div class="main-featured" onclick="window.location='{{ route('projectoos.showuser', $projetoPrincipal->id) }}'">
                    <div class="image-container main-image-container">
                        @if(isset($projetoPrincipal->imagens) && count($projetoPrincipal->imagens) > 0)
                            <img src="{{ asset('storage/' . $projetoPrincipal->imagens[0]) }}" 
                                 alt="{{ $projetoPrincipal->nome }}" 
                                 class="main-featured-img"
                                 data-project-id="{{ $projetoPrincipal->id }}"
                                 data-current-index="0"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            
                            @if(count($projetoPrincipal->imagens) > 1)
                                <button class="image-nav-btn prev" onclick="event.stopPropagation(); navigateImage(this, -1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="image-nav-btn next" onclick="event.stopPropagation(); navigateImage(this, 1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <div class="image-counter">
                                    <span class="current-index">1</span>/<span class="total-images">{{ count($projetoPrincipal->imagens) }}</span>
                                </div>
                            @endif
                        @endif
                        <div class="image-placeholder" style="{{ isset($projetoPrincipal->imagens) && count($projetoPrincipal->imagens) > 0 ? 'display: none;' : '' }}">
                            <i class="fas fa-image"></i>
                            <span>Sem imagem disponível</span>
                        </div>
                    </div>
                    <div class="main-featured-info">
                        <div class="main-featured-category">
                            {{ $projetoPrincipal->categoria->name ?? 'Sem categoria' }}
                        </div>
                        <div class="main-featured-location">
                            {{ $projetoPrincipal->localizacao->name ?? 'Localização não definida' }}
                        </div>
                    </div>
                </div>

                <!-- Projetos Secundários (30%) -->
                <div class="secondary-featured">
                    @foreach($projetosSecundarios as $projetoSecundario)
                    <div class="secondary-item" onclick="window.location='{{ route('projectoos.showuser', $projetoSecundario->id) }}'">
                        <div class="image-container secondary-image-container">
                            @if(isset($projetoSecundario->imagens) && count($projetoSecundario->imagens) > 0)
                                <img src="{{ asset('storage/' . $projetoSecundario->imagens[0]) }}" 
                                     alt="{{ $projetoSecundario->nome }}" 
                                     class="secondary-img"
                                     data-project-id="{{ $projetoSecundario->id }}"
                                     data-current-index="0"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    
                                @if(count($projetoSecundario->imagens) > 1)
                                    <button class="image-nav-btn prev" onclick="event.stopPropagation(); navigateImage(this, -1)">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button class="image-nav-btn next" onclick="event.stopPropagation(); navigateImage(this, 1)">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                    <div class="image-counter">
                                        <span class="current-index">1</span>/<span class="total-images">{{ count($projetoSecundario->imagens) }}</span>
                                    </div>
                                @endif
                            @endif
                            <div class="image-placeholder" style="{{ isset($projetoSecundario->imagens) && count($projetoSecundario->imagens) > 0 ? 'display: none;' : '' }}">
                                <i class="fas fa-image"></i>
                                <span>Sem imagem</span>
                            </div>
                        </div>
                        <div class="secondary-info">
                            <div class="secondary-category">
                                {{ $projetoSecundario->categoria->name ?? 'Sem categoria' }}
                            </div>
                            <div class="secondary-location">
                                {{ $projetoSecundario->localizacao->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Grid de 3 Colunas para os Restantes Projetos -->
            @if($outrosProjetos->count() > 0)
            <div class="projects-grid-archdaily">
                @foreach($outrosProjetos as $projecto)
                <div class="project-card-archdaily" onclick="window.location='{{ route('projectoos.showuser', $projecto->id) }}'">
                    <div class="image-container project-image-container">
                        @if(isset($projecto->imagens) && count($projecto->imagens) > 0)
                            <img src="{{ asset('storage/' . $projecto->imagens[0]) }}" 
                                 alt="{{ $projecto->nome }}" 
                                 class="project-image-archdaily"
                                 data-project-id="{{ $projecto->id }}"
                                 data-current-index="0"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            
                            @if(count($projecto->imagens) > 1)
                                <button class="image-nav-btn prev" onclick="event.stopPropagation(); navigateImage(this, -1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="image-nav-btn next" onclick="event.stopPropagation(); navigateImage(this, 1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <div class="image-counter">
                                    <span class="current-index">1</span>/<span class="total-images">{{ count($projecto->imagens) }}</span>
                                </div>
                            @endif
                        @endif
                        <div class="image-placeholder" style="{{ isset($projecto->imagens) && count($projecto->imagens) > 0 ? 'display: none;' : '' }}">
                            <i class="fas fa-image"></i>
                            <span>Sem imagem</span>
                        </div>
                    </div>
                    <div class="project-info-archdaily">
                        <div class="project-category-archdaily">
                            {{ $projecto->categoria->name ?? 'Sem categoria' }}
                        </div>
                        <div class="project-location-archdaily">
                            {{ $projecto->localizacao->name ?? 'Localização não definida' }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        @else
            <!-- Estado Vazio -->
            <div class="empty-state-archdaily">
                <i class="fas fa-folder-open"></i>
                <h3 style="color: #6c757d; margin-bottom: 15px;">Nenhum projecto encontrado</h3>
                <p style="color: #6c757d; max-width: 400px; margin: 0 auto;">
                    Não existem projectos para mostrar no momento. Volte mais tarde para descobrir novos trabalhos.
                </p>
            </div>
        @endif
    </div>
</div>

{{-- Footer --}}
@include('layouts.footer')

{{-- Botão Voltar ao Topo --}}
<button id="back-to-top" title="Voltar ao topo">
    <i class="fas fa-arrow-up"></i>
</button>

{{-- Estilos --}}
<style>
    /* Header fixo */
    .archdaily-header-fixed {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: white;
        padding: 20px 40px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .content-with-fixed-header {
        padding-top: 140px;
    }

    .archdaily-title {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a1a1a;
    }

    .archdaily-subtitle {
        margin: 8px 0 0;
        font-size: 1.1rem;
        color: #555;
        max-width: 700px;
    }

    /* Botão Voltar ao Topo */
    #back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999;
        width: 50px;
        height: 50px;
        background-color: #1a1a1a;
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        outline: none;
    }

    #back-to-top:hover {
        background-color: #333;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
    }

    #back-to-top.show {
        display: flex;
    }

    /* Responsivo */
    @media (max-width: 768px) {
        .archdaily-header-fixed { padding: 15px 20px; }
        .archdaily-title { font-size: 1.8rem; }
        .content-with-fixed-header { padding-top: 120px; }
        #back-to-top {
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
            bottom: 20px;
            right: 20px;
        }
    }
</style>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Animação de entrada dos cards
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
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.main-featured, .secondary-item, .project-card-archdaily').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(el);
    });

    // Preload de imagens
    document.querySelectorAll('img[src]').forEach(img => {
        if (img.getAttribute('src')) new Image().src = img.getAttribute('src');
    });

    // Botão Voltar ao Topo
    const backToTopButton = document.getElementById('back-to-top');
    window.addEventListener('scroll', () => {
        backToTopButton.classList.toggle('show', window.scrollY > 300);
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Inicializar estado dos botões de navegação de imagens
    document.querySelectorAll('.image-container').forEach(container => {
        const totalImages = parseInt(container.querySelector('.total-images')?.textContent || 1);
        updateButtonStates(container, 0, totalImages);
    });
});

// Navegação entre imagens
function navigateImage(button, direction) {
    const container = button.closest('.image-container');
    const img = container.querySelector('img');
    const projectId = img.getAttribute('data-project-id');
    const currentIndex = parseInt(img.getAttribute('data-current-index'));
    const totalImages = parseInt(container.querySelector('.total-images')?.textContent || 1);
    
    let newIndex = (currentIndex + direction + totalImages) % totalImages;
    
    const images = @json($projectosRecentes->pluck('imagens', 'id')->toArray());
    const projectImages = images[projectId] || [];
    
    if (projectImages[newIndex]) {
        img.src = "{{ asset('storage/') }}/" + projectImages[newIndex];
        img.setAttribute('data-current-index', newIndex);
        
        const counter = container.querySelector('.current-index');
        if (counter) counter.textContent = newIndex + 1;
        
        updateButtonStates(container, newIndex, totalImages);
    }
}

function updateButtonStates(container, currentIndex, totalImages) {
    const prevBtn = container.querySelector('.prev');
    const nextBtn = container.querySelector('.next');
    if (prevBtn) prevBtn.disabled = totalImages <= 1;
    if (nextBtn) nextBtn.disabled = totalImages <= 1;
}
</script>