<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dados extends CI_Model
{
	public $tabela;
	public $arrDados = array();
	public $id;
	public $acao;

	public function getDadosPost(){return $this->arrDados;}

	public function save()
	{
		if($this->acao == 'incluir')
			return $this->ApiDB->insert($this->arrDados, $this->tabela);
		else
			return $this->ApiDB->update($this->arrDados, $this->tabela, $this->id);
	}

	public function delete(){return $this->ApiDB->delete($this->tabela, $this->id);}

	public function list(){return $this->ApiDB->getAll($this->tabela);}

	public function setProp($atributo, $obj)
	{
		if(isset($obj->$atributo))
			$this->$atributo = $obj->$atributo;
	}
}
