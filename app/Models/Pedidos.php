<?php

namespace App\Models;

use CodeIgniter\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'pedidos_id';
    protected $returnType = 'object';
    protected $useAutoIncrement = true;
    protected $protectFields = true;

    protected $allowedFields = [
        'pedidos_vendas_id',
        'pedidos_produtos_id',
        'pedidos_quantidade',
        'pedidos_preco_unitario',
    ];


    public function getPedidosComNomes()
    {
        return $this->select('
                        pedidos.*, 
                        produtos.produtos_nome, 
                        usuarios.usuarios_nome AS cliente_nome
                    ')
                 ->join('produtos', 'produtos.produtos_id = pedidos.pedidos_produtos_id')
                 ->join('vendas', 'vendas.vendas_id = pedidos.pedidos_vendas_id')
                 ->join('clientes', 'clientes.clientes_id = vendas.vendas_clientes_id')
                 ->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id')
                 ->orderBy('pedidos.pedidos_id', 'DESC')
                 ->findAll();
    }
}