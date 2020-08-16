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
}
