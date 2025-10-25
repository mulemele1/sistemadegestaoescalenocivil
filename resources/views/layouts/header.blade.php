<!-- resources/views/layouts/header.blade.php -->
<nav class="navbar-custom">
    <div class="nav-container">
        <!-- Logo + Pesquisa (lado esquerdo) -->
        <div class="nav-left">
            <a href="{{ url('/home') }}" class="nav-logo">
                <i class="fas fa-building mr-1"></i>Escaleno
            </a>

            <!-- Campo de Pesquisa (MAIS LARGO) -->
            <form method="GET" class="search-form">
                <div class="search-container">
                    <input
                        type="text"
                        name="q"
                        placeholder="Pesquisar projectos..."
                        class="search-input"
                        value="{{ request('q') }}"
                        required
                    >
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Links + Botões de login/cadastro (lado direito) -->
        <div class="nav-links">
            <a href="{{ route('verprojectos') }}" class="nav-link">
                <i class="fas fa-list mr-1"></i> Projectos
            </a>
            <a href="{{ route('sobre') }}" class="nav-link">
                <i class="fas fa-info-circle mr-1"></i> Sobre
            </a>
            <a href="{{ route('contacto') }}" class="nav-link">
                <i class="fas fa-phone mr-1"></i> Contacto
            </a>

            <span class="nav-separator">|</span>

            <a href="{{ route('login') }}" class="nav-link nav-link-auth">
                Conecte-se
            </a>

            <a href="{{ route('register') }}" class="nav-link nav-link-auth nav-link-primary">
                Inscrever-se
            </a>
        </div>
    </div>
</nav>

<style>
    .navbar-custom {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 10px 0;
        width: 100%;
        box-shadow: 0 2px 8px rgba(0,0,0,.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 15px;
        flex-wrap: wrap;
        gap: 12px;
    }

    /* ----- Lado esquerdo ----- */
    .nav-left {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .nav-logo {
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
        text-decoration: none;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }

    /* ----- Links ----- */
    .nav-links {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-link {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 6px 12px;
        border-radius: 4px;
        transition: all .3s ease;
        display: flex;
        align-items: center;
    }

    .nav-link:hover {
        background: rgba(255,255,255,.1);
        color: #ecf0f1;
        transform: translateY(-1px);
    }

    /* ----- Separador ----- */
    .nav-separator {
        color: rgba(255,255,255,.5);
        font-weight: 300;
        font-size: 0.9rem;
        user-select: none;
    }

    /* ----- Botões de autenticação ----- */
    .nav-link-auth {
        font-weight: 600;
        font-size: 0.9rem;
        padding: 6px 10px;
    }

    .nav-link-primary {
        background: #e74c3c;
        color: #fff;
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 0.9rem;
        transition: background .3s ease, transform .2s ease;
    }

    .nav-link-primary:hover {
        background: #c0392b;
        transform: translateY(-1px);
    }

    /* ----- PESQUISA (MAIS LARGA) ----- */
    .search-form { display: flex; align-items: center; }
    .search-container { position: relative; display: flex; align-items: center; }

    .search-input {
        padding: 8px 36px 8px 14px;           /* +4px no botão à direita */
        border: none;
        border-radius: 22px;                  /* +2px para acompanhar largura */
        font-size: 0.9rem;
        width: 280px;                         /* ANTES:, AGORA +100px */
        background: rgba(255,255,255,.15);
        color: #fff;
        backdrop-filter: blur(5px);
        transition: all .3s ease;
        outline: none;
    }

    .search-input::placeholder {
        color: rgba(255,255,255,.7);
        font-size: 0.88rem;
    }

    .search-input:focus {
        background: rgba(255,255,255,.25);
        box-shadow: 0 0 0 2px rgba(255,255,255,.3);
        width: 320px;                         /* +120px no foco */
    }

    .search-btn {
        position: absolute;
        right: 8px;
        background: transparent;
        border: none;
        color: #fff;
        font-size: 0.95rem;
        cursor: pointer;
        padding: 4px;
        transition: transform .2s ease;
    }
    .search-btn:hover { transform: scale(1.1); }

    /* ----- Responsividade ----- */
    @media (max-width: 992px) {
        .search-input { width: 240px; }
        .search-input:focus { width: 270px; }
        .nav-left { gap: 12px; }
    }

    @media (max-width: 768px) {
        .nav-container { flex-direction: column; padding: 12px; gap: 12px; }

        .nav-left {
            order: 1;
            width: 100%;
            justify-content: space-between;
            flex-wrap: nowrap;
        }
        .nav-logo { font-size: 1.4rem; }

        .search-form { flex: 1; max-width: 100%; }
        .search-input { 
            width: 100%; 
            font-size: 0.9rem; 
            max-width: none;
        }
        .search-input:focus { width: 100%; }

        .nav-links {
            order: 2;
            width: 100%;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }
        .nav-separator { display: none; }
    }

    @media (max-width: 480px) {
        .nav-left { flex-direction: column; align-items: stretch; gap: 10px; }
        .search-input { font-size: 0.85rem; }
        .nav-link { font-size: 0.8rem; padding: 5px 8px; }
        .nav-link-auth { font-size: 0.85rem; padding: 5px 8px; }
        .nav-link-primary { padding: 5px 12px; }
    }

    .archdaily-layout {
        padding-top: 35px;
        padding-bottom: 55px;
    }
</style>