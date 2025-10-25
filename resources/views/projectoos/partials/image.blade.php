@php
    $imagens = $p->imagens ?? [];
    $first = $imagens[0] ?? null;
    $total = count($imagens);
    $height = $type === 'main' ? '500px' : '220px';
    
    // Mais legível e seguro
    $imgClass = match ($type) {
        'main'      => 'main-featured-img',
        'secondary' => 'secondary-img',
        default     => 'project-image-archdaily',
    };
@endphp

<div class="image-container {{ $type }}-image-container" style="height: {{ $height }}" 
     data-images='@json($imagens)' data-index="0">
    @if($first)
        <img src="{{ asset('storage/' . $first) }}" alt="{{ $p->nome }}" class="{{ $imgClass }}"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        @if($total > 1)
            <button class="image-nav-btn prev" onclick="event.stopPropagation(); navigateImage(this, -1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="image-nav-btn next" onclick="event.stopPropagation(); navigateImage(this, 1)">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="image-counter"><span class="current-index">1</span>/<span class="total-images">{{ $total }}</span></div>
        @endif
    @endif
    <div class="image-placeholder" style="{{ $first ? 'display: none;' : '' }}">
        <i class="fas fa-image"></i>
        <span>Sem imagem</span>
    </div>
</div>