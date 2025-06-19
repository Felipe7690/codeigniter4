<?php

namespace App\Controllers;

use App\Models\Entregas as Entregas_model;
use App\Models\Funcionarios as Funcionarios_model;

class UserFuncionario extends BaseController
{
public function index()
{
    $session = session();
    $login = $session->get('login');

    if (!$login || $login->usuarios_nivel != 2) {
        return redirect()->to('/login')->with('msg', msg('Acesso não permitido!', 'danger'));
    }

    $funcionarioModel = new \App\Models\Funcionarios();
    $entregaModel = new \App\Models\Entregas();

    $funcionario = $funcionarioModel->where('funcionarios_usuarios_id', $login->usuarios_id)->first();

    $entregas = [];
    if ($funcionario) {
        $entregas = $entregaModel->getEntregasPorFuncionario($funcionario->funcionarios_id);
    }
    
    $data = [
        'title'       => 'Meu Painel',
        'entregas'    => $entregas,
        'funcionario' => $funcionario, 
        'msg'         => $session->getFlashdata('msg')
    ];

    return view('ViewsFuncionario/home/index', $data); 
}
}