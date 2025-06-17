<?php

namespace App\Controllers;
use App\Models\Cidades as Cidades_model;

class Cidades extends BaseController
{   
    private $cidades; 
    
    public function __construct(){
        $this->cidades = new Cidades_model();
        helper('functions');
    }

    public function index(): string
    {
        $session = session();
        $data['title'] = 'Cidades';
        $data['cidades'] = $this->cidades->findAll();
        // Passa a mensagem da sessão para a view, se existir
        $data['msg'] = $session->getFlashdata('msg');
        return view('cidades/index',$data);
    }

    public function new(): string
    {
        $data['title'] = 'Cadastrar Cidade';
        $data['form'] = 'cadastrar';
        $data['op'] = 'create';
        // Objeto vazio para não dar erro na view
        $data['cidades'] = new \stdClass();
        return view('cidades/form',$data);
    }
    
    public function create()
    {
        $session = session();

        $regras = [
            'cidades_nome' => 'required|max_length[255]|min_length[3]',
            'cidades_uf' => 'required|max_length[2]|min_length[2]'
        ];

        if(!$this->validate($regras)) {
            // A validação falha, então retorna ao formulário com os erros
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'cidades_nome' => $this->request->getPost('cidades_nome'),
            'cidades_uf'   => $this->request->getPost('cidades_uf')
        ];

        $this->cidades->save($dados);
        
        // Define a mensagem de sucesso e redireciona
        $session->setFlashdata('msg', msg('Cadastrado com Sucesso!', 'success'));
        return redirect()->to('/cidades');
    }

    public function delete($id)
    {
        $session = session();
        if($this->cidades->delete($id)) {
            $session->setFlashdata('msg', msg('Deletado com Sucesso!', 'success'));
        } else {
            $session->setFlashdata('msg', msg('Erro ao deletar!', 'danger'));
        }
        return redirect()->to('/cidades');
    }

    public function edit($id)
    {
        // Forma mais limpa de buscar um único registro pelo ID
        $cidade = $this->cidades->find($id);

        if (!$cidade) {
            // Se não encontrar a cidade, redireciona com erro
            return redirect()->to('/cidades')->with('msg', msg('Cidade não encontrada', 'danger'));
        }

        $data['cidades'] = $cidade;
        $data['title'] = 'Editar Cidade';
        $data['form'] = 'Alterar';
        // A rota para o update deve incluir o ID
        $data['op'] = 'update/' . $id;
        return view('cidades/form',$data);
    }

    public function update($id)
    {
        $session = session();
        
        $dados = [
            'cidades_nome' => $this->request->getPost('cidades_nome'),
            'cidades_uf'   => $this->request->getPost('cidades_uf')
        ];

        if ($this->cidades->update($id, $dados)) {
            $session->setFlashdata('msg', msg('Alterado com Sucesso!', 'success'));
        } else {
            $session->setFlashdata('msg', msg('Erro ao alterar!', 'danger'));
        }
        return redirect()->to('/cidades');
    }

    public function search()
    {
        $termo = $this->request->getPost('pesquisar');
        $data['cidades'] = $this->cidades->like('cidades_nome', $termo)->findAll();
        $total = count($data['cidades']);
        $data['msg'] = msg("Dados Encontrados: {$total}", 'info');
        $data['title'] = 'Cidades';
        return view('cidades/index',$data);
    }
}