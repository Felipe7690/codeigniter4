<?php

namespace App\Models;

use CodeIgniter\Model;

class Funcionarios extends Model
{
    protected $table = 'funcionarios';
    protected $primaryKey = 'funcionarios_id';
    protected $returnType = 'object';

    protected $allowedFields = [
        'funcionarios_usuarios_id', 
        'funcionarios_cargo', 
        'funcionarios_salario'
    ];

    public function findComNomeUsuario()
    {
        return $this->select('funcionarios.funcionarios_id, usuarios.usuarios_nome')
                    ->join('usuarios', 'usuarios.usuarios_id = funcionarios.funcionarios_usuarios_id')
                    ->findAll();
    }
}