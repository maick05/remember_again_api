<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Dados
{
	public function __construct($obj=null)
	{
		$this->tabela = 'users';
		$this->setArrayProp($obj);
	}

	public function login()
	{
		$this->criptografarSenha();

		$where['normal'] = array('email' => $this->email, 'password' => $this->password);
		$usuario = $this->ApiDB->get($this->tabela, $where, 'id, nome, email, senha, token, tokenapp')['registro'];

		if(isset($usuario) && !empty($usuario)) {
			$this->logar($usuario);
			$arr['usuario'] = $usuario;
			$arr['token'] = $_SESSION['token'];
			$arr['tokenApp'] = $_SESSION['tokenApp'];
			return returnMessage(true, 'Usuário logado com sucesso', 'loginValido', 'success', $arr);
		}

		return returnMessage(false,'Email e/ou senha estão incorretos!', 'loginInvalido', 'danger');
	}

	private function logar($usuario, $novasessao=true)
	{
		$_SESSION['usuario'] = $usuario;
		$_SESSION['token'] = generateRandomString();

		$tokenApp = $this->ApiDB->getBy($this->tabela, $usuario['id'], 'tokenapp')['registro'];
		if($novasessao || !isset($tokenApp) || !$tokenApp || $tokenApp == '') {
			$tokenApp = generateRandomString();
			$this->ApiDB->update(array('tokenapp' => $tokenApp), $this->tabela, $usuario['id']);
		}
		$_SESSION['tokenApp'] = $tokenApp;

	}

	public function logoff()
	{
		if(!$this->isLogged())
			return returnMessage(false,'Usuário desconectado!', 'logoff', 'success');

		$this->ApiDB->update(array('tokenapp' => null), $this->tabela, $_SESSION['usuario']['id']);
		session_destroy ();
		session_unset();
		unset($_SESSION['usuario']);
		unset($_SESSION['token']);
		unset($_SESSION['tokenApp']);
		return returnMessage(false,'Usuário desconectado!', 'logoff', 'success');
	}

	public function createSession()
	{
		if(!$this->validaTokenApp($this->post->iduser, $this->post->tokenApp, $usuario))
			return false;

		if($this->isLogged())
			return true;

		$this->logar($usuario, false);

		return true;
	}

	public function save()
	{
		$this->arrDados = array('name' => $this->name, 'email' => $this->email, 'password' => $this->password);
		$this->setDicionarioErro();
		return parent::save();
	}

	public function register()
	{
		$this->acao = 'incluir';
		$this->criptografarSenha();
		$save = $this->save();

		if($save['sucesso'])
			return $this->login();
		return $save;
	}

	public function isLogged(){return isset($_SESSION['usuario']['id']) && isset($_SESSION['token']);}

	public function validaToken($token){return $token == $_SESSION['token'];}

	public function validaTokenApp($iduser, $token, &$usuario){
		$where['normal'] = array('tokenapp' => $token, 'id' => $iduser);
		$usuario = $this->ApiDB->get($this->tabela, $where, 'id, nome, email, senha, token, tokenapp')['registro'];
		return  !empty($usuario);
	}

	public function setDicionarioErro()
	{
		$this->ApiDB->dicionarioErro = array(
			'1062' => 'Já existe um usuário cadastrado com esse email!'
		);
	}

	public function criptografarSenha()
	{
		$this->password = md5(md5($this->config->item('chaveMestre')).md5($this->password));
	}

	public function sendForgotPassword()
	{
		$where['normal'] = array('email' => $this->email);
		$usuario = $this->ApiDB->get($this->tabela, $where, 'id, email')['registro'];

		if(empty($usuario)){
			return returnMessage(false, 'Email não cadastrado no sistema!', 'emailNotFound', 'danger');
		}

		$codigo = rand(100000, 999999);
		$arr = array('email' => $this->email, 'code' => $codigo);
		$this->ApiDB->insert($arr, 'securitycodes');

		$this->load->library('emailhelper');
//		$this->emailhelper->send($this->email, 'Recuperação de senha!', 'Código de recuperação de senha: '.$codigo);

		return returnMessage(true, 'Email enviado com sucesso!',	'sendCodeTrue', 'success');
	}

	public function verifyCode()
	{
		$where['normal'] = array('email' => $this->email, 'code' => $this->code, 'ativo' => 1);
		$where['all'] = 'dtinsert >= DATE_SUB(NOW(), INTERVAL 3 HOUR)';
		$code = $this->ApiDB->get('securitycodes', $where, 'id')['registro'];

		if(empty($code)){
			return returnMessage(false, 'Código inválido!', 'invalidCode', 'danger');
		}

		$this->ApiDB->update(array('ativo' => 0), 'securitycodes', $code['id']);

		return returnMessage(true, 'Código válido!',	'validCode', 'success');
	}

	public function updatePassword()
	{
		$this->criptografarSenha();

		$this->ApiDB->update(array('password' => $this->password), $this->tabela, $this->email, 'email');
		return returnMessage(true, 'Senha alterada com sucesso!',	'updatedPassword', 'success');
	}
}
