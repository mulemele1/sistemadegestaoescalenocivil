<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectoo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'tipografia', 'area', 'nome_cliente', 'cor',
        'categoria_id', 'localizacao_id', 'ano_id', 'estado', 'imagens'
    ];

    protected $casts = [
        'imagens' => 'array'
    ];

    // ✅ ACCESSOR SUPER SIMPLIFICADO - SÓ RETORNA O QUE EXISTE
    public function getImagensAttribute($value)
    {
        if (empty($value)) {
            return [];
        }
        
        $imagensArray = [];
        
        // Se for string, tentar decodificar JSON
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            $imagensArray = is_array($decoded) ? $decoded : [];
        } 
        // Se for array, usar diretamente
        elseif (is_array($value)) {
            $imagensArray = $value;
        }
        
        // ✅ FILTRAR APENAS IMAGENS QUE EXISTEM FISICAMENTE
        $imagensExistentes = [];
        foreach ($imagensArray as $imagem) {
            if (!empty($imagem) && is_string($imagem)) {
                // Limpar o caminho
                $imagemLimpa = $this->limparCaminho($imagem);
                
                // Verificar se o arquivo existe
                $caminhoStorage = storage_path('app/public/' . $imagemLimpa);
                $caminhoPublic = public_path('storage/' . $imagemLimpa);
                
                if (file_exists($caminhoStorage) || file_exists($caminhoPublic)) {
                    $imagensExistentes[] = $imagemLimpa;
                }
            }
        }
        
        return $imagensExistentes;
    }

    private function limparCaminho($caminho)
    {
        // Remover todos os caracteres problemáticos
        $caminho = str_replace(['\\', 'V', '//', '"', '[', ']', '{', '}'], '/', $caminho);
        
        // Extrair apenas projectos/imagens/nome_arquivo
        if (preg_match('/(projectos\/imagens\/[a-zA-Z0-9_.-]+)/', $caminho, $matches)) {
            return $matches[1];
        }
        
        // Se não encontrar o padrão, tentar extrair apenas o nome do arquivo
        if (preg_match('/(17699[0-9]+_[a-zA-Z0-9]+\.jpg)/', $caminho, $matches)) {
            return 'projectos/imagens/' . $matches[1];
        }
        
        return $caminho;
    }

    public function categoria() {
        return $this->belongsTo(Fonte::class, 'categoria_id');
    }

    public function localizacao() {
        return $this->belongsTo(Gestao::class, 'localizacao_id');
    }

    public function ano() {
        return $this->belongsTo(Gerencia::class, 'ano_id');
    }
}