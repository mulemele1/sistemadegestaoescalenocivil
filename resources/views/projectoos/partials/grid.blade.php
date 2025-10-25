@if($projectos->count() === 0)
    <div class="empty-state-archdaily">
        <i class="fas fa-folder-open"></i>
        <h3>Nenhum projecto encontrado</h3>
        <p>Não existem projectos para mostrar no momento.</p>
    </div>
@else
    @php
        $principal = $projectos->first();
        $secundarios = $projectos->slice(1, 2);
        $outros = $projectos->slice(3);
    @endphp

    <!-- Destaque + Secundários -->
    @if($principal)
    <div class="featured-grid">
        <div class="main-featured" onclick="window.location='{{ route('projectoos.showuser', $principal->id) }}'">
            @include('projectoos.partials.image', ['p' => $principal, 'type' => 'main'])
            <div class="main-featured-info">
                <div class="main-featured-category">{{ $principal->categoria->name ?? 'Sem categoria' }}</div>
                <div class="main-featured-location">{{ $principal->localizacao->name ?? 'Localização não definida' }}</div>
            </div>
        </div>
        <div class="secondary-featured">
            @foreach($secundarios as $p)
            <div class="secondary-item" onclick="window.location='{{ route('projectoos.showuser', $p->id) }}'">
                @include('projectoos.partials.image', ['p' => $p, 'type' => 'secondary'])
                <div class="secondary-info">
                    <div class="secondary-category">{{ $p->categoria->name ?? 'Sem categoria' }}</div>
                    <div class="secondary-location">{{ $p->localizacao->name ?? 'N/A' }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Grid 3 Colunas -->
    @if($outros->count() > 0)
    <div class="projects-grid-archdaily">
        @foreach($outros as $p)
        <div class="project-card-archdaily" onclick="window.location='{{ route('projectoos.showuser', $p->id) }}'">
            @include('projectoos.partials.image', ['p' => $p, 'type' => 'grid'])
            <div class="project-info-archdaily">
                <div class="project-category-archdaily">{{ $p->categoria->name ?? 'Sem categoria' }}</div>
                <div class="project-location-archdaily">{{ $p->localizacao->name ?? 'Localização não definida' }}</div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
@endif