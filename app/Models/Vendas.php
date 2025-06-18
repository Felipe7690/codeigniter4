<?php

namespace App\Models;

use CodeIgniter\Model;

class Vendas extends Model
{
    protected $table = 'vendas';
    protected $primaryKey = 'vendas_id';
    protected $returnType = 'object';

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
    
    /**
     * Recalcula o valor total de uma venda com base na soma de seus pedidos.
     * @param int $venda_id O ID da venda a ser recalculada.
     */
    public function recalculateVendaTotal(int $venda_id)
    {
        $pedidos = db_connect()->table('pedidos')
                               ->where('pedidos_vendas_id', $venda_id)
                               ->get()
                               ->getResult();
        
        $total = 0;
        foreach ($pedidos as $pedido) {
            $total += $pedido->pedidos_quantidade * $pedido->pedidos_preco_unitario;
        }

        $this->update($venda_id, ['vendas_total' => $total]);
    }
}