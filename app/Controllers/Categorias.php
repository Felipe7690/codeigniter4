<?php

namespace App\Controllers;
use App\Models\Categorias as Categorias_model;

class Categorias extends BaseController
{   
    private $categorias; 
    
    public function __construct(){
        $this->categorias = new Categorias_model();
        helper('functions');
    }

    public function index(): string
    {
        $session = session();
        $data['title'] = 'Categorias';
        $data['categorias'] = $this->categorias->findAll();
        $data['msg'] = $session->getFlashdata('msg'); 
        return view('categorias/index',$data);
    }

    public function new(): string
    {
        $data['title'] = 'Cadastrar Categoria';
        $data['form'] = 'cadastrar';
        $data['op'] = 'create';
        $data['categorias'] = new \stdClass();
        return view('categorias/form',$data);
    }
    
    public function create()
    {
        $session = session();

        // Regras de validação
        if(!$this->validate(['categorias_nome' => 'required|max_length[255]|min_length[3]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'categorias_nome' => $this->request->getPost('categorias_nome')
        ];

        $this->categorias->save($dados);
        
        $session->setFlashdata('msg', msg('Cadastrado com Sucesso!', 'success'));
        return redirect()->to('/categorias');
    }

    public function delete($id)
    {
        $session = session();
        if ($this->categorias->delete($id)) {
            $session->setFlashdata('msg', msg('Deletado com Sucesso!', 'success'));
        } else {
            $session->setFlashdata('msg', msg('Erro ao deletar!', 'danger'));
        }
        return redirect()->to('/categorias');
    }

    public function edit($id)
    {
        $categoria = $this->categorias->find($id);

        if (!$categoria) {
            return redirect()->to('/categorias')->with('msg', msg('Categoria não encontrada!', 'danger'));
        }

        $data['categorias'] = $categoria;
        $data['title'] = 'Editar Categoria';
        $data['form'] = 'Alterar';
        $data['op'] = 'update/' . $id;
        return view('categorias/form', $data);
    }

    public function update($id)
    {
        $session = session();

        $dados = [
            'categorias_nome' => $this->request->getPost('categorias_nome')
        ];

        if ($this->categorias->update($id, $dados)) {
            $session->setFlashdata('msg', msg('Alterado com Sucesso!', 'success'));
        } else {
            $session->setFlashdata('msg', msg('Erro ao alterar!', 'danger'));
        }
        return redirect()->to('/categorias');
    }

    public function search()
    {
        $termo = $this->request->getPost('pesquisar');
        $data['categorias'] = $this->categorias->like('categorias_nome', $termo)->findAll();
        $total = count($data['categorias']);
        $data['msg'] = msg("Dados Encontrados: {$total}", 'info');
        $data['title'] = 'Categorias';
        return view('categorias/index', $data);
    }
}