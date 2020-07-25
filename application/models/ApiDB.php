<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiDB extends CI_Model
{
	public function __construct()
	{
		$this->db->db_debug = FALSE;
	}

	public function printError()
	{
		$retorno = returnMessage(false, $this->db->error()['message'], 'erroDB', 'danger');
		echo json_encode($retorno);
		die;
	}

	public function insert($dados, $tabela)
	{
		if(!$this->Database->insert($dados, $tabela))
			$this->printError();
		return returnMessage(true, 'Registro inserido com sucesso!', 'inserted', 'success');
	}

	public function update($dados, $tabela, $where, $campowhere='id')
	{
		if(!$this->Database->update($dados, $tabela, $where, $campowhere))
			$this->printError();
		return returnMessage(true, 'Registro alterado com sucesso!', 'updated', 'success');
	}

	public function getAll($tabela)
	{
		$this->db->select('*');
		$results = $this->db->get($tabela);

		if($results)
			$results = $results->result_array();
		else
			$results = [];

		if(isset($this->db->error()['message']) && $this->db->error()['message'] && $this->db->error()['message'] != "")
			$this->printError();


		if(empty($results) || !$results)
		{
			$retorno = returnMessage(false, 'Nenhum palavra encontrada!', 'empty', 'info');
		}
		else
			$retorno = returnMessage(true, 'success!', 'arrayList', 'success');

		$retorno['results'] = $results;

		return $retorno;
	}

	public function getAllByJoin($tabela, $valor, $arrJoins=[], $coluna='id', $select='*')
	{
		$this->db->select($select);
		foreach($arrJoins as $join){
			$this->db->join($join['tabela'], "ON {$join['tabela']}.{$join['coluna']} = {$tabela}.id");
		}
		$this->db->where($coluna, $valor);
//		$arr['mensagem'] = $this->db->get_compiled_select($tabela);
//		echo json_encode($arr);
//		die;
		$results = $this->db->get($tabela);

		if($results)
			$results = $results->result_array();
		else
			$results = [];

		if(isset($this->db->error()['message']) && $this->db->error()['message'] && $this->db->error()['message'] != "")
			$this->printError();


		if(empty($results) || !$results)
		{
			$retorno = returnMessage(false, 'Nenhum registro encontrado!', 'empty', 'info');
		}
		else
			$retorno = returnMessage(true, 'success!', 'arrayList', 'success');

		$retorno['results'] = $results;
		return $retorno;
	}

	public function delete($tabela, $id)
	{
		$this->db->where('id', $id);
		$this->db->delete($tabela);

		if(isset($this->db->error()['message']) && $this->db->error()['message'] && $this->db->error()['message'] != "")
			$this->printError();

		return returnMessage(true, 'Registro deletado com sucesso!', 'delated', 'success');
	}
}
