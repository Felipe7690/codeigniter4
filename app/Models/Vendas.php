<?php

namespace App\Models;

use CodeIgniter\Model;

class Vendas extends Model
{
    protected $table = 'vendas';
    protected $primaryKey = 'vendas_id';

    protected $allowedFields = [
        'vendas_clientes_id',
        'vendas_funcionarios_id',
        'vendas_data',
        'vendas_total',
        'vendas_status'
    ];

    protected $returnType = 'array';

    // Se quiser timestamps automáticos (created_at, updated_at), descomente e ajuste os nomes:
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at'; // nome do campo no banco
    // protected $updatedField  = 'updated_at'; // nome do campo no banco

    // Se quiser regras de validação, defina aqui (opcional):
    // protected $validationRules = [
    //     'vendas_clientes_id' => 'required|integer',
    //     'vendas_data'        => 'required|valid_date',
    //     'vendas_total'       => 'required|decimal',
    //     // outras regras
    // ];

    // protected $validationMessages = [];
}
