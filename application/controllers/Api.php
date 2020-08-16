<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
	public $post = null;
	private $classe = null;

	public function action($classe, $acao)
	{
		$retorno = [];

		try {
			$this->post = json_decode(file_get_contents('php://input'));

			$this->logRequest($acao, $classe);

			if(!$this->post)
				$this->post = (object) $this->input->post();

			arrayTrim($this->post);

			$this->verifyTokenApp($acao);

			$classe = ucfirst($classe);
			$obj = new $classe($this->post);
			$retorno = $obj->$acao();
			$this->db->trans_commit();
		}
		catch (Error $e) {
			$this->db->trans_rollback();
			$retorno = returnMessage(false, $e->getMessage(), 'erroPHP', 'danger');
		}
		catch (Exception $e) {
			$this->db->trans_rollback();
			$retorno = returnMessage(false, $e->getMessage(), 'erroPHP', 'danger');
		}
		echo json_encode($retorno);
	}

	public function validaLogin($acao)
	{
		if(in_array($acao , array('login', 'logoff', 'createSession')))
			return;

		if(!$this->Users->isLogged()) {
			$retorno = returnMessage(false, 'Usuário está desconectado!', 'loginDesconected', 'danger');
			echo json_encode($retorno);
			die;
		}

		if(!isset($this->post->token) || !$this->Users->validaToken($this->post->token)) {
			$retorno = returnMessage(false, 'Token inválido!', 'tokenInvalid', 'danger');
			echo json_encode($retorno);
			die;
		}
	}

	public function verifyTokenApp($acao)
	{
		if(in_array($acao , array('login', 'logoff', 'createSession', 'register', 'sendForgotPassword', 'verifyCode', 'updatePassword')))
			return;

		if(!$this->Users->createSession()) {
			$retorno = returnMessage(false, 'Token App inválido!', 'tokenAppInvalid', 'danger');
			echo json_encode($retorno);
			die;
		}
	}

	public function logRequest($acao, $classe)
	{
		$arr['acao'] = $acao;
		$arr['classe'] = $classe;
		$arr['post'] = json_encode($this->post);
		$this->db->insert('logrequest', $arr);
	}
}
