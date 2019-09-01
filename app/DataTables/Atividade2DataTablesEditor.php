<?php

namespace App\DataTables;

use App\Atividade2;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;

class Atividade2DataTablesEditor extends DataTablesEditor
{
    protected $model = Atividade2::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'ati1_id' => 'sometimes|required|',
            'ati2_codigo' => 'sometimes|required',
            'ati2_descricao' => 'sometimes|required',
            'ati2_preco_unidade' => 'sometimes|required|numeric|between:0,999999.99',
            'ati2_quantidade' => 'sometimes|required|numeric',
            'ati2_faturado' => 'sometimes|required|numeric',
            'uni_id' => 'sometimes|required',
        ];
    }

    /**
     * Get edit action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function editRules(Model $model)
    {
        return [
            'ati1_id' => 'sometimes|required',
            'ati2_codigo' => 'sometimes|required',
            'ati2_descricao' => 'sometimes|required',
            'ati2_preco_unidade' => 'sometimes|required|numeric|between:0,999999.99',
            'ati2_quantidade' => 'sometimes|required|numeric',
            'ati2_faturado' => 'sometimes|required|numeric',
            'uni_id' => 'sometimes|required',
        ];
    }

    /**
     * Get remove action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function removeRules(Model $model)
    {
        return [];
    }

    public function creating(Model $model, array $data)
    {
        return $data;
    }

    public function updating(Model $model, array $data)
    {
        if (empty($data['ati2_codigo'])) {
            unset($data['ati2_codigo']);
        } elseif (empty($data['ati1_id'])) {
            unset($data['ati1_id']);
        } elseif (empty($data['ati2_descricao'])) {
            unset($data['ati2_descricao']);
        } elseif (empty($data['ati2_preco_unidade'])) {
            unset($data['ati2_preco_unidade']);
        } elseif (empty($data['ati2_quantidade'])) {
            unset($data['ati2_quantidade']);
        } elseif (empty($data['ati2_faturado'])) {
            unset($data['ati2_faturado']);
        } elseif (empty($data['uni_id'])) {
            unset($data['uni_id']);
        }

        return $data;
    }
}
