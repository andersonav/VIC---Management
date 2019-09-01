<?php

namespace App\DataTables;

use App\Atividade1;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;

class Atividade1DataTablesEditor extends DataTablesEditor
{
    protected $model = Atividade1::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'lot_id' => 'required',
            'at1_nome' => 'required',
            'ati1_codigo' => 'required'
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
            'lot_id' => 'required',
            'at1_nome' => 'sometimes|required',
            'ati1_codigo' => 'required'
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
        if (empty($data['at1_nome'])) {
            unset($data['at1_nome']);
        } elseif (empty($data['lot_id'])) {
            unset($data['lot_id']);
        } elseif (empty($data['ati1_codigo'])) {
            unset($data['ati1_codigo']);
        }
        return $data;
    }
}
