<?php

namespace App\Controllers;

use App\Models\Pedidos as Pedidos_model;
use App\Models\Produtos as Produtos_model;
use App\Models\Vendas as Vendas_model;
use App\Models\Clientes as Clientes_model; // Model de Clientes adicionado

class Pedidos extends BaseController
{
    public function index()
    {
        $model = new Pedidos_model();
        $dados = [
            'title' => 'Pedidos',
            'pedidos' => $model->findAll(),
        ];

        return view('pedidos/index', $dados);
    }

    public function create()
{
    $produtosModel = new Produtos_model();
    $vendasModel = new Vendas_model();
    $clientesModel = new Clientes_model();

    $dados = [
        'title' => 'Cadastrar Pedido',
        'form' => 'Cadastrar',
        'op' => 'store',
        'produtos' => $produtosModel->findAll(),
        'vendas' => $vendasModel->findAll(),
        'clientes' => $clientesModel->findComNomeUsuario(),
        'pedidos' => new \stdClass(), // <-- ADICIONE ESTA LINHA
    ];

    return view('pedidos/form', $dados);
}

    public function edit($id)
    {
        $model = new Pedidos_model();
        $pedido = $model->find($id);

        if (!$pedido) {
            return redirect()->to('/pedidos')->with('msg', 'Pedido não encontrado.');
        }

        $produtosModel = new Produtos_model();
        $vendasModel = new Vendas_model();
        $clientesModel = new Clientes_model();

        $dados = [
            'title' => 'Editar Pedido',
            'form' => 'Editar',
            'op' => 'update/' . $id,
            'pedidos' => $pedido,
            'produtos' => $produtosModel->findAll(),
            'vendas' => $vendasModel->findAll(),
            'clientes' => $clientesModel->findComNomeUsuario(),
        ];

        return view('pedidos/form', $dados);
    }

    public function store()
    {
        // Usando transação para garantir a integridade dos dados
        $db = \Config\Database::connect();
        $db->transStart();

        $vendasModel = new Vendas_model();
        $pedidosModel = new Pedidos_model();

        $vendas_id = $this->request->getPost('pedidos_vendas_id');

        if ($vendas_id === 'nova') {
            $cliente_id_para_nova_venda = $this->request->getPost('clientes_id');

            if (empty($cliente_id_para_nova_venda)) {
                return redirect()->back()->withInput()->with('errors', ['cliente' => 'É necessário selecionar um cliente para a nova venda.']);
            }

            $novaVendaData = [
                'vendas_clientes_id' => $cliente_id_para_nova_venda,
                'vendas_data'        => date('Y-m-d H:i:s'),
                'vendas_valor_total' => 0, // Inicia com 0, conforme ajuste no DB
            ];

            $vendasModel->insert($novaVendaData);
            $vendas_id = $vendasModel->getInsertID();
        }

        $dataPedido = [
            'pedidos_vendas_id'      => $vendas_id,
            'pedidos_produtos_id'    => $this->request->getPost('produtos_id'),
            'pedidos_quantidade'     => $this->request->getPost('pedidos_quantidade'),
            'pedidos_preco_unitario' => $this->request->getPost('pedidos_preco_unitario'),
        ];

        $pedidosModel->save($dataPedido);
        
        $db->transComplete();

        if ($db->transStatus() === false) {
             return redirect()->back()->withInput()->with('errors', 'Ocorreu um erro ao salvar os dados.');
        }

        return redirect()->to('/pedidos')->with('msg', 'Pedido cadastrado com sucesso!');
    }

    public function update($id)
    {
        $pedidosModel = new Pedidos_model();

        $dataPedido = [
            'pedidos_id'             => $id,
            'pedidos_vendas_id'      => $this->request->getPost('pedidos_vendas_id'),
            'pedidos_produtos_id'    => $this->request->getPost('produtos_id'),
            'pedidos_quantidade'     => $this->request->getPost('pedidos_quantidade'),
            'pedidos_preco_unitario' => $this->request->getPost('pedidos_preco_unitario'),
        ];

        $pedidosModel->save($dataPedido);

        return redirect()->to('/pedidos')->with('msg', 'Pedido atualizado com sucesso!');
    }

    public function delete($id)
    {
        $pedidosModel = new Pedidos_model();
        $pedidosModel->delete($id);
        return redirect()->to('/pedidos')->with('msg', 'Pedido excluído com sucesso!');
    }
}