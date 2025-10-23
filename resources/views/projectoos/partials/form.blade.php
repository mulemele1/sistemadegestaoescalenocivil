@extends('adminlte::page')

@section('title', isset($projectoo) ? 'Editar Projecto - SysEscaleno' : 'Novo Projecto - SysEscaleno')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --light-bg: #f8f9fa;
        --border-radius: 10px;
        --shadow-sm: 0 2px 10px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-custom {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        background: #fff;
    }
    
    .card-header-custom {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }
    
    .card-header-custom .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-header-custom .card-subtitle {
        opacity: 0.9;
        font-size: 0.95rem;
        margin: 0;
    }
    
    .form-section {
        background: var(--light-bg);
        padding: 1.75rem;
        border-radius: var(--border-radius);
        margin-bottom: 1.5rem;
        border-left: 4px solid #2c3e50;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }
    
    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .form-section h5 {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        font-weight: 600;
        font-size: 1.125rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        background: #fff;
        min-height: 48px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.15);
        background: #fff;
    }
    
    .required-field::after {
        content: " *";
        color: var(--danger-color);
        font-weight: 700;
    }
    
    .help-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
        font-style: italic;
    }
    
    .btn-custom {
        padding: 0.875rem 1.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    
    .btn-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-custom:hover::before {
        left: 100%;
    }
    
    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .color-input-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .color-preview {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        border: 3px solid #dee2e6;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }
    
    .color-preview:hover {
        transform: scale(1.05);
        box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.2);
    }
    
    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .image-preview {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 3px solid #dee2e6;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
    
    .image-preview:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-md);
        border-color: #2c3e50;
    }
    
    .current-images {
        background: linear-gradient(135deg, #f1f3f4 0%, #e8ecef 100%);
        padding: 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.25rem;
        border: 2px solid #dee2e6;
    }
    
    .current-images h6 {
        color: #2c3e50;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .button-container {
        display: flex;
        gap: 1rem;
        justify-content: flex-start;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px solid #e9ecef;
        flex-wrap: wrap;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #2c3e50;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Validação visual */
    .is-valid {
        border-color: var(--success-color) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .is-invalid {
        border-color: var(--danger-color) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .button-container {
            flex-direction: column;
        }
        
        .btn-custom {
            width: 100%;
            justify-content: center;
        }
        
        .color-input-container {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .image-preview-container {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .form-section {
            padding: 1.25rem;
        }
        
        .card-header-custom {
            padding: 1.25rem;
        }
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header card-header-custom">
                    <h3 class="card-title mb-0">
                        <i class="fas {{ isset($projectoo) ? 'fa-edit' : 'fa-plus' }}"></i>
                        {{ isset($projectoo) ? 'Editar Projecto' : 'Criar Novo Projecto' }}
                    </h3>
                    <p class="card-subtitle mb-0">
                        {{ isset($projectoo) ? 'Actualize os dados do projecto existente' : 'Preencha os dados para criar um novo projecto' }}
                    </p>
                </div>
                
                <div class="card-body p-0">
                    @include('projectoos.partials.validations')
                    
                    <form action="{{ isset($projectoo) ? route('projectoos.update', $projectoo->id) : route('projectoos.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          id="projectForm"
                          novalidate>
                        @csrf
                        @if(isset($projectoo))
                            @method('PUT')
                        @endif

                        <!-- Informações Básicas -->
                        <div class="form-section">
                            <h5><i class="fas fa-info-circle"></i>Informações Básicas</h5>
                            
                            <div class="row g-4">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="nome" class="form-label required-field">Nome do Projecto</label>
                                        <input type="text" 
                                               name="nome" 
                                               value="{{ $projectoo->nome ?? old('nome') }}" 
                                               class="form-control @error('nome') is-invalid @enderror" 
                                               id="nome" 
                                               placeholder="Ex: Edifício Residencial ABC" 
                                               required 
                                               maxlength="255"
                                               autocomplete="off">
                                        <div class="help-text">Nome descritivo e único do projecto</div>
                                        @error('nome')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="tipografia" class="form-label">Tipografia</label>
                                        <input type="text" 
                                               name="tipografia" 
                                               value="{{ $projectoo->tipografia ?? old('tipografia') }}" 
                                               class="form-control @error('tipografia') is-invalid @enderror" 
                                               id="tipografia" 
                                               placeholder="Ex: Moderna, Clássica, Contemporânea"
                                               maxlength="100">
                                        <div class="help-text">Estilo arquitectónico predominante</div>
                                        @error('tipografia')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="area" class="form-label">Área Total (m²)</label>
                                        <input type="number" 
                                               step="0.01" 
                                               min="0" 
                                               name="area" 
                                               value="{{ $projectoo->area ?? old('area') }}" 
                                               class="form-control @error('area') is-invalid @enderror" 
                                               id="area" 
                                               placeholder="Ex: 1500.50">
                                        <div class="help-text">Área total construída em metros quadrados</div>
                                        @error('area')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="nome_cliente" class="form-label required-field">Nome do Cliente</label>
                                        <input type="text" 
                                               name="nome_cliente" 
                                               value="{{ $projectoo->nome_cliente ?? old('nome_cliente') }}" 
                                               class="form-control @error('nome_cliente') is-invalid @enderror" 
                                               id="nome_cliente" 
                                               placeholder="Ex: João Silva Arquitectura, Lda." 
                                               required 
                                               maxlength="255">
                                        <div class="help-text">Nome completo ou empresa do cliente</div>
                                        @error('nome_cliente')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Classificação e Localização -->
                        <div class="form-section">
                            <h5><i class="fas fa-tags"></i>Classificação e Localização</h5>
                            
                            <div class="row g-4">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="categoria_id" class="form-label required-field">Categoria</label>
                                        <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                                name="categoria_id" 
                                                id="categoria_id" 
                                                required>
                                            <option value="">Selecione uma categoria</option>
                                            @foreach ($fontes as $item)
                                                <option value="{{ $item->id }}" 
                                                        {{ (old('categoria_id', $projectoo->categoria_id ?? '') == $item->id) ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-text">Tipo/classificação do projecto</div>
                                        @error('categoria_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="localizacao_id" class="form-label required-field">Localização</label>
                                        <select class="form-select @error('localizacao_id') is-invalid @enderror" 
                                                name="localizacao_id" 
                                                id="localizacao_id" 
                                                required>
                                            <option value="">Selecione uma localização</option>
                                            @foreach ($gestaos as $item)
                                                <option value="{{ $item->id }}" 
                                                        {{ (old('localizacao_id', $projectoo->localizacao_id ?? '') == $item->id) ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-text">Cidade/região do projecto</div>
                                        @error('localizacao_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="ano_id" class="form-label required-field">Ano</label>
                                        <select class="form-select @error('ano_id') is-invalid @enderror" 
                                                name="ano_id" 
                                                id="ano_id" 
                                                required>
                                            <option value="">Selecione um ano</option>
                                            @foreach ($gerencias as $item)
                                                <option value="{{ $item->id }}" 
                                                        {{ (old('ano_id', $projectoo->ano_id ?? '') == $item->id) ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="help-text">Ano de início ou referência</div>
                                        @error('ano_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Estado e Aparência -->
                        <div class="form-section">
                            <h5><i class="fas fa-chart-line"></i>Estado e Aparência</h5>
                            
                            <div class="row g-4">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="estado" class="form-label required-field">Estado do Projecto</label>
                                        <select name="estado" 
                                                class="form-select @error('estado') is-invalid @enderror" 
                                                id="estado" 
                                                required>
                                            <option value="ACTIVO" {{ old('estado', $projectoo->estado ?? '') == 'ACTIVO' ? 'selected' : '' }}>🟢 Activo</option>
                                            <option value="EM_CURSO" {{ old('estado', $projectoo->estado ?? '') == 'EM_CURSO' ? 'selected' : '' }}>🟡 Em Andamento</option>
                                            <option value="CONCLUIDO" {{ old('estado', $projectoo->estado ?? '') == 'CONCLUIDO' ? 'selected' : '' }}>🟣 Concluído</option>
                                        </select>
                                        <div class="help-text">Estado actual de execução do projecto</div>
                                        @error('estado')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label for="cor" class="form-label">Cor Representativa</label>
                                        <div class="color-input-container">
                                            <input type="color" 
                                                   name="cor" 
                                                   value="{{ $projectoo->cor ?? old('cor', '#2c3e50') }}" 
                                                   class="form-control form-control-color" 
                                                   id="cor" 
                                                   title="Seleccionar cor">
                                            <div class="color-preview" 
                                                 style="background-color: {{ $projectoo->cor ?? '#2c3e50' }};"
                                                 title="Cor actual">
                                            </div>
                                        </div>
                                        <div class="help-text">Cor identificativa do projecto para relatórios</div>
                                        @error('cor')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Imagens -->
                        <div class="form-section">
                            <h5><i class="fas fa-images"></i>Galeria de Imagens</h5>
                            
                            @if(isset($projectoo) && !empty($projectoo->imagens))
                                <div class="current-images">
                                    <h6><i class="fas fa-images mr-2"></i>Imagens Existentes ({{ count($projectoo->imagens) }})</h6>
                                    <div class="image-preview-container">
                                        @foreach($projectoo->imagens as $imagem)
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $imagem) }}" 
                                                     alt="Imagem do projecto" 
                                                     class="image-preview"
                                                     loading="lazy"
                                                     onerror="this.style.display='none'; this.parentElement.style.display='none'">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="help-text mt-3">Imagens actualmente associadas ao projecto</div>
                                </div>
                            @endif
                            
                            <div class="form-group">
                                <label for="imagens" class="form-label">
                                    {{ isset($projectoo) ? 'Adicionar Novas Imagens' : 'Carregar Imagens do Projecto' }}
                                </label>
                                <input type="file" 
                                       name="imagens[]" 
                                       multiple 
                                       class="form-control @error('imagens') is-invalid @enderror" 
                                       id="imagens"
                                       accept="image/jpeg,image/png,image/webp,image/gif"
                                       data-max-files="10"
                                       data-max-size="5242880">
                                <div class="help-text">
                                    📁 Máximo 10 imagens | 📏 5MB cada | ✅ JPG, PNG, WebP, GIF
                                </div>
                                @error('imagens')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                
                                <div class="file-preview">
                                    <div id="imagePreview" class="image-preview-container"></div>
                                    <div id="fileInfo" class="help-text mt-2" style="display: none;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Acção -->
                        <div class="form-section">
                            <div class="button-container">
                                <button type="submit" class="btn btn-primary btn-custom" id="submitBtn">
                                    <i class="fas fa-save"></i>
                                    {{ isset($projectoo) ? 'Actualizar Projecto' : 'Criar Projecto' }}
                                </button>
                                
                                <a href="{{ route('projectoos.list') }}" class="btn btn-secondary btn-custom">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </a>
                                
                                @if(isset($projectoo))
                                    <a href="{{ route('projectoos.show', $projectoo->id) }}" class="btn btn-info btn-custom">
                                        <i class="fas fa-eye"></i>
                                        Visualizar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function() {
    'use strict';
    
    class ProjectFormHandler {
        constructor() {
            this.form = document.getElementById('projectForm');
            this.submitBtn = document.getElementById('submitBtn');
            this.imageInput = document.getElementById('imagens');
            this.imagePreview = document.getElementById('imagePreview');
            this.fileInfo = document.getElementById('fileInfo');
            this.loadingOverlay = document.getElementById('loadingOverlay');
            
            this.isSubmitting = false;
            this.formChanged = false;
            this.maxFiles = parseInt(this.imageInput?.dataset.maxFiles || 10);
            this.maxSize = parseInt(this.imageInput?.dataset.maxSize || 5242880); // 5MB
            
            this.init();
        }
        
        init() {
            if (!this.form) return;
            
            this.bindEvents();
            this.validateForm();
            this.watchFormChanges();
            this.initImagePreview();
        }
        
        bindEvents() {
            // Form submit
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
            
            // Image input change
            if (this.imageInput) {
                this.imageInput.addEventListener('change', () => this.handleImageChange());
            }
            
            // Real-time validation
            this.form.addEventListener('blur', (e) => this.validateField(e.target), true);
            this.form.addEventListener('input', (e) => this.validateField(e.target));
        }
        
        handleImageChange() {
            const files = this.imageInput.files;
            this.imagePreview.innerHTML = '';
            this.fileInfo.style.display = 'none';
            
            let validFiles = 0;
            let totalSize = 0;
            
            Array.from(files).forEach((file, index) => {
                if (validFiles >= this.maxFiles) return;
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    this.showFileError(file.name, 'Tipo de ficheiro não suportado');
                    return;
                }
                
                // Validate file size
                if (file.size > this.maxSize) {
                    this.showFileError(file.name, `Ficheiro demasiado grande (${this.formatBytes(file.size)})`);
                    return;
                }
                
                totalSize += file.size;
                validFiles++;
                
                this.createImagePreview(file);
            });
            
            if (files.length > 0) {
                this.fileInfo.style.display = 'block';
                this.fileInfo.innerHTML = `
                    ✅ ${validFiles} ficheiro(s) válido(s) | 
                    📦 ${this.formatBytes(totalSize)} total | 
                    🎯 ${files.length - validFiles} inválido(s)
                `;
            }
        }
        
        createImagePreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'position-relative';
                imgContainer.innerHTML = `
                    <img src="${e.target.result}" class="image-preview" loading="lazy" alt="${file.name}">
                    <small class="position-absolute bottom-0 start-0 bg-dark text-white px-1 py-0 rounded ms-1 mb-1">
                        ${this.formatBytes(file.size)}
                    </small>
                `;
                this.imagePreview.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        }
        
        showFileError(filename, message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger alert-dismissible fade show small mt-2';
            errorDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>${filename}:</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            this.imagePreview.parentElement.appendChild(errorDiv);
            
            // Auto remove after 5 seconds
            setTimeout(() => errorDiv.remove(), 5000);
        }
        
        formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        validateField(field) {
            if (!field.hasAttribute('required') && !field.hasAttribute('pattern')) return;
            
            const value = field.value.trim();
            const isValid = field.hasAttribute('required') ? value.length > 0 : true;
            
            field.classList.toggle('is-invalid', !isValid);
            field.classList.toggle('is-valid', isValid);
        }
        
        validateForm() {
            const requiredFields = this.form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) isValid = false;
            });
            
            return isValid;
        }
        
        handleSubmit(e) {
            if (this.isSubmitting) {
                e.preventDefault();
                return false;
            }
            
            if (!this.validateForm()) {
                e.preventDefault();
                this.showAlert('warning', 'Por favor, preencha todos os campos obrigatórios marcados com *');
                return false;
            }
            
            this.isSubmitting = true;
            this.showLoading(true);
            
            // Update submit button
            this.submitBtn.disabled = true;
            this.submitBtn.innerHTML = `
                <i class="fas fa-spinner fa-spin me-2"></i>
                A processar...
            `;
        }
        
        watchFormChanges() {
            const inputs = this.form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                input.addEventListener('change', () => this.formChanged = true);
                input.addEventListener('input', () => this.formChanged = true);
            });
            
            
        }
        
        showLoading(show = true) {
            this.loadingOverlay.style.display = show ? 'flex' : 'none';
        }
        
        showAlert(icon, title, text = '') {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonText: 'Entendido',
                timer: icon === 'success' ? 3000 : undefined,
                toast: icon === 'success',
                position: 'top-end',
                showConfirmButton: icon !== 'success',
                timerProgressBar: true
            });
        }
    }
    
    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        new ProjectFormHandler();
        
        // Auto-validation on load for edit mode
        setTimeout(() => {
            const inputs = document.querySelectorAll('input[required], select[required]');
            inputs.forEach(input => {
                if (input.value.trim()) {
                    input.classList.add('is-valid');
                }
            });
        }, 100);
    });
    
    // Global success handler (called from controller redirect)
    window.showSuccess = (message = 'Operação realizada com sucesso!') => {
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });
    };
    
})();
</script>

@endsection