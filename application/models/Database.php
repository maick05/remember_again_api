<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends CI_Model
{
	public function __construct()
	{
		$this->db->db_debug = FALSE;
	}

	public function getTabauxRecords($campoaux, $escala='', $idexterno='')
	{
		$tabela = explode('.', $campoaux)[0];

		if($tabela == 'tipos')
			$this->db->select('id, '.$campoaux.', COALESCE(descricao, "Sem informação") as descricao');
		else
			$this->db->select('id, '.$campoaux);

		if($escala && $tabela !== 'subtipos')
				$this->db->where('escala', $escala);
		if($idexterno && $escala)
				$this->db->where('idtipo', $idexterno);
		$this->db->order_by('nome');

		return $this->db->get($tabela)->result_array();
	}

	public function insert($dados, $tabela)
	{
		$dados = array_filter($dados);
		$this->unsetArray($dados);

		$this->db->insert($tabela, $dados);
		return $this->db->insert_id();
	}

	public function unsetArray(&$dados)
	{
		foreach ($dados as $campo => $valor)
		{
			if($valor == '@atual')
			{
				unset($dados[$campo]);
			}
		}
	}

	public function update($dados, $tabela, $where, $campowhere='id')
	{
		$dados = array_null($dados);

		$this->db->where($campowhere, $where);
		$this->db->update($tabela, $dados);

		if($this->db->error()['message'])
			return false;
		else
			return true;
	}

	public function getBy($tabela, $where, $campoWhere='id', $select='*')
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
}
