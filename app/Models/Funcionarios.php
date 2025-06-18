<?php

namespace App\Models;

use CodeIgniter\Model;

class Funcionarios extends Model
{
    protected $table = 'funcionarios';
    protected $primaryKey = 'funcionarios_id';
    protected $allowedFields = [
        'funcionarios_usuarios_id',
        'funcionarios_cargo',
        'funcionarios_salario'
    ];
}
