<?php

namespace App\DataTables;

use App\Projeto;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;

class ProjetosDataTablesEditor extends DataTablesEditor
{
    protected $model = Projeto::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'pro_nome' => 'required'
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
            'pro_nome' => 'sometimes|required'
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
        if (empty($data['pro_nome'])) {
            unset($data['pro_nome']);
        }
        return $data;
    }
}
