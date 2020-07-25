<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dados extends CI_Model
{
	public $tabela;
	public $arrDados = array();

	public function getDadosPost(){return $this->arrDados;}

	public function save()
	{
		$arr = $this->getDadosPost();

		if($this->post->acao == 'incluir')
			return $this->ApiDB->insert($arr, $this->tabela);
		else
			return $this->ApiDB->update($arr, $this->tabela, $this->post->id);
	}

	public function delete(){return $this->ApiDB->delete($this->tabela, $this->post->id);}

	public function list(){return $this->ApiDB->getAll($this->tabela);}
}
