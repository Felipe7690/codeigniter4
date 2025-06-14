<?php

namespace App\Controllers;

use App\Models\Vendas;
use CodeIgniter\RESTful\ResourceController;

class Venda extends ResourceController
{
    protected $modelName = Vendas::class;
    protected $format = 'json';

    // Listar vendas com nome do cliente
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('vendas');

        $builder->select('vendas.*, usuarios.usuarios_nome AS cliente_nome');
        $builder->join('clientes', 'clientes.clientes_id = vendas.vendas_clientes_id');
        $builder->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id');

        $query = $builder->get();
        $vendas = $query->getResult();

        $data['vendas'] = $vendas;
        $data['title'] = 'Vendas';

        return view('vendas/index', $data);
    }

    // Mostrar uma venda específica
    public function show($id = null)
    {
        $venda = $this->model->find($id);

        if (!$venda) {
            return $this->failNotFound('Venda não encontrada');
        }

        return $this->respond($venda);
    }

    // Exibe formulário (se necessário)
    public function new()
    {
        // retornar uma view se você quiser exibir um formulário
    }

    // Criar nova venda
    public function create()
    {
        $data = $this->request->getPost();
        $this->model->insert($data);

        return $this->respondCreated(['message' => 'Venda criada com sucesso']);
    }

    // Exibe formulário de edição (se necessário)
    public function edit($id = null)
    {
        $db = \Config\Database::connect();
    
        $venda = (object) $this->model->find($id);
    
        if (!$venda) {
            return redirect()->to('/venda')->with('error', 'Venda não encontrada');
        }
    
        // Buscar clientes para popular o <select>
        $clientes = $db->table('clientes')
            ->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id')
            ->select('clientes.clientes_id, clientes.clientes_endereco, usuarios.usuarios_nome') // aqui inclui o campo clientes_endereco
            ->get()
            ->getResult();

    
        return view('vendas/edit', [
            'venda' => $venda,
            'clientes' => $clientes,
        ]);
    }
    
    

    // Atualizar venda existente
    public function update($id = null)
    {
        if ($id === null) {
            $id = $this->request->getPost('vendas_id');
        }
    
        $data = [
            'vendas_clientes_id' => $this->request->getPost('vendas_clientes_id'),
            'vendas_data' => $this->request->getPost('vendas_data'),
            'vendas_valor_total' => $this->request->getPost('vendas_valor_total'),
        ];
    
        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    
        return redirect()->to('/venda')->with('success', 'Venda atualizada com sucesso!');
    }
    

    // Deletar uma venda
    public function delete($id = null)
    {
        $this->model->delete($id);
        return $this->respondDeleted(['message' => 'Venda excluída com sucesso']);
    }
}
