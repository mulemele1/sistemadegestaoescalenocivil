<?php

use App\Http\Controllers\{
    AdministracaoController,
    DashboardController,
    DesembolsoinsController,
    DesembolsoController,
    DesembolsoinsfonteController,
    DesembolsodafController,
    DispensaController,
    DistribuicaoController,
    FonteController,
    GraficoController,
    ParticipanteController,
    ProjectoController,
    ProjectooController,
    RecepcaoController,
    UserController,
    PropostaController,
    RequisicaoController,
    GestaoController,
    GerenciaController,
    RequisicaocispoController,
    DashboarduserController
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rotas Públicas
Route::get('/', function () {
    return view('auth/login');
});

// Autenticação
Auth::routes();

// Rotas de Gráficos e Relatórios
Route::prefix('relatorios')->group(function () {
    Route::get('/projecto/anos', [GraficoController::class, 'projectoAnos'])->name('relatorios.projecto.anos');
    Route::get('/projecto/ano', [GraficoController::class, 'projectoAno'])->name('relatorios.projecto.ano');
    Route::get('/administracao/anos', [GraficoController::class, 'administracaoAnos'])->name('relatorios.administracao.anos');
    Route::get('/administracao/ano', [GraficoController::class, 'administracaoAno'])->name('relatorios.administracao.ano');
    Route::get('/recepcao/anos', [GraficoController::class, 'recepcaoAnos'])->name('relatorios.recepcao.anos');
    Route::get('/recepcao/ano', [GraficoController::class, 'recepcaoAno'])->name('relatorios.recepcao.ano');
    Route::get('/participanteDN/anoN', [GraficoController::class, 'participanteAnoDN'])->name('relatorios.participanteDN.anoN');
    Route::get('/participanteDV/anoV', [GraficoController::class, 'participanteAnoDV'])->name('relatorios.participanteDV.anoV');
    Route::get('/fontedaf/ano', [GraficoController::class, 'fontedafAno'])->name('relatorios.fontedaf.ano');
    Route::get('/fontedaf/anos', [GraficoController::class, 'fontedafAnos'])->name('relatorios.fontedaf.anos');
});

// Rotas Públicas do SysEscaleno (acessíveis sem auth)
Route::prefix('sysescaleno')->group(function () {
    // Páginas públicas
    Route::get('/sobre', [ProjectooController::class, 'sobre'])->name('sobre');
    Route::get('/contacto', [ProjectooController::class, 'contacto'])->name('contacto');
    Route::get('/verprojectos', [ProjectooController::class, 'verprojectos'])->name('verprojectos');
    
    // Visualização pública de projetos
    Route::get('/projectos/{id}', [ProjectooController::class, 'showuser'])
        ->name('projectoos.showuser');
});

// Rotas Protegidas (requerem autenticação)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/home', [DashboardController::class, 'recuperar'])->name('recuperar');

    // CRUD Routes - Projectoos
    Route::prefix('projectoos')->group(function () {
        Route::get('/list', [ProjectooController::class, 'list'])->name('projectoos.list');
        Route::get('/create', [ProjectooController::class, 'create'])->name('projectoos.create');
        Route::post('/', [ProjectooController::class, 'store'])->name('projectoos.store');
        Route::get('/{id}', [ProjectooController::class, 'show'])->name('projectoos.show');
        Route::get('/{id}/edit', [ProjectooController::class, 'edit'])->name('projectoos.edit');
        Route::put('/{id}', [ProjectooController::class, 'update'])->name('projectoos.update');
        Route::delete('/{id}', [ProjectooController::class, 'delete'])->name('projectoos.delete');
        Route::get('/export/csv', [ProjectooController::class, 'exportCSV'])->name('projectoos.export.csv');
    });

    // CRUD Routes - Fontes
    Route::prefix('fontes')->group(function () {
        Route::get('/list', [FonteController::class, 'list'])->name('fontes.list');
        Route::get('/create', [FonteController::class, 'create'])->name('fontes.create');
        Route::post('/', [FonteController::class, 'store'])->name('fontes.store');
        Route::get('/{id}', [FonteController::class, 'show'])->name('fontes.show');
        Route::get('/{id}/edit', [FonteController::class, 'edit'])->name('fontes.edit');
        Route::put('/{id}', [FonteController::class, 'update'])->name('fontes.update');
        Route::delete('/{id}', [FonteController::class, 'delete'])->name('fontes.delete');
    });

    // CRUD Routes - Gestão
    Route::prefix('gestaos')->group(function () {
        Route::get('/list', [GestaoController::class, 'list'])->name('gestaos.list');
        Route::get('/create', [GestaoController::class, 'create'])->name('gestaos.create');
        Route::post('/', [GestaoController::class, 'store'])->name('gestaos.store');
        Route::get('/{id}', [GestaoController::class, 'show'])->name('gestaos.show');
        Route::get('/{id}/edit', [GestaoController::class, 'edit'])->name('gestaos.edit');
        Route::put('/{id}', [GestaoController::class, 'update'])->name('gestaos.update');
        Route::delete('/{id}', [GestaoController::class, 'delete'])->name('gestaos.delete');
    });

    // CRUD Routes - Gerência
    Route::prefix('gerencias')->group(function () {
        Route::get('/list', [GerenciaController::class, 'list'])->name('gerencias.list');
        Route::get('/create', [GerenciaController::class, 'create'])->name('gerencias.create');
        Route::post('/', [GerenciaController::class, 'store'])->name('gerencias.store');
        Route::get('/{id}', [GerenciaController::class, 'show'])->name('gerencias.show');
        Route::get('/{id}/edit', [GerenciaController::class, 'edit'])->name('gerencias.edit');
        Route::put('/{id}', [GerenciaController::class, 'update'])->name('gerencias.update');
        Route::delete('/{id}', [GerenciaController::class, 'delete'])->name('gerencias.delete');
    });

    // CRUD Routes - Administração
    Route::prefix('administracaos')->group(function () {
        Route::get('/list', [AdministracaoController::class, 'list'])->name('administracaos.list');
        Route::get('/create', [AdministracaoController::class, 'create'])->name('administracaos.create');
        Route::post('/', [AdministracaoController::class, 'store'])->name('administracaos.store');
        Route::get('/{id}', [AdministracaoController::class, 'show'])->name('administracaos.show');
        Route::get('/{id}/edit', [AdministracaoController::class, 'edit'])->name('administracaos.edit');
        Route::put('/{id}', [AdministracaoController::class, 'update'])->name('administracaos.update');
        Route::delete('/{id}', [AdministracaoController::class, 'delete'])->name('administracaos.delete');
    });

    // CRUD Routes - Participantes
    Route::prefix('participantes')->group(function () {
        Route::get('/list', [ParticipanteController::class, 'list'])->name('participantes.list');
        Route::get('/create', [ParticipanteController::class, 'create'])->name('participantes.create');
        Route::post('/', [ParticipanteController::class, 'store'])->name('participantes.store');
        Route::get('/{id}', [ParticipanteController::class, 'show'])->name('participantes.show');
        Route::get('/{id}/edit', [ParticipanteController::class, 'edit'])->name('participantes.edit');
        Route::put('/{id}', [ParticipanteController::class, 'update'])->name('participantes.update');
        Route::delete('/{id}', [ParticipanteController::class, 'delete'])->name('participantes.delete');
        
        // Importação de participantes
        Route::post('/carregar', [ParticipanteController::class, 'carregar']);
        Route::post('/guardar', [ParticipanteController::class, 'guardar']);
        Route::post('/import', [ParticipanteController::class, 'import'])->name('participantes.import');
    });

    // CRUD Routes - Recepção
    Route::prefix('recepcaos')->group(function () {
        Route::get('/list', [RecepcaoController::class, 'list'])->name('recepcaos.list');
        Route::get('/create', [RecepcaoController::class, 'create'])->name('recepcaos.create');
        Route::post('/', [RecepcaoController::class, 'store'])->name('recepcaos.store');
        Route::get('/{id}', [RecepcaoController::class, 'show'])->name('recepcaos.show');
        Route::get('/{id}/edit', [RecepcaoController::class, 'edit'])->name('recepcaos.edit');
        Route::put('/{id}', [RecepcaoController::class, 'update'])->name('recepcaos.update');
        Route::delete('/{id}', [RecepcaoController::class, 'delete'])->name('recepcaos.delete');
    });

    // CRUD Routes - Users
    Route::prefix('users')->group(function () {
        Route::get('/list', [UserController::class, 'list'])->name('users.list');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'delete'])->name('users.delete');
    });

    // Operações - Propostas
    Route::prefix('propostas')->group(function () {
        Route::get('/list', [PropostaController::class, 'list'])->name('propostas.list');
        Route::get('/create', [PropostaController::class, 'create'])->name('propostas.create');
        Route::post('/', [PropostaController::class, 'store'])->name('propostas.store');
        Route::get('/{id}', [PropostaController::class, 'show'])->name('propostas.show');
        Route::get('/{id}/edit', [PropostaController::class, 'edit'])->name('propostas.edit');
        Route::put('/{id}', [PropostaController::class, 'update'])->name('propostas.update');
        Route::delete('/{id}', [PropostaController::class, 'delete'])->name('propostas.delete');
    });

    // Operações - Desembolso de Fontes
    Route::prefix('desembolsoinsfontes')->group(function () {
        Route::get('/list', [DesembolsoinsfonteController::class, 'list'])->name('desembolsoinsfontes.list');
        Route::get('/create', [DesembolsoinsfonteController::class, 'create'])->name('desembolsoinsfontes.create');
        Route::post('/', [DesembolsoinsfonteController::class, 'store'])->name('desembolsoinsfontes.store');
        Route::get('/{id}', [DesembolsoinsfonteController::class, 'show'])->name('desembolsoinsfontes.show');
        Route::get('/{id}/edit', [DesembolsoinsfonteController::class, 'edit'])->name('desembolsoinsfontes.edit');
        Route::put('/{id}', [DesembolsoinsfonteController::class, 'update'])->name('desembolsoinsfontes.update');
        Route::delete('/{id}', [DesembolsoinsfonteController::class, 'delete'])->name('desembolsoinsfontes.delete');
    });

    // Operações - Desembolsos
    Route::prefix('desembolsos')->group(function () {
        Route::get('/list', [DesembolsoController::class, 'list'])->name('desembolsos.list');
        Route::get('/create', [DesembolsoController::class, 'create'])->name('desembolsos.create');
        Route::post('/', [DesembolsoController::class, 'store'])->name('desembolsos.store');
        Route::get('/{id}', [DesembolsoController::class, 'show'])->name('desembolsos.show');
        Route::get('/{id}/edit', [DesembolsoController::class, 'edit'])->name('desembolsos.edit');
        Route::put('/{id}', [DesembolsoController::class, 'update'])->name('desembolsos.update');
        Route::delete('/{id}', [DesembolsoController::class, 'delete'])->name('desembolsos.delete');
    });

    // Operações - Desembolsos DAF
    Route::prefix('desembolsodafs')->group(function () {
        Route::get('/list', [DesembolsodafController::class, 'list'])->name('desembolsodafs.list');
        Route::get('/create', [DesembolsodafController::class, 'create'])->name('desembolsodafs.create');
        Route::post('/', [DesembolsodafController::class, 'store'])->name('desembolsodafs.store');
        Route::get('/{id}', [DesembolsodafController::class, 'show'])->name('desembolsodafs.show');
        Route::get('/{id}/edit', [DesembolsodafController::class, 'edit'])->name('desembolsodafs.edit');
        Route::put('/{id}', [DesembolsodafController::class, 'update'])->name('desembolsodafs.update');
        Route::delete('/{id}', [DesembolsodafController::class, 'delete'])->name('desembolsodafs.delete');
    });

    // Operações - Requisições
    Route::prefix('requisicaos')->group(function () {
        Route::get('/list', [RequisicaoController::class, 'list'])->name('requisicaos.list');
        Route::get('/create', [RequisicaoController::class, 'create'])->name('requisicaos.create');
        Route::post('/', [RequisicaoController::class, 'store'])->name('requisicaos.store');
        Route::get('/{id}', [RequisicaoController::class, 'show'])->name('requisicaos.show');
        Route::get('/{id}/edit', [RequisicaoController::class, 'edit'])->name('requisicaos.edit');
        Route::put('/{id}', [RequisicaoController::class, 'update'])->name('requisicaos.update');
        Route::delete('/{id}', [RequisicaoController::class, 'delete'])->name('requisicaos.delete');
    });

    // Operações - Dispensas
    Route::prefix('dispensas')->group(function () {
        Route::get('/list', [DispensaController::class, 'list'])->name('dispensas.list');
        Route::get('/create', [DispensaController::class, 'create'])->name('dispensas.create');
        Route::post('/', [DispensaController::class, 'store'])->name('dispensas.store');
        Route::get('/{id}', [DispensaController::class, 'show'])->name('dispensas.show');
        Route::get('/{id}/edit', [DispensaController::class, 'edit'])->name('dispensas.edit');
        Route::put('/{id}', [DispensaController::class, 'update'])->name('dispensas.update');
        Route::delete('/{id}', [DispensaController::class, 'delete'])->name('dispensas.delete');
    });

    // Rotas de Debug e Diagnóstico
    Route::prefix('debug')->group(function () {
        Route::get('/projectoos', [ProjectooController::class, 'debugData'])->name('projectoos.debug');
        Route::get('/storage', [ProjectooController::class, 'testStorage'])->name('storage.test');
        Route::get('/check-images', [ProjectooController::class, 'checkImages']);
        Route::get('/check-images/{id}', [ProjectooController::class, 'checkImages']);
        Route::get('/diagnostic', [ProjectooController::class, 'diagnostic']);
    });

});

// Importação geral (mantida separada por compatibilidade)
Route::post('/import', [ParticipanteController::class, "import"]);