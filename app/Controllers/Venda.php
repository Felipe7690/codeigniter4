<?php

namespace App\Controllers;

use App\Models\Vendas as Vendas_model;
// Adicione os outros models que podem ser necessários
use App\Models\Clientes as Clientes_model;

class Venda extends BaseController // Mudado para BaseController, mais adequado para web
{
    private $vendasModel;
    private $clientesModel;

    public function __construct()
    {
        $this->vendasModel = new Vendas_model();
        $this->clientesModel = new Clientes_model();
        helper('functions');
    }

    // Lista todas as vendas
    public function index()
    {
        $data = [
            'title'  => 'Lista de Vendas',
            'vendas' => $this->vendasModel->getVendasComCliente(), // Usa a função do Model
            'msg'    => session()->getFlashdata('msg')
        ];

        return view('vendas/index', $data);
    }

    // Exibe o formulário para editar uma venda
    public function edit($id = null)
    {
        $venda = $this->vendasModel->find($id);

        if (!$venda) {
            return redirect()->to('/venda')->with('msg', msg('Venda não encontrada', 'danger'));
        }
        
        $data = [
            'title'    => 'Editar Venda',
            'venda'    => $venda,
            'clientes' => $this->clientesModel->findComNomeUsuario() // Busca todos os clientes para o select
        ];

        return view('vendas/edit', $data);
    }

    // Atualiza uma venda existente
    public function update($id = null)
    {
        $dados = [
            'vendas_clientes_id' => $this->request->getPost('vendas_clientes_id'),
            'vendas_data'        => $this->request->getPost('vendas_data'),
            'vendas_status'      => $this->request->getPost('vendas_status'),
            // Usando o nome correto da coluna: vendas_total
            'vendas_total'       => $this->request->getPost('vendas_total'),
        ];

        if ($this->vendasModel->update($id, $dados)) {
            session()->setFlashdata('msg', msg('Venda atualizada com sucesso!', 'success'));
        } else {
            session()->setFlashdata('msg', msg('Erro ao atualizar venda.', 'danger'));
        }

        return redirect()->to('/venda');
    }

    // Deleta uma venda
    public function delete($id = null)
    {
        if ($this->vendasModel->delete($id)) {
            session()->setFlashdata('msg', msg('Venda excluída com sucesso!', 'success'));
        } else {
            session()->setFlashdata('msg', msg('Erro ao excluir venda.', 'danger'));
        }
        return redirect()->to('/venda');
    }
}