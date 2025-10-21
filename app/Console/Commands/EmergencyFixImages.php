<?php

namespace App\Console\Commands;

use App\Models\Projectoo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EmergencyFixImages extends Command
{
    protected $signature = 'fix:images-emergency';
    protected $description = 'Solução emergencial para problemas de imagens';

    public function handle()
    {
        $this->info('=== INICIANDO CORREÇÃO EMERGENCIAL DE IMAGENS ===');
        
        // Listar todos os arquivos na pasta de imagens
        $arquivos = Storage::disk('public')->files('projectos/imagens');
        $this->info("Arquivos encontrados no storage: " . count($arquivos));
        foreach ($arquivos as $arquivo) {
            $this->info(" - " . $arquivo);
        }
        
        $projectos = Projectoo::all();
        
        foreach ($projectos as $projecto) {
            $this->info("\n--- Processando Projeto {$projecto->id}: {$projecto->nome} ---");
            
            // Resetar imagens baseado nos arquivos existentes
            $novasImagens = [];
            
            foreach ($arquivos as $arquivo) {
                if (str_contains($arquivo, '17699')) { // IDs das suas imagens
                    $novasImagens[] = $arquivo;
                }
            }
            
            if (!empty($novasImagens)) {
                $projecto->imagens = $novasImagens;
                $projecto->save();
                $this->info("✅ Imagens atualizadas: " . implode(', ', $novasImagens));
            } else {
                $this->warn("⚠️ Nenhuma imagem encontrada para este projeto");
            }
        }
        
        $this->info("\n=== CORREÇÃO CONCLUÍDA ===");
        return 0;
    }
}