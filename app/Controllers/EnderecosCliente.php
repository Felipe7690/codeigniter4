<?php

namespace App\Controllers;

use App\Models\Clientes;
use App\Models\Cidades;

class EnderecosCliente extends BaseController
{
    public function index()
    {
        $usuarioSessao = session()->get('login');
        $usuarioId = $usuarioSessao ? $usuarioSessao->usuarios_id : null;

        if (!$usuarioId) {
            return redirect()->to(base_url('login'));
        }

        $clienteModel = new Clientes();
        $cidadeModel = new Cidades();

        $cliente = $clienteModel->where('clientes_usuarios_id', $usuarioId)->first();

        $cidadeNome = null;
        if ($cliente && $cliente->clientes_cidade_id) {
            $cidade = $cidadeModel->find($cliente->clientes_cidade_id);
            $cidadeNome = $cidade ? $cidade->cidades_nome : null;
        }

        return view('ViewsCliente/endereco/index', [
            'cliente' => $cliente,
            'cidadeNome' => $cidadeNome
        ]);
    }

    public function editar()
    {
        $usuarioSessao = session()->get('login');
        $usuarioId = $usuarioSessao ? $usuarioSessao->usuarios_id : null;

        if (!$usuarioId) {
            return redirect()->to(base_url('login'));
        }

        $clienteModel = new Clientes();
        $cidadeModel = new Cidades();

        if ($this->request->getMethod() === 'post') {
            $dados = [
                'clientes_endereco' => $this->request->getPost('clientes_endereco'),
                'clientes_cidade_id' => $this->request->getPost('clientes_cidade_id'),
            ];

            $clienteModel->where('clientes_usuarios_id', $usuarioId)->set($dados)->update();

            return redirect()->to(base_url('cliente/endereco'))->with('msg', 'Endereço atualizado com sucesso!');
        }

        $cliente = $clienteModel->where('clientes_usuarios_id', $usuarioId)->first();
        $cidades = $cidadeModel->findAll();

        return view('ViewsCliente/endereco/form', [
            'cliente' => $cliente,
            'cidades' => $cidades,
        ]);
    }

    public function salvar()
    {
        $usuarioSessao = session()->get('login');
        $usuarioId = $usuarioSessao ? $usuarioSessao->usuarios_id : null;

        if (!$usuarioId) {
            return redirect()->to(base_url('login'));
        }

        $clienteModel = new Clientes();

        $dados = [
            'clientes_endereco' => $this->request->getPost('clientes_endereco'),
            'clientes_cidade_id' => $this->request->getPost('clientes_cidade_id'),
        ];

        $clienteModel->where('clientes_usuarios_id', $usuarioId)->set($dados)->update();

        return redirect()->to(base_url('cliente/endereco'))->with('msg', 'Endereço atualizado com sucesso!');
    }
}
