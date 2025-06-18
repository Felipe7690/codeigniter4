<?php

namespace App\Controllers;

use App\Models\Funcionarios;
use App\Models\Usuarios;

class FuncionariosController extends BaseController
{
    public function index()
    {
        $model = new Funcionarios();
    
        $search = $this->request->getGet('q');
    
        $model = $model
            ->select('funcionarios.*, usuarios.usuarios_nome')
            ->join('usuarios', 'usuarios.usuarios_id = funcionarios.funcionarios_usuarios_id');
    
        if ($search) {
            $model = $model->groupStart()
                ->like('usuarios.usuarios_nome', $search)
                ->orLike('funcionarios.funcionarios_cargo', $search)
                ->groupEnd();
        }
    
        $funcionarios = $model->asObject()->findAll();
    
        $dados = [
            'title' => 'Lista de Funcionários',
            'funcionarios' => $funcionarios,
            'search' => $search
        ];
    
        return view('funcionarios/index', $dados);
    }
    

    public function create()
    {
        $usuarios = (new Usuarios())->findAll();
        return view('funcionarios/form', [
            'form' => 'cadastrar',
            'usuarios' => $usuarios,
            'title' => 'Cadastrar Funcionário'
        ]);
    }

    public function store()
    {
        $model = new Funcionarios();
        $model->insert($this->request->getPost());
        return redirect()->to('/funcionarios');
    }

    public function edit($id)
    {
        $model = new Funcionarios();
        $usuarios = (new Usuarios())->findAll();
        $funcionario = (object) $model->find($id);
        return view('funcionarios/form', [
            'form' => 'editar',
            'funcionario' => $funcionario,
            'usuarios' => $usuarios,
            'title' => 'Editar Funcionário'
        ]);
    }

    public function update($id)
    {
        $model = new Funcionarios();
        $model->update($id, $this->request->getPost());
        return redirect()->to('/funcionarios');
    }

    public function delete($id)
    {
        $model = new Funcionarios();
        $model->delete($id);
        return redirect()->to('/funcionarios');
    }
}
