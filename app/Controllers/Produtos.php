<?php

namespace App\Controllers;
use App\Models\Produtos as Produtos_model;
use App\Models\Categorias as Categorias_model;

class Produtos extends BaseController
{
    private $produtos;
    private $categorias;

    public function __construct(){
        $this->produtos = new Produtos_model();
        $this->categorias = new Categorias_model();
        helper('functions');
    }

    public function index(): string
    {
        $data['title'] = 'Produtos';
        $data['produtos'] = $this->produtos->select('produtos.*, categorias.categorias_nome')
                                           ->join('categorias', 'produtos_categorias_id = categorias_id')
                                           ->findAll();
        $data['msg'] = session()->getFlashdata('msg');
        return view('produtos/index', $data);
    }

    public function new(): string
    {
        $data['title'] = 'Novo Produto';
        $data['op'] = 'create';
        $data['form'] = 'Cadastrar';
        $data['categorias'] = $this->categorias->findAll();
        $data['produto'] = new \stdClass(); 
        return view('produtos/form', $data);
    }

    public function create()
    {
        if(!$this->validate([
            'produtos_nome' => 'required|max_length[255]|min_length[3]',
            'produtos_preco_custo' => 'required',
            'produtos_preco_venda' => 'required',
            'produtos_categorias_id' => 'required|integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'produtos_nome' => $this->request->getPost('produtos_nome'),
            'produtos_descricao' => $this->request->getPost('produtos_descricao'),
            'produtos_preco_custo' => moedaDolar($this->request->getPost('produtos_preco_custo')),
            'produtos_preco_venda' => moedaDolar($this->request->getPost('produtos_preco_venda')),
            'produtos_categorias_id' => $this->request->getPost('produtos_categorias_id')
        ];
        
        $this->produtos->save($dados);
        
        return redirect()->to('/produtos')->with('msg', msg('Cadastrado com Sucesso!', 'success'));
    }

    public function delete($id)
    {
        $this->produtos->delete($id);
        return redirect()->to('/produtos')->with('msg', msg('Deletado com Sucesso!', 'success'));
    }

    public function edit($id)
    {
        $data['categorias'] = $this->categorias->findAll();
        $data['produto'] = $this->produtos->find($id); 
        if (!$data['produto']) {
            return redirect()->to('/produtos')->with('msg', msg('Produto não encontrado!', 'danger'));
        }
        $data['title'] = 'Editar Produto';
        $data['form'] = 'Alterar';
        $data['op'] = 'update/' . $id;
        return view('produtos/form', $data);
    }

    public function update($id)
    {
        $dados = [
            'produtos_nome' => $this->request->getPost('produtos_nome'),
            'produtos_descricao' => $this->request->getPost('produtos_descricao'),
            'produtos_preco_custo' => moedaDolar($this->request->getPost('produtos_preco_custo')),
            'produtos_preco_venda' => moedaDolar($this->request->getPost('produtos_preco_venda')),
            'produtos_categorias_id' => $this->request->getPost('produtos_categorias_id')
        ];

        $this->produtos->update($id, $dados);
        
        return redirect()->to('/produtos')->with('msg', msg('Alterado com Sucesso!', 'success'));
    }

    public function search()
    {
        $termo = $this->request->getPost('pesquisar');
        $data['produtos'] = $this->produtos->select('produtos.*, categorias.categorias_nome')
                                           ->join('categorias', 'produtos_categorias_id = categorias_id')
                                           ->like('produtos_nome', $termo)
                                           ->orLike('categorias_nome', $termo)
                                           ->findAll();
        
        $total = count($data['produtos']);
        $data['msg'] = msg("Dados Encontrados: {$total}", 'info');
        $data['title'] = 'Produtos';
        return view('produtos/index', $data);
    }
}