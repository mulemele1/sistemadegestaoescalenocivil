<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Administracao;
use App\Models\Desembolso;
use App\Models\Dispensa;
use App\Models\Distribuicao;
use App\Models\Fonte;
use App\Models\Participante;
use App\Models\Projectoo;
use App\Models\Proposta;
use App\Models\Recepcao;
use App\Models\Requisicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gestao;
use App\Models\Desembolsodaf;

class DashboarduserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function recuperar(Request $request)
{
    $fontes = Fonte::all();
    $requisicaos = Requisicao::all();
    $recepcaos = Recepcao::all();
    $desembolsos = Desembolso::all();
    $dispensas = Dispensa::all();
    $propostas = Proposta::all();
    
    // CORREÇÃO: Mostrar apenas os últimos 3 projetos e incluir ACTIVE nos em curso
    $projectoos = Projectoo::with(['categoria', 'localizacao'])
        ->orderBy('created_at', 'desc')
        ->take(3) // Apenas os 3 mais recentes
        ->get();
    
    $participantes = Participante::all();
    $administracaos = Administracao::all();
    $distribuicaos = Distribuicao::all();
    $gestaos = Gestao::all();
    $desembolsodafs = Desembolsodaf::all();

    $data = date_create(date('d-m-Y'));
    $dados = array();
    $year = $request->ano ?? $data->format('Y');
    
    // Para os cálculos financeiros, usar todos os projetos
    $todosProjectos = Projectoo::all();
    foreach ($todosProjectos as $key => $project) {
        $tEntradas = DB::table('desembolsos')->where('projecto_id', $project->id)->whereYear('created_at', '=', $year)->sum('valor');
        $tSaidas = DB::table('dispensas')->where('projecto_id', $project->id)->whereYear('created_at', '=', $year)->sum('valor');
        $tSaidas2 = DB::table('dispensas')->where('projecto_id', $project->id)->whereYear('created_at', '=', $year)->sum('valor_variavel');
        $saldo = $tEntradas - $tSaidas - $tSaidas2;
        $dados [] = [$project->acronimo, $saldo, $tSaidas, $tEntradas];
    }
    
    $Soma = DB::select('SELECT fontes.name, projectos.acronimo, SUM(valor) AS total
    FROM desembolsos
    INNER JOIN fontes ON desembolsos.administracao_id = fontes.id
    INNER JOIN projectos ON desembolsos.projecto_id = projectos.id
    where YEAR(desembolsos.created_at) = '.$year.'
    group by fontes.name, projectos.acronimo');
    
    $finSoma = collect($Soma);
    
    return view('home', compact(
        'participantes', 
        'fontes', 
        'projectoos',
        'finSoma', 
        'dados', 
        'distribuicaos', 
        'desembolsos', 
        'dispensas',
        'gestaos'
    ));
}
}
