<?php

namespace App\Controllers;

use App\Models\Vendas as Vendas_model;
use App\Models\Clientes as Clientes_model;
use App\Models\Funcionarios as Funcionarios_model;

class Venda extends BaseController
{
    private $vendasModel;
    private $clientesModel;
    private $funcionariosModel;

    public function __construct()
    {
        $this->vendasModel = new Vendas_model();
        $this->clientesModel = new Clientes_model();
        $this->funcionariosModel = new Funcionarios_model();
        helper('functions');
    }

    public function index()
    {
        $data = [
            'title'  => 'Lista de Vendas',
            'vendas' => $this->vendasModel->getVendasComCliente(),
            'msg'    => session()->getFlashdata('msg')
        ];
        return view('vendas/index', $data);
    }

    public function edit($id = null)
    {
        $venda = $this->vendasModel->find($id);
        if (!$venda) {
            return redirect()->to('/vendas')->with('msg', msg('Venda não encontrada', 'danger'));
        }
        
        $data = [
            'title'        => 'Editar Venda',
            'venda'        => $venda,
            'clientes'     => $this->clientesModel->findComNomeUsuario(),
            'funcionarios' => $this->funcionariosModel->findComNomeUsuario()
        ];
        return view('vendas/form', $data);
    }

    public function update($id = null)
    {
        // Pega o ID do funcionário do formulário
        $funcionarioId = $this->request->getPost('vendas_funcionarios_id');

        $dados = [
            'vendas_clientes_id'       => $this->request->getPost('vendas_clientes_id'),
            // AQUI ESTÁ A CORREÇÃO:
            // Se o ID do funcionário não estiver vazio, usa o ID. Senão, usa null.
            'vendas_funcionarios_id'   => !empty($funcionarioId) ? $funcionarioId : null,
            'vendas_data'              => $this->request->getPost('vendas_data'),
            'vendas_status'            => $this->request->getPost('vendas_status'),
        ];

        if ($this->vendasModel->update($id, $dados)) {
            session()->setFlashdata('msg', msg('Venda atualizada com sucesso!', 'success'));
        } else {
            session()->setFlashdata('msg', msg('Erro ao atualizar venda.', 'danger'));
        }
        return redirect()->to('/vendas');
    }

    public function delete($id = null)
    {
        if ($this->vendasModel->delete($id)) {
            session()->setFlashdata('msg', msg('Venda excluída com sucesso!', 'success'));
        } else {
            session()->setFlashdata('msg', msg('Erro ao excluir venda.', 'danger'));
        }
        return redirect()->to('/vendas');
    }

    public function marcarRealizada($id = null)
    {
        $dados = ['vendas_status' => 'Realizada'];
        if ($this->vendasModel->update($id, $dados)) {
            session()->setFlashdata('msg', msg('Venda marcada como Realizada!', 'success'));
        } else {
            session()->setFlashdata('msg', msg('Erro ao atualizar status da venda.', 'danger'));
        }
        return redirect()->to('/vendas');
    }
}