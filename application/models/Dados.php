<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dados extends CI_Model
{
	public $tabela;
	public $arrDados = array();

	public function getDadosPost()
	{
		return $arrDados;
	}

	public function save()
	{
		$arr = $this->getDadosPost();
		$acao = $this->post->acao;
		$id = $this->post->id;

		if($acao == 'incluir')
			return $this->ApiDB->insert($arr, $this->tabela);
		else
			return $this->ApiDB->update($arr, $this->tabela, $id);
	}

	public function delete()
	{
		$id = $this->post->id;
		return $this->ApiDB->delete($this->tabela, $id);
	}

	public function list()
	{
		return $this->ApiDB->getAll($this->tabela);
	}
}
