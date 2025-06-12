<?php

namespace App\Models;

use CodeIgniter\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';
    protected $allowedFields = [
        'cliente_nome',
        'cliente_email',
        'cliente_telefone',
        'cliente_endereco'
    ];
}
