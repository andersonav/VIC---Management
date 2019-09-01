<?php

namespace App\DataTables;

use App\Lote;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;

class LotesDataTablesEditor extends DataTablesEditor
{
    protected $model = Lote::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'pro_id' => 'required',
            'lot_nome' => 'required'
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
            'pro_id' => 'sometimes|required',
            'lot_nome' => 'sometimes|required'
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
        if (empty($data['lot_nome'])) {
            unset($data['lot_nome']);
        } elseif (empty($data['pro_id'])) {
            unset($data['pro_id']);
        }
        return $data;
    }
}
