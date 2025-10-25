<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProjectooRequest;
use App\Models\Projectoo;
use App\Models\Fonte;
use App\Models\Gestao;
use App\Models\Gerencia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectooController extends Controller
{
    public function list(Request $request) {
        $query = Projectoo::with(['categoria', 'localizacao', 'ano'])
            ->when($request->search, function($query, $search) {
                // Pesquisa em múltiplos campos
                return $query->where(function($q) use ($search) {
                    $q->where('nome', 'LIKE', "%{$search}%")
                      ->orWhere('tipografia', 'LIKE', "%{$search}%")
                      ->orWhere('estado', 'LIKE', "%{$search}%")
                      ->orWhereHas('categoria', function($q) use ($search) {
                          $q->where('name', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('localizacao', function($q) use ($search) {
                          $q->where('name', 'LIKE', "%{$search}%");
                      });
                });
            })
            ->when($request->estado, function($query, $estado) {
                return $query->where('estado', $estado);
            })
            ->when($request->categoria, function($query, $categoria) {
                return $query->where('categoria_id', $categoria);
            });

        // Paginação simples
        $projectoos = $query->paginate(10);

        $categorias = Gestao::all();

        return view('projectoos.list', compact('projectoos', 'categorias'));
    }




    

    public function show($id) {
    if (!$projectoo = Projectoo::with(['categoria', 'localizacao'])->find($id))
        return redirect()->route('projectoos.list')->with('error', 'Projeto não encontrado.');
    
    return view('projectoos.show', compact('projectoo'));
}


public function showuser($id)
{
    if (!$projectoo = Projectoo::with(['categoria', 'localizacao'])->find($id)) {
        return redirect()->route('home')->with('error', 'Projeto não encontrado.');
    }
    
    return view('projectoos.showuser', compact('projectoo'));
}

public function sobre()
{
    return view('projectoos.sobre');
}

public function contacto()
{
    return view('projectoos.contacto');
}

public function verprojectos()
{
    $projectoos = Projectoo::with(['categoria', 'localizacao'])->paginate(9);
    return view('projectoos.verprojectos', compact('projectoos'));
}

    public function create() {
        $fontes = Fonte::all(['id', 'name']);
        $gestaos = Gestao::all(['id', 'name']);
        $gerencias = Gerencia::all(['id', 'name']);
        return view('projectoos.create', compact('fontes', 'gestaos', 'gerencias'));
    }

    // ✅ MÉTODO debugData CORRIGIDO
    public function debugData() {
        try {
            $projectoos = Projectoo::with(['categoria', 'localizacao'])->get();
            
            $debugData = $projectoos->map(function($project) {
                // ✅ USANDO O ACCESSOR DO MODEL (sempre array)
                $imagensArray = $project->imagens;
                
                return [
                    'id' => $project->id,
                    'nome' => $project->nome,
                    'imagens_raw' => $project->getRawOriginal('imagens'), // Valor original do BD
                    'imagens_processed' => $imagensArray, // Valor após accessor
                    'imagens_type' => gettype($project->getRawOriginal('imagens')),
                    'imagens_count' => count($imagensArray),
                    'categoria' => $project->categoria ? $project->categoria->name : null,
                    'localizacao' => $project->localizacao ? $project->localizacao->name : null,
                    'has_images' => !empty($imagensArray),
                    'created_at' => $project->created_at
                ];
            });
            
            return response()->json([
                'success' => true,
                'total' => $projectoos->count(),
                'message' => 'Debug data - Model com cast array ativo',
                'data' => $debugData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro no debug'
            ], 500);
        }
    }

    public function checkImages($id = null)
    {
        if ($id) {
            // Verificar imagem específica
            $projecto = Projectoo::find($id);
            if (!$projecto) {
                return response()->json(['error' => 'Projeto não encontrado'], 404);
            }
            
            $imagensInfo = [];
            foreach ($projecto->imagens as $index => $imagem) {
                $caminhoCompleto = public_path('storage/' . $imagem);
                $imagensInfo[] = [
                    'caminho_bd' => $imagem,
                    'caminho_completo' => $caminhoCompleto,
                    'existe' => file_exists($caminhoCompleto),
                    'url' => asset('storage/' . $imagem)
                ];
            }
            
            return response()->json([
                'projecto_id' => $projecto->id,
                'projecto_nome' => $projecto->nome,
                'imagens' => $imagensInfo
            ]);
        }
        
        // Verificar todas as imagens
        $projectos = Projectoo::all();
        $resultado = [];
        
        foreach ($projectos as $projecto) {
            $imagensInfo = [];
            foreach ($projecto->imagens as $imagem) {
                $caminhoCompleto = public_path('storage/' . $imagem);
                $imagensInfo[] = [
                    'caminho' => $imagem,
                    'existe' => file_exists($caminhoCompleto)
                ];
            }
            
            $resultado[] = [
                'id' => $projecto->id,
                'nome' => $projecto->nome,
                'imagens' => $imagensInfo
            ];
        }
        
        return response()->json($resultado);
    }

    public function store(StoreUpdateProjectooRequest $request) {
        try {
            $data = $request->validated();
            
            if ($request->hasFile('imagens')) {
                $imagensPaths = [];
                
                foreach ($request->file('imagens') as $imagem) {
                    $nomeEspecial = time() . '_' . uniqid() . '.' . $imagem->getClientOriginalExtension();
                    $caminho = $imagem->storeAs('projectos/imagens', $nomeEspecial, 'public');
                    $imagensPaths[] = $caminho;
                }
                
                $data['imagens'] = $imagensPaths;
            }
            
            Projectoo::create($data);
            return redirect()->route('projectoos.list')->with('success', 'Projeto criado com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar projeto: ' . $e->getMessage());
        }
    }

    public function update(StoreUpdateProjectooRequest $request, $id) {
        try {
            if (!$projectoo = Projectoo::find($id))
                return redirect()->route('projectoos.list');
            
            $data = $request->validated();
            
            if ($request->hasFile('imagens')) {
                $imagensExistentes = $projectoo->imagens ?? [];
                
                foreach ($request->file('imagens') as $imagem) {
                    $nomeEspecial = time() . '_' . uniqid() . '.' . $imagem->getClientOriginalExtension();
                    $caminho = $imagem->storeAs('projectos/imagens', $nomeEspecial, 'public');
                    $imagensExistentes[] = $caminho;
                }
                
                $data['imagens'] = $imagensExistentes;
            }
            
            $projectoo->update($data);
            return redirect()->route('projectoos.list')->with('success', 'Projeto atualizado com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar projeto: ' . $e->getMessage());
        }
    }

    public function edit($id) {
        if (!$projectoo = Projectoo::find($id))
            return redirect()->route('projectoos.list');
        
        $fontes = Fonte::all(['id', 'name']);
        $gestaos = Gestao::all(['id', 'name']);
        $gerencias = Gerencia::all(['id', 'name']);
        
        return view('projectoos.edit', compact('projectoo', 'fontes', 'gestaos', 'gerencias'));
    }

    public function delete($id) {
        try {
            if (!$projectoo = Projectoo::find($id))
                return redirect()->route('projectoos.list');
            
            // ✅ USANDO O ACCESSOR (sempre array)
            if (!empty($projectoo->imagens)) {
                foreach ($projectoo->imagens as $imagem) {
                    Storage::disk('public')->delete($imagem);
                }
            }
            
            $projectoo->delete();
            return redirect()->route('projectoos.list')->with('success', 'Projeto eliminado com sucesso!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao eliminar projeto: ' . $e->getMessage());
        }
    }

    // Método para exportação CSV
    public function exportCSV()
    {
        $projectoos = Projectoo::with(['categoria', 'localizacao'])->get();
        
        $fileName = 'projectos_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($projectoos) {
            $file = fopen('php://output', 'w');
            
            // Cabeçalho
            fputcsv($file, [
                'ID', 'Nome', 'Tipografia', 'Categoria', 'Localização', 
                'Estado', 'Cor', 'Total de Imagens', 'Data de Criação'
            ], ';');
            
            // Dados
            foreach ($projectoos as $projecto) {
                fputcsv($file, [
                    $projecto->id,
                    $projecto->nome,
                    $projecto->tipografia ?? 'N/A',
                    $projecto->categoria->name ?? 'N/A',
                    $projecto->localizacao->name ?? 'N/A',
                    $projecto->estado,
                    $projecto->cor ?? 'N/A',
                    count($projecto->imagens ?? []),
                    $projecto->created_at->format('d/m/Y H:i')
                ], ';');
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}