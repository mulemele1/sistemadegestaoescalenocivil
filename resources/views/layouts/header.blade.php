<!-- resources/views/layouts/header.blade.php -->
<nav class="navbar-custom">
    <div class="nav-container">
        <a href="{{ url('/home') }}" class="nav-logo">
            <i class="fas fa-building mr-2"></i>Escaleno
        </a>
        <div class="nav-links">
    <a href="{{ url('/home') }}" class="nav-link">
        <i class="fas fa-home mr-1"></i> Home
    </a>
    <a href="{{ route('verprojectos') }}" class="nav-link">
        <i class="fas fa-list mr-1"></i> Projectos
    </a>
    <a href="{{ route('sobre') }}" class="nav-link">
        <i class="fas fa-info-circle mr-1"></i> Sobre
    </a>
    <a href="{{ route('contacto') }}" class="nav-link">
        <i class="fas fa-phone mr-1"></i> Contacto
    </a>
</div>
    </div>
</nav>

<style>
    .navbar-custom {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 15px 0;
        margin-bottom: 0;
        width: 100%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .nav-logo {
        color: white;
        font-size: 1.8rem;
        font-weight: bold;
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    
    .nav-links {
        display: flex;
        gap: 30px;
    }
    
    .nav-link {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }
    
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ecf0f1;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .nav-links {
            gap: 15px;
        }
        
        .nav-link {
            font-size: 0.9rem;
            padding: 6px 12px;
        }
        
        .nav-container {
            padding: 0 15px;
            flex-direction: column;
            gap: 15px;
        }
        
        .nav-logo {
            font-size: 1.5rem;
        }
    }
</style>