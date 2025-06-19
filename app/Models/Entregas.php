<?php

namespace App\Models;

use CodeIgniter\Model;

class Entregas extends Model
{
    protected $table            = 'entregas';
    protected $primaryKey       = 'entregas_id';
    protected $returnType       = 'object';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'entregas_vendas_id',
        'entregas_funcionarios_id',
        'entregas_data',
        'entregas_status'
    ];

    public function getEntregasComNomes()
    {
        return $this->select('
                        entregas.*, 
                        vendas.vendas_id,
                        cliente.usuarios_nome AS cliente_nome,
                        entregador.usuarios_nome AS funcionario_nome
                    ')
                 ->join('vendas', 'vendas.vendas_id = entregas.entregas_vendas_id')
                 ->join('clientes', 'clientes.clientes_id = vendas.vendas_clientes_id')
                 ->join('usuarios AS cliente', 'cliente.usuarios_id = clientes.clientes_usuarios_id')
                 ->join('funcionarios', 'funcionarios.funcionarios_id = entregas.entregas_funcionarios_id', 'left')
                 ->join('usuarios AS entregador', 'entregador.usuarios_id = funcionarios.funcionarios_usuarios_id', 'left') 
                 ->orderBy('entregas.entregas_data', 'DESC')
                 ->findAll();
    }
}