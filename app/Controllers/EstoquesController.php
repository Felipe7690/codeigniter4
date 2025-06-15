<?php

namespace App\Controllers;

use App\Models\Estoques;
use App\Models\Produtos;

class EstoquesController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('estoques');
        $builder->select('estoques.*, produtos.produtos_nome');
        $builder->join('produtos', 'produtos.produtos_id = estoques.estoques_produtos_id');
        $data['estoques'] = $builder->get()->getResult();

        $data['title'] = 'Estoque';
        $data['form'] = 'listar';

        return view('estoques/index', $data);
    }

    public function create()
    {
        $modelEstoque = new \App\Models\Estoques();
        $modelProduto = new \App\Models\Produtos();
    
        $produtosEmEstoque = $modelEstoque->findColumn('estoques_produtos_id');
    
        if (!empty($produtosEmEstoque)) {
            $produtos = $modelProduto
                ->whereNotIn('produtos_id', $produtosEmEstoque)
                ->findAll();
        } else {
            $produtos = $modelProduto->findAll();
        }
    
        return view('estoques/form', [
            'produtos' => $produtos,
            'form' => 'cadastrar',
            'title' => 'Cadastrar Estoque'
        ]);
    }
    

    public function store()
    {
        $model = new Estoques();

        $dados = [
            'estoques_produtos_id' => $this->request->getPost('estoques_produtos_id'),
            'estoques_quantidade' => $this->request->getPost('estoques_quantidade')
        ];

        $model->insert($dados);

        return redirect()->to('/estoques')->with('success', 'Estoque criado com sucesso!');
    }

    public function edit($id)
    {
        $model = new Estoques();
        $estoque = $model->asObject()->find($id);

        if (!$estoque) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Estoque não encontrado');
        }

        $produtosModel = new Produtos();
        $data['produtos'] = $produtosModel->findAll();
        $data['estoque'] = $estoque;
        $data['title'] = 'Estoque';
        $data['form'] = 'editar';
        $data['form_label'] = 'Editar';

        return view('estoques/form', $data);
    }

    public function update($id)
    {
        $model = new Estoques();
        $dados = [
            'estoques_produtos_id' => $this->request->getPost('estoques_produtos_id'),
            'estoques_quantidade' => $this->request->getPost('estoques_quantidade')
        ];

        $model->update($id, $dados);

        return redirect()->to('/estoques')->with('success', 'Estoque atualizado com sucesso!');
    }

    public function delete($id)
    {
        if (!$id) {
            return redirect()->to('/estoques')->with('error', 'ID inválido para exclusão');
        }
    
        $model = new Estoques();
        $estoque = $model->find($id);
    
        if (!$estoque) {
            return redirect()->to('/estoques')->with('error', 'Estoque não encontrado');
        }
    
        $model->delete($id);
    
        return redirect()->to('/estoques')->with('success', 'Estoque removido com sucesso!');
    }
    
    public function search()
    {
        $pesquisa = $this->request->getPost('pesquisar');
    
        $db = \Config\Database::connect();
        $builder = $db->table('estoques');
        $builder->select('estoques.*, produtos.produtos_nome');
        $builder->join('produtos', 'produtos.produtos_id = estoques.estoques_produtos_id');
        $builder->like('produtos.produtos_nome', $pesquisa);
        $data['estoques'] = $builder->get()->getResult();
    
        $data['title'] = 'Estoque';
        $data['form'] = 'Listar';
        $data['msg'] = null;
    
        return view('estoques/index', $data);
    }
    
}
