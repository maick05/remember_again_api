<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Model
{
	public function __construct(){$this->db->db_debug = FALSE;}

	public function getError(){return isset($this->db->error()['message']) && $this->db->error()['message'] && $this->db->error()['message'] != "";}

	public function insert($dados, $tabela)
	{
		$dados = array_filter($dados);
		$this->unsetArray($dados);
		$this->db->insert($tabela, $dados);
		return !$this->getError() && $this->db->insert_id();
	}

	public function update($dados, $tabela, $where, $campowhere='id')
	{
		$dados = array_null($dados);

		$this->db->where($campowhere, $where);
		$this->db->update($tabela, $dados);

		return !$this->getError();
	}

	public function delete($tabela, $where, $coluna='id')
	{
		if(is_array($where))
			$this->db->where($where);
		else
			$this->db->where($coluna, $where);

		$this->db->delete($tabela);
		return !$this->getError();
	}

	public function getAll($tabela)
	{
		$this->db->select('*');
		return $this->db->get($tabela);
	}

	public function getAllByJoin($tabela, $valor, $arrJoins=[], $coluna='id', $select='*')
	{
		$this->db->select($select);
		foreach ($arrJoins as $join) {
			$this->db->join($join['tabela'], "ON {$join['tabela']}.{$join['coluna']} = {$tabela}.id");
		}
		$this->db->where($coluna, $valor);
		return $this->db->get($tabela);
	}

	public function getByOld($tabela, $where, $campoWhere='id', $select='*')
	{
		$this->db->select($select);

		if(is_array($campoWhere))
			$this->db->where($campoWhere);
		else
			$this->db->where($campoWhere, $where);

		$query = $this->db->get($tabela, 1);

		if($query)
			return $query->row_array();
		else
			return null;
	}

	private function unsetArray(&$dados)
	{
		foreach ($dados as $campo => $valor)
		{
			if($valor == '@atual')
			{
				unset($dados[$campo]);
			}
		}
	}
}
