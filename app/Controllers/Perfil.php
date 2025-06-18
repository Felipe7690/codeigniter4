<?php

namespace App\Controllers;

class Perfil extends BaseController
{
    public function index()
    {
        $data['title'] = 'Meu Perfil';

        return view('ViewsCliente/perfil/index', $data);
    }
}
