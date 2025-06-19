<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    /**
     * Este método é executado ANTES do controller.
     * Perfeito para verificações de login.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Se a sessão 'login' NÃO existir...
        if (!session()->has('login')) {
            // ...redireciona o usuário para a página de login.
            return redirect()->to('/login')->with('msg', msg('Você precisa estar logado para acessar esta página.', 'warning'));
        }
    }

    /**
     * Este método é executado DEPOIS do controller.
     * Não precisaremos usá-lo para esta finalidade.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer aqui.
    }
}