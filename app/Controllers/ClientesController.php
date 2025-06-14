<?php namespace App\Controllers;

use App\Models\Usuarios;
use App\Models\Clientes;
use App\Models\Cidades;

class ClientesController extends BaseController
{
    protected $clientesModel;

    public function __construct()
    {
        $this->clientesModel = new Clientes();
        helper('form');
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('clientes');
        $builder->select('
            clientes.clientes_id,
            clientes.clientes_endereco,
            clientes.clientes_cidade_id,
            usuarios.usuarios_nome,
            usuarios.usuarios_email,
            usuarios.usuarios_fone,
            cidades.cidades_nome
        ');
        $builder->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id');
        $builder->join('cidades', 'cidades.cidades_id = clientes.clientes_cidade_id', 'left');
        $query = $builder->get();

        $data['clientes'] = $query->getResult();
        $data['title'] = 'Endereços de Clientes';
        $data['form'] = 'Listar';

        return view('clientes/index', $data);
    }

    public function create()
    {
        $usuariosModel = new Usuarios();
        $cidadesModel = new Cidades();

        // Pega todos os usuários
        $usuarios = $usuariosModel->findAll();

        // Filtra os usuários que ainda não são clientes
        $usuariosSemCliente = array_filter($usuarios, function($usuario) {
            return !$this->clientesModel->where('clientes_usuarios_id', $usuario->usuarios_id)->first();
        });

        $data['usuarios'] = $usuariosSemCliente;
        $data['cidades'] = $cidadesModel->findAll();

        $data['title'] = 'Cliente';
        $data['form'] = 'Criar';
        $data['op'] = 'store';
        $data['cliente'] = (object)[
            'clientes_id' => '',
            'clientes_usuarios_id' => '',
            'usuarios_nome' => '',
            'usuarios_email' => '',
            'usuarios_fone' => '',
            'clientes_endereco' => '',
            'clientes_cidade_id' => ''
        ];

        return view('clientes/new', $data);
    }

    public function store()
    {
        $dados = [
            'clientes_usuarios_id' => $this->request->getPost('clientes_usuarios_id'),
            'clientes_cidade_id' => $this->request->getPost('clientes_cidade_id'),
            'clientes_endereco' => $this->request->getPost('clientes_endereco'),
        ];

        if ($this->clientesModel->insert($dados)) {
            return redirect()->to('/clientes')->with('success', 'Cliente criado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao criar cliente')->withInput();
        }
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('clientes');
        $builder->select('clientes.*, usuarios.usuarios_nome, usuarios.usuarios_email, usuarios.usuarios_fone');
        $builder->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id');
        $builder->where('clientes_id', $id);
        $cliente = $builder->get()->getRow();

        if (!$cliente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente não encontrado');
        }

        $data['title'] = 'Cliente';
        $data['form'] = 'Editar';
        $data['cliente'] = $cliente;

        return view('clientes/form', $data);
    }

    public function update($id)
    {
        $clientes_id = $this->request->getPost('clientes_id');
        $usuarios_id = $this->request->getPost('clientes_usuarios_id');

        $usuariosData = [
            'usuarios_nome' => $this->request->getPost('usuarios_nome'),
            'usuarios_email' => $this->request->getPost('usuarios_email'),
            'usuarios_fone' => $this->request->getPost('usuarios_fone'),
        ];

        $clientesData = [
            'clientes_endereco' => $this->request->getPost('clientes_endereco'),
        ];

        $db = \Config\Database::connect();
        $db->table('usuarios')->update($usuariosData, ['usuarios_id' => $usuarios_id]);
        $db->table('clientes')->update($clientesData, ['clientes_id' => $clientes_id]);

        return redirect()->to(base_url('clientes'))->with('success', 'Cliente atualizado com sucesso!');
    }

    public function delete($id)
    {
        $this->clientesModel->delete($id);
        return redirect()->to(base_url('clientes'))->with('success', 'Cliente removido com sucesso!');
    }

    public function editarEndereco($id)
    {
        $model = new \App\Models\Clientes();
        $cliente = $model->find($id);
    
        if (!$cliente) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cliente não encontrado');
        }
    
        $cidadesModel = new \App\Models\Cidades();
        $cidades = $cidadesModel->findAll();
    
        $data = [
            'title' => 'Endereço',
            'form' => 'editar',
            'cliente' => $cliente,
            'cidades' => $cidades
        ];
    
        return view('enderecos/form', $data);
    }
    
    public function salvarEndereco($id)
    {
        $data = [
            'clientes_endereco' => $this->request->getPost('clientes_endereco'),
            'clientes_cidade_id' => $this->request->getPost('clientes_cidade_id'),
        ];
    
        if ($this->clientesModel->update($id, $data)) {
            return redirect()->to('/enderecos')->with('success', 'Endereço atualizado com sucesso.');
        } else {
            return redirect()->back()->with('error', 'Erro ao atualizar endereço')->withInput();
        }
    }
    

    public function enderecos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('clientes');
        $builder->select('
            clientes.clientes_id,
            clientes.clientes_endereco,
            clientes.clientes_cidade_id,
            usuarios.usuarios_nome,
            usuarios.usuarios_email,
            usuarios.usuarios_fone,
            cidades.cidades_nome
        ');
        $builder->join('usuarios', 'usuarios.usuarios_id = clientes.clientes_usuarios_id');
        $builder->join('cidades', 'cidades.cidades_id = clientes.clientes_cidade_id', 'left');
        $query = $builder->get();

        $data['clientes'] = $query->getResult();
        $data['title'] = 'Endereços de Clientes';

        return view('enderecos/index', $data);
    }
}
