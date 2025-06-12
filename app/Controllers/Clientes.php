<?php

namespace App\Controllers;

use App\Models\Clientes;

class Clientes extends BaseController
{
    private $clientes;

    public function __construct()
    {
        $this->clientes = new Clientes();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data['clientes'] = $this->clientes->findAll();
        $data['title'] = 'Clientes';
        return view('clientes/index', $data);
    }

    public function new()
    {
        $data['cliente'] = (object)[
            'cliente_id' => '',
            'cliente_nome' => '',
            'cliente_email' => '',
            'cliente_telefone' => '',
            'cliente_endereco' => ''
        ];
        $data['op'] = 'create';
        $data['title'] = 'Novo Cliente';
        return view('clientes/form', $data);
    }

    public function create()
    {
        $this->clientes->save($this->request->getPost());
        return redirect()->to('/clientes')->with('msg', 'Cliente cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $data['cliente'] = $this->clientes->find($id);
        $data['op'] = 'update';
        $data['title'] = 'Editar Cliente';
        return view('clientes/form', $data);
    }

    public function update()
    {
        $this->clientes->save($this->request->getPost());
        return redirect()->to('/clientes')->with('msg', 'Cliente atualizado com sucesso!');
    }

    public function delete($id)
    {
        $this->clientes->delete($id);
        return redirect()->to('/clientes')->with('msg', 'Cliente excluído!');
    }
}
