<?php

namespace App\Models;

use CodeIgniter\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'clientes_id';

    protected $returnType = 'object';

    protected $allowedFields = [
        'clientes_usuarios_id',
        'clientes_endereco',
        'clientes_cidade_id',
    ];

    public function findComNomeUsuario()
    {
        return $this->select('clientes.clientes_id, usuarios.usuarios_nome')
                    ->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id')
                    ->findAll();
    }
}