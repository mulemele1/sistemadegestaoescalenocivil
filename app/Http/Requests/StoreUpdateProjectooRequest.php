<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProjectooRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'nome' => 'required|string|max:255',
            'tipografia' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'nome_cliente' => 'required|string|max:255',
            'cor' => 'nullable|string|max:50',
            'categoria_id' => 'required|exists:fontes,id',
            'localizacao_id' => 'required|exists:gestaos,id',
            'ano_id' => 'required|exists:gerencias,id',
            'estado' => 'required|in:CONCLUIDO,EM_CURSO',
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // ✅ ADICIONAR VALIDAÇÃO POR IMAGEM
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome_cliente.required' => 'O campo nome do cliente é obrigatório.',
            'categoria_id.required' => 'O campo categoria é obrigatório.',
            'categoria_id.exists' => 'A categoria selecionada é inválida.',
            'localizacao_id.required' => 'O campo localização é obrigatório.',
            'localizacao_id.exists' => 'A localização selecionada é inválida.',
            'ano_id.required' => 'O campo ano é obrigatório.',
            'ano_id.exists' => 'O ano selecionado é inválido.',
            'estado.required' => 'O campo estado é obrigatório.',
            'estado.in' => 'O estado deve ser CONCLUIDO ou EM_CURSO.',
            'imagens.array' => 'O campo imagens deve ser um array.',
            'imagens.*.image' => 'Cada arquivo deve ser uma imagem.',
            'imagens.*.mimes' => 'As imagens devem ser dos tipos: jpeg, png, jpg, gif, webp.',
            'imagens.*.max' => 'Cada imagem não pode ser maior que 5MB.',
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'nome',
            'tipografia' => 'tipografia',
            'area' => 'área',
            'nome_cliente' => 'nome do cliente',
            'cor' => 'cor',
            'imagens' => 'imagens',
            'categoria_id' => 'categoria',
            'localizacao_id' => 'localização',
            'ano_id' => 'ano',
            'estado' => 'estado',
        ];
    }
}