<?php

namespace App\Controllers;
use App\Models\Usuarios as Usuarios_login;
// ADICIONADO: Models necessários para buscar os dados do funcionário
use App\Models\Funcionarios;
use App\Models\Entregas;

class Login extends BaseController
{
    private $data;
    private $usuarios;
    public $session;

    public function __construct(){
        helper('functions');
        $this->session = \Config\Services::session();
        $this->usuarios = new Usuarios_login();
        $this->data['title'] = 'Login';
        $this->data['msg'] = ''; 
    }

    public function index(): string
    { 
        return view('login', $this->data);
    }

    public function logar()
    {
        $login = $_REQUEST['login'];
        $senha = md5($_REQUEST['senha']);
        
        $this->data['usuarios'] = $this->usuarios->where('usuarios_cpf',$login)->
        orWhere('usuarios_email',$login)->where('usuarios_senha',$senha)->find();
        
        if(empty($this->data['usuarios'])){
            $this->data['msg'] = msg('O usuário ou a senha são inválidos!', 'danger');
            return view('login', $this->data);

        }else{
            $usuario = $this->data['usuarios'][0];

            if (
                ($usuario->usuarios_email == $login || $usuario->usuarios_cpf == $login) &&
                $usuario->usuarios_senha == $senha
            ) {
                $infoSession = (object)[
                    'usuarios_id' => $usuario->usuarios_id,
                    'usuarios_nivel' => $usuario->usuarios_nivel,
                    'usuarios_nome' => $usuario->usuarios_nome,
                    'usuarios_sobrenome' => $usuario->usuarios_sobrenome,
                    'usuarios_cpf' => $usuario->usuarios_cpf,
                    'usuarios_email' => $usuario->usuarios_email,
                    'usuarios_fone' => $usuario->usuarios_fone, // Garantindo que o fone está na sessão
                    'logged_in' => TRUE
                ];
                $this->session->set('login', $infoSession);

                if($usuario->usuarios_nivel == 0){ // Cliente
                    return view('user/index', $this->data);
                }
                elseif($usuario->usuarios_nivel == 1){ // Admin
                    return view('admin/index', $this->data);
                }
                elseif($usuario->usuarios_nivel == 2){ // Funcionário
                    
                    // ===== LÓGICA ADICIONADA PARA BUSCAR OS DADOS DO FUNCIONÁRIO =====
                    $funcionariosModel = new Funcionarios();
                    $entregasModel = new Entregas();

                    // Encontra o ID do funcionário correspondente ao usuário logado
                    $funcionario = $funcionariosModel->where('funcionarios_usuarios_id', $usuario->usuarios_id)->first();
                    
                    $entregas = [];
                    if ($funcionario) {
                        // Busca as entregas apenas para este funcionário
                        $entregas = $entregasModel->getEntregasPorFuncionario($funcionario->funcionarios_id);
                    }

                    // Adiciona as variáveis necessárias ao array de dados
                    $this->data['funcionario'] = $funcionario;
                    $this->data['entregas'] = $entregas;
                    $this->data['title'] = 'Meu Painel';
                    // =================================================================

                    return view('ViewsFuncionario/home/index', $this->data); // Carrega a view com os dados
                }
                else{
                    $this->data['msg'] = msg('Houve um problema com o seu acesso. Procure a Gerência de TI!','danger');
                    return view('login', $this->data);
                }
            }else{
                $this->data['msg'] = msg('O usuário ou a senha são inválidos!', 'danger');
                return view('login',$this->data);
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('msg', msg('Você foi desconectado com sucesso.', 'success'));
    }
}