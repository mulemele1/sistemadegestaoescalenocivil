<?php

namespace App\Console\Commands;

use App\Models\Projectoo;
use Illuminate\Console\Command;

class FixProjectImages extends Command
{
    protected $signature = 'fix:project-images';
    protected $description = 'Corrigir caminhos de imagens dos projetos';

    public function handle()
    {
        $projectos = Projectoo::all();
        
        foreach ($projectos as $projecto) {
            if (!empty($projecto->imagens)) {
                $imagensCorrigidas = [];
                
                // Se for string, converter para array
                if (is_string($projecto->imagens)) {
                    $imagensArray = json_decode($projecto->imagens, true) ?? [];
                } else {
                    $imagensArray = $projecto->imagens;
                }
                
                // Corrigir cada caminho
                foreach ($imagensArray as $imagem) {
                    if (is_string($imagem)) {
                        $caminhoCorrigido = $this->corrigirCaminho($imagem);
                        $imagensCorrigidas[] = $caminhoCorrigido;
                    }
                }
                
                // Atualizar no banco de dados
                $projecto->imagens = $imagensCorrigidas;
                $projecto->save();
                
                $this->info("Projeto {$projecto->id} corrigido: " . implode(', ', $imagensCorrigidas));
            }
        }
        
        $this->info('Todos os projetos foram corrigidos!');
        return 0;
    }
    
    private function corrigirCaminho($caminho)
    {
        // Remover caracteres especiais e corrigir barras
        $caminho = str_replace(['\\', 'V', '//'], '/', $caminho);
        $caminho = preg_replace('/[^a-zA-Z0-9\/._-]/', '', $caminho);
        
        // Garantir que comece com 'projectos/imagens/'
        if (strpos($caminho, 'projectos/imagens/') === false) {
            $caminho = 'projectos/imagens/' . basename($caminho);
        }
        
        return $caminho;
    }
}