<?php

namespace App\Models;

use CodeIgniter\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'pedidos_id';

    protected $allowedFields = [
        'pedidos_vendas_id',
        'pedidos_produtos_id',
        'pedidos_quantidade',
        'pedidos_preco_unitario',
    ];

    protected $useTimestamps = false;

    protected $returnType = 'object'; // <-- aqui para retornar objetos

    // Se quiser validações ou regras adicionais, pode colocar aqui
}

