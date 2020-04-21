<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
	private $post = null;

	public function action($acao)
	{
		$retorno = [];

		try {
			$this->post = json_decode(file_get_contents('php://input'));
			$retorno = $this->$acao();
		}
		catch (Error $e) {
			$retorno = returnMessage(false, $e->getMessage(), 'erroPHP', 'danger');
		}
		catch (Exception $e) {
			$retorno = returnMessage(false, $e->getMessage(), 'erroPHP', 'danger');
		}
		echo json_encode($retorno);
	}

	public function save()
	{
		$arr['palavra'] = $this->post->nome;
		$acao = $this->post->acao;
		if($acao == 'incluir')
			return $this->ApiDB->insert($arr, 'words');
		else
			return $this->ApiDB->update($arr, 'words', $this->post->id);
	}

	public function list()
	{
		return $this->ApiDB->getAll('words');
	}

	public function delete()
	{
		$id = $this->post->id;
		return $this->ApiDB->delete('words', $id);
	}
}
