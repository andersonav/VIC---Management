<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table = 'projeto';

    protected $primaryKey = "pro_id";

    protected $guarded = [];
}
