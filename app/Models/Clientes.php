<?php

namespace App\Models;

use CodeIgniter\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'clientes_id';

    protected $returnType = 'object'; // <-- importante

    protected $allowedFields = [
        'clientes_usuarios_id',
        'clientes_endereco',
        'clientes_cidade_id',
    ];
}
