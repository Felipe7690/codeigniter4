<?php

namespace App\Controllers;

use App\Models\Categorias;
use App\Models\Produtos;

class HomeCliente extends BaseController
{
    protected $categorias;
    protected $produtos;

    public function __construct()
    {
        $this->categorias = new Categorias();
        $this->produtos = new Produtos();
        helper('functions');
    }

    public function index()
    {
        $categorias = $this->categorias->findAll();

        $all_produtos = [];

        foreach ($categorias as $categoria) {
            $produtos = $this->produtos
                ->join('imgprodutos', 'imgprodutos_produtos_id = produtos_id')
                ->where('produtos_categorias_id', $categoria->categorias_id)
                ->findAll();

            $all_produtos[] = [
                'categorias_id' => $categoria->categorias_id,
                'categorias_nome' => $categoria->categorias_nome,
                'produtos' => $produtos
            ];
        }

        $data = [
            'titulo' => 'Página Inicial',
            'all_produtos' => $all_produtos
        ];

        return view('ViewsCliente/home/index', $data);
    }
}
