<?php

namespace App\Models;

use CodeIgniter\Model;

class Estoques extends Model
{
    protected $table = 'estoques';
    protected $primaryKey = 'estoques_id';
    protected $allowedFields = [
        'estoques_produtos_id',
        'estoques_quantidade'
    ];
}
    