<?php

namespace App\Controllers;

use App\Models\Pedidos as Pedidos_model;
use App\Models\Produtos as Produtos_model;
use App\Models\Vendas as Vendas_model;
use App\Models\Clientes as Clientes_model;

class Pedidos extends BaseController
{
    private $pedidosModel;
    private $produtosModel;
    private $vendasModel;
    private $clientesModel;

    public function __construct()
    {
        $this->pedidosModel = new Pedidos_model();
        $this->produtosModel = new Produtos_model();
        $this->vendasModel = new Vendas_model();
        $this->clientesModel = new Clientes_model();
        helper('functions');
    }
    
    public function index()
    {
        $data = [
            'title'   => 'Pedidos',
            'pedidos' => $this->pedidosModel->getPedidosComNomes(),
            'msg'     => session()->getFlashdata('msg')
        ];
        return view('pedidos/index', $data);
    }
    
    public function new()
    {
        $data = [
            'title'    => 'Cadastrar Pedido',
            'form'     => 'Cadastrar',
            'op'       => 'create',
            'pedidos'  => new \stdClass(),
            'produtos' => $this->produtosModel->findAll(),
            'vendas'   => $this->vendasModel->findAll(),
            'clientes' => $this->clientesModel->findComNomeUsuario(),
        ];
        return view('pedidos/form', $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $vendas_id = $this->request->getPost('pedidos_vendas_id');

        if ($vendas_id === 'nova') {
            $cliente_id_para_nova_venda = $this->request->getPost('clientes_id');
            if (empty($cliente_id_para_nova_venda)) {
                return redirect()->back()->withInput()->with('errors', ['cliente' => 'É necessário selecionar um cliente para a nova venda.']);
            }
            $novaVendaData = [
                'vendas_clientes_id' => $cliente_id_para_nova_venda,
                'vendas_data'        => date('Y-m-d H:i:s'),
                'vendas_total'       => 0,
            ];
            $this->vendasModel->insert($novaVendaData);
            $vendas_id = $this->vendasModel->getInsertID();
        }

        $dataPedido = [
            'pedidos_vendas_id'      => $vendas_id,
            'pedidos_produtos_id'    => $this->request->getPost('produtos_id'),
            'pedidos_quantidade'     => $this->request->getPost('pedidos_quantidade'),
            'pedidos_preco_unitario' => $this->request->getPost('pedidos_preco_unitario'),
        ];
        $this->pedidosModel->save($dataPedido);
        
        $this->vendasModel->recalculateVendaTotal($vendas_id);

        $db->transComplete();

        if ($db->transStatus() === false) {
             return redirect()->back()->withInput()->with('errors', 'Ocorreu um erro ao salvar os dados.');
        }

        return redirect()->to('/pedidos')->with('msg', msg('Pedido cadastrado com sucesso!', 'success'));
    }

    public function edit($id = null)
    {
        $pedido = $this->pedidosModel->find($id);
        if (!$pedido) {
            return redirect()->to('/pedidos')->with('msg', msg('Pedido não encontrado!', 'danger'));
        }
        $data = [
            'title'    => 'Editar Pedido',
            'form'     => 'Alterar',
            'op'       => 'update/' . $pedido->pedidos_id,
            'pedidos'  => $pedido,
            'vendas'   => $this->vendasModel->findAll(),
            'produtos' => $this->produtosModel->findAll(),
            'clientes' => $this->clientesModel->findComNomeUsuario()
        ];
        return view('pedidos/form', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate([
            'pedidos_vendas_id'    => 'required',
            'produtos_id'          => 'required|integer',
            'pedidos_quantidade'   => 'required|integer',
            'pedidos_preco_unitario' => 'required|decimal'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'pedidos_vendas_id'      => $this->request->getPost('pedidos_vendas_id'),
            'pedidos_produtos_id'    => $this->request->getPost('produtos_id'),
            'pedidos_quantidade'     => $this->request->getPost('pedidos_quantidade'),
            'pedidos_preco_unitario' => $this->request->getPost('pedidos_preco_unitario'),
        ];
        
        if ($this->pedidosModel->update($id, $dados)) {
            $venda_id = $this->request->getPost('pedidos_vendas_id');
            $this->vendasModel->recalculateVendaTotal($venda_id);
            session()->setFlashdata('msg', msg('Pedido atualizado com sucesso!', 'success'));
        } else {
            session()->setFlashdata('msg', msg('Erro ao atualizar o pedido.', 'danger'));
        }
        
        return redirect()->to('/pedidos');
    }

    public function delete($id = null)
    {
        $pedido = $this->pedidosModel->find($id);
        if (!$pedido) {
            return redirect()->to('/pedidos')->with('msg', msg('Pedido não encontrado!', 'danger'));
        }

        $venda_id = $pedido->pedidos_vendas_id;

        if ($this->pedidosModel->delete($id)) {
            $this->vendasModel->recalculateVendaTotal($venda_id);
            session()->setFlashdata('msg', msg('Pedido excluído com sucesso!', 'success'));
        } else {
            session()->setFlashdata('msg', msg('Erro ao excluir o pedido.', 'danger'));
        }
        return redirect()->to('/pedidos');
    }
}