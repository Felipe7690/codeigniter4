<?php

namespace App\Controllers;

use App\Models\Entregas as Entregas_model;
use App\Models\Vendas as Vendas_model;
use App\Models\Funcionarios as Funcionarios_model;

class Entregas extends BaseController
{
    private $entregaModel;
    private $vendaModel;
    private $funcionarioModel;

    public function __construct()
    {
        $this->entregaModel = new Entregas_model();
        $this->vendaModel = new Vendas_model();
        $this->funcionarioModel = new Funcionarios_model();
        helper('functions');
    }

    public function index()
    {
        $data = [
            'title'    => 'Gerenciamento de Entregas',
            'entregas' => $this->entregaModel->getEntregasComNomes(),
            'msg'      => session()->getFlashdata('msg')
        ];
        return view('entregas/index', $data);
    }

    public function new($venda_id = null)
    {
        $entrega = new \stdClass();
        if ($venda_id) {
            $entrega->entregas_vendas_id = $venda_id;
        }

        $data = [
            'title'        => 'Agendar Nova Entrega',
            'form'         => 'Agendar',
            'op'           => 'create',
            'entrega'      => $entrega,
            'vendas'       => $this->vendaModel->where('vendas_status', 'Realizada')->findAll(),
            'funcionarios' => $this->funcionarioModel->findComNomeUsuario()
        ];
        return view('entregas/form', $data);
    }
    
    public function create()
    {
        $funcionarioId = $this->request->getPost('entregas_funcionarios_id');

        $dados = [
            'entregas_vendas_id'       => $this->request->getPost('entregas_vendas_id'),
            'entregas_funcionarios_id' => !empty($funcionarioId) ? $funcionarioId : null,
            'entregas_data'            => $this->request->getPost('entregas_data'),
            'entregas_status'          => $this->request->getPost('entregas_status')
        ];

        if ($this->entregaModel->save($dados)) {
            return redirect()->to('/entregas')->with('msg', msg('Entrega agendada com sucesso!', 'success'));
        }
        return redirect()->back()->withInput()->with('errors', $this->entregaModel->errors());
    }

    public function edit($id = null)
    {
        $entrega = $this->entregaModel->find($id);
        if (!$entrega) {
            return redirect()->to('/entregas')->with('msg', msg('Entrega não encontrada!', 'danger'));
        }

        $data = [
            'title'        => 'Editar Entrega',
            'form'         => 'Alterar',
            'op'           => 'update/' . $id,
            'entrega'      => $entrega,
            'vendas'       => $this->vendaModel->findAll(),
            'funcionarios' => $this->funcionarioModel->findComNomeUsuario()
        ];
        return view('entregas/form', $data);
    }

    public function update($id = null)
    {
        $funcionarioId = $this->request->getPost('entregas_funcionarios_id');
        
        $dados = [
            'entregas_vendas_id'       => $this->request->getPost('entregas_vendas_id'),
            'entregas_funcionarios_id' => !empty($funcionarioId) ? $funcionarioId : null,
            'entregas_data'            => $this->request->getPost('entregas_data'),
            'entregas_status'          => $this->request->getPost('entregas_status')
        ];

        if ($this->entregaModel->update($id, $dados)) {
            return redirect()->to('/entregas')->with('msg', msg('Entrega atualizada com sucesso!', 'success'));
        }
        return redirect()->back()->withInput()->with('errors', $this->entregaModel->errors());
    }

    public function delete($id = null)
    {
        $this->entregaModel->delete($id);
        return redirect()->to('/entregas')->with('msg', msg('Entrega excluída com sucesso!', 'success'));
    }
}