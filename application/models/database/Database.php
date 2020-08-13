<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Model
{
	public function __construct(){$this->db->db_debug = FALSE;}

	public function getError(){return isset($this->db->error()['message']) && $this->db->error()['message'] && $this->db->error()['message'] != "";}

	public function insert($dados, $tabela)
	{
		$dados = array_filter($dados, 'strlen');
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

		$this->montaJoin($arrJoins, $tabela);

		$this->db->where($coluna, $valor);
//		$this->ApiDB->getSql($tabela);
		return $this->db->get($tabela);
	}

	public function getByJoin($tabela, $valor, $arrJoins=[], $coluna='id', $select='*')
	{
		$this->db->select($select);

		$this->montaJoin($arrJoins, $tabela);

		$this->db->where($coluna, $valor);
//		$this->ApiDB->getSql($tabela);
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

	public function getAllGroupBy($tabela, $colunaGroup, $exists=false, $orderBy='id', $nulo=false)
	{
		$this->db->select($colunaGroup.", COUNT(*) as qtd");

		if(!$nulo)
			$this->db->where($colunaGroup." IS NOT NULL");

		$this->db->where($exists, null, false);

		$this->db->group_by($colunaGroup);
		$this->db->order_by($orderBy);

		return $this->db->get($tabela);
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

	public function montaJoin($arrJoins, $tabela)
	{
		foreach ($arrJoins as $join) {

			$tabelaJoin = $tabela;
			if(isset($join['tabelaJoin']))
				$tabelaJoin = $join['tabelaJoin'];

			$colunaJoin = 'id';
			if(isset($join['colunaJoin']))
				$colunaJoin = $join['colunaJoin'];

			$this->db->join($join['tabela'], "ON {$join['tabela']}.{$join['coluna']} = {$tabelaJoin}.{$colunaJoin}");
		}
	}
}
