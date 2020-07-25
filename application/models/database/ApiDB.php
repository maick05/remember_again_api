<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiDB extends DBHelperApi
{
	public $arrExpectedError = array();
	public $dicionarioErro = array();

	public function insert($dados, $tabela)
	{
		if(!$this->Database->insert($dados, $tabela))
			return $this->printError();
		$arr = array('insertId' => $this->db->insert_id());
		return returnMessage(true, 'Registro inserido com sucesso!', 'inserted', 'success', $arr);
	}

	public function update($dados, $tabela, $where, $campowhere='id')
	{
		if(!$this->Database->update($dados, $tabela, $where, $campowhere))
			$this->printError();
		return returnMessage(true, 'Registro alterado com sucesso!', 'updated', 'success');
	}

	public function getAll($tabela)
	{
		$results = $this->Database->getAll($tabela);

		if($this->Database->getError())
			$this->printError();

		return $this->trataResults($results);
	}

	public function getAllByJoin($tabela, $valor, $arrJoins=[], $coluna='id', $select='*')
	{
		$results = $this->Database->getAllByJoin($tabela, $valor, $arrJoins, $coluna, $select);

		if($this->Database->getError())
			$this->printError();

		return $this->trataResults($results);
	}

	public function delete($tabela, $valor, $coluna='id')
	{
		if(!$this->Database->delete($tabela, $valor, $coluna))
			$this->printError();

		return returnMessage(true, 'Registro deletado com sucesso!', 'deleted', 'success');
	}

	public function getBy($tabela, $valor, $select='*', $coluna='id')
	{
		$this->db->select($select);
		$this->db->where($coluna, $valor);
		$row = $this->db->get($tabela);

		if($this->Database->getError())
			$this->printError();

		return $this->trataRow($row);
	}
}
