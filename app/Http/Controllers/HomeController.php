<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projectoo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Buscar todos os projectos com suas relações
        $query = Projectoo::with(['categoria', 'localizacao']);
        
        // Adicionar pesquisa se existir
        if ($request->has('search') && $request->search != '') {
            $query->where('nome', 'like', '%' . $request->search . '%')
                  ->orWhere('descricao', 'like', '%' . $request->search . '%')
                  ->orWhere('estado', 'like', '%' . $request->search . '%');
        }
        
        // Paginação com 10 itens por página
        $projectoos = $query->paginate(10);
        
        return view('home', compact('projectoos'));
    }
}