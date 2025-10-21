<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProjectooRequest;
use App\Models\Projectoo;
use App\Models\Fonte;
use App\Models\Gestao;
use App\Models\Gerencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectooController extends Controller
{
    public function list(Request $request) {
        $projectoos = Projectoo::with(['categoria', 'localizacao', 'ano'])
            ->when($request->search, function($query, $search) {
                return $query->where('nome', 'LIKE', "%{$search}%");
            })
            ->get();

        return view('projectoos.list', compact('projectoos'));
    }

    public function show($id) {
        if (!$projectoo = Projectoo::find($id))
            return redirect()->route('projectoos.list');
        return view('projectoos.show', compact('projectoo'));
    }

    public function create() {
        $fontes = Fonte::all(['id', 'name']);
        $gestaos = Gestao::all(['id', 'name']);
        $gerencias = Gerencia::all(['id', 'name']);
        return view('projectoos.create', compact('fontes', 'gestaos', 'gerencias'));
    }

    // ✅ MÉTODO testStorage CORRIGIDO
    public function testStorage() {
        try {
            $testPath = 'projectos/imagens/test_' . time() . '.txt';
            $result = Storage::disk('public')->put($testPath, 'Teste de storage funcionando!');
            
            $exists = Storage::disk('public')->exists($testPath);
            $url = Storage::url($testPath);
            $fullPath = storage_path('app/public/' . $testPath);
            $publicPath = public_path('storage/' . $testPath);
            
            return response()->json([
                'success' => true,
                'write_result' => $result,
                'exists' => $exists,
                'url' => $url,
                'full_path' => $fullPath,
                'public_path' => $publicPath,
                'message' => 'Teste de storage realizado com sucesso!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro no teste de storage'
            ], 500);
        }
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


    // No ProjectooController, adicione este método:
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



// No ProjectooController, adicione este método:
public function diagnostic()
{
    $projectos = Projectoo::all();
    $diagnostico = [];
    
    foreach ($projectos as $projecto) {
        $info = [
            'id' => $projecto->id,
            'nome' => $projecto->nome,
            'imagens_raw' => $projecto->getRawOriginal('imagens'),
            'imagens_processed' => $projecto->imagens,
            'storage_path' => storage_path('app/public'),
            'public_path' => public_path('storage'),
        ];
        
        // Verificar cada imagem
        $imagensInfo = [];
        foreach ($projecto->imagens as $index => $imagem) {
            $storagePath = storage_path('app/public/' . $imagem);
            $publicPath = public_path('storage/' . $imagem);
            
            $imagensInfo[] = [
                'imagem' => $imagem,
                'storage_exists' => file_exists($storagePath),
                'public_exists' => file_exists($publicPath),
                'storage_path' => $storagePath,
                'public_path' => $publicPath,
                'url' => asset('storage/' . $imagem),
            ];
        }
        
        $info['imagens_detalhes'] = $imagensInfo;
        $diagnostico[] = $info;
    }
    
    return response()->json($diagnostico);
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
}