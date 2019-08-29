<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lote';

    protected $primaryKey = "lot_id";

    protected $guarded = [];
}
