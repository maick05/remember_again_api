<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DBHelperApi extends CI_Model
{
	public function getErrorCode(){return (isset($this->db->error()['code'])) ? $this->db->error()['code'] : false;}

	public function getMessage(){
		$message = $this->db->error()['message'];
		$code = $this->getErrorCode();
		if($code)
			$message = $this->trataDicionarioErro($code, $message);
		return $message;
	}

	public function getSql($pre=true)
	{
		$arr['mensagem'] = $this->db->last_query();
		if($pre)
			pre($arr);
		echo json_encode($arr);
		die;
	}

	public function trataResults($results)
	{
		if($results)
			$results = $results->result_array();
		else
			$results = [];

		if(empty($results) || !$results)
			$retorno = returnMessage(false, 'Nenhum registro encontrado!', 'empty', 'info');
		else
			$retorno = returnMessage(true, count($results)." registro(s) encontrado(s)", 'arrayList', 'success');

		$retorno['results'] = $results;

		return $retorno;
	}

	public function trataRow($row)
	{
		if(!$row){
			$retorno = returnMessage(false, 'Nenhum registro encontrado!', 'empty', 'info');
			echo json_encode($retorno);
			die;
		}

		$row = $row->row_array();

		if(is_array($row) && count(array_keys($row)) == 1)
			$row = current($row);

		return returnMessage(false, 'Registro encontrado', 'empty', 'info', array('registro' => $row));
	}

	public function matchError()
	{
		$retorno = in_array($this->getErrorCode(), $this->ApiDB->arrExpectedError);
		$this->arrExpectedError = array();
		return $retorno;
	}

	public function printError()
	{
		$retorno = returnMessage(false, $this->getMessage(), 'erroDB', 'danger', array('errorCodeDB' => $this->getErrorCode()));
		if($this->matchError())
			return $retorno;
		$this->db->trans_rollback();
		echo json_encode($retorno);
		die;
	}

	public function trataDicionarioErro($code, $message)
	{
		$dicionario = $this->ApiDB->dicionarioErro;
		if(!isset($dicionario[$code]))
			return $message;
		return $dicionario[$code];
	}
}
