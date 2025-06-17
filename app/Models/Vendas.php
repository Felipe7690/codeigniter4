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

    public function getVendasComCliente()
{
    return $this->select('
                        vendas.vendas_id, 
                        vendas.vendas_data, 
                        vendas.vendas_total, 
                        vendas.vendas_status, 
                        usuarios.usuarios_nome AS cliente_nome
                    ')
                 ->join('clientes', 'clientes.clientes_id = vendas.vendas_clientes_id')
                 ->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id')
                 ->orderBy('vendas.vendas_data', 'DESC')
                 ->findAll();
}

    // CORREÇÃO: Alterado de 'array' para 'object'
    protected $returnType = 'object';

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