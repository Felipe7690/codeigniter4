<?php

namespace App\Controllers;

use App\Models\Pedidos;
use App\Models\Clientes;

class PedidosCliente extends BaseController
{
    public function index()
    {
        $loginSession = session()->get('login');
        $usuario_id = $loginSession->usuarios_id ?? null;
    
        if (!$usuario_id) {
            return view('ViewsCliente/pedidos/index', [
                'title' => 'Meus Pedidos',
                'pedidos' => [],
                'msg' => 'Você precisa estar logado para ver seus pedidos.'
            ]);
        }
    
        $model = new \App\Models\Pedidos();
    
        $pedidos = $model
            ->select('pedidos.*, vendas.vendas_clientes_id, vendas.vendas_data, vendas.vendas_status, produtos.produtos_nome')
            ->join('produtos', 'produtos.produtos_id = pedidos.pedidos_produtos_id')
            ->join('vendas', 'vendas.vendas_id = pedidos.pedidos_vendas_id')
            ->where('clientes.clientes_usuarios_id', $usuario_id)
            ->join('clientes', 'clientes.clientes_id = vendas.vendas_clientes_id')
            ->findAll();
    
    
        $msg = empty($pedidos) ? 'Nenhum pedido encontrado.' : '';
    
        return view('ViewsCliente/pedidos/index', [
            'title' => 'Meus Pedidos',
            'pedidos' => $pedidos,
            'msg' => $msg
        ]);
    }

    public function comprar()
    {
        $loginSession = session()->get('login');
        $usuario_id = $loginSession->usuarios_id ?? null;
    
        if (!$usuario_id) {
            return redirect()->to(base_url('login'))->with('msg', 'Você precisa estar logado para comprar.');
        }
    
        $produto_id = $this->request->getPost('produto_id');
        $quantidade = (int) $this->request->getPost('quantidade');
    
        if (!$produto_id || $quantidade <= 0) {
            return redirect()->back()->with('msg', 'Quantidade inválida ou produto não informado.');
        }
    
        $clientesModel = new Clientes();
        $vendasModel = new \App\Models\Vendas();
        $pedidosModel = new Pedidos();
        $produtosModel = new \App\Models\Produtos();
    
        $cliente = $clientesModel->where('clientes_usuarios_id', $usuario_id)->first();
        if (!$cliente) {
            return redirect()->back()->with('msg', 'Cliente não encontrado.');
        }
    
        $vendasModel->insert([
            'vendas_clientes_id' => $cliente->clientes_id,
            'vendas_data' => date('Y-m-d H:i:s'),
            'vendas_status' => 'Aberta',
            'vendas_total' => 0
        ]);
        $venda_id = $vendasModel->getInsertID();
    
        $produto = $produtosModel->find($produto_id);
        if (!$produto) {
            return redirect()->back()->with('msg', 'Produto não encontrado.');
        }
    
        $pedidosModel->insert([
            'pedidos_vendas_id' => $venda_id,
            'pedidos_produtos_id' => $produto_id,
            'pedidos_quantidade' => $quantidade,
            'pedidos_preco_unitario' => $produto->produtos_preco_venda
        ]);
    
        $vendasModel->recalculateVendaTotal($venda_id);
    
        return redirect()->back()->with('msg', "Produto '{$produto->produtos_nome}' adicionado ao carrinho.");
    }
    
    
    
}
