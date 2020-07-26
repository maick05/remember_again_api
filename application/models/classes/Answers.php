<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answers extends Dados
{
	private $joinAnswersCard = array('tabela' => 'answerscard', 'coluna' => 'idanswer');

	function __construct()
	{
		$this->tabela = 'answers';
	}

	public function setDicionarioErro()
	{
		$this->ApiDB->dicionarioErro = array(
			'1062' => 'Já existe uma resposta para esse card!'
		);
	}

	public function getDadosPost()
	{
		$this->arrDados['word'] = $this->post->nome;
		return $this->arrDados;
	}

	public function listBy(){return $this->ApiDB->getAllByJoin($this->tabela, $this->post->id, array($this->joinAnswersCard), 'answerscard.idcard');}

	public function save()
	{
		$this->db->trans_begin();

		// Caso de erro de duplicidade espera para fazer outra acao
		$this->ApiDB->arrExpectedError = array('1062');

		// Executa o metodo de salvar padrao usando a tabela do objeto
		$retorno = $this->trataDuplicidade($this->post->nome, parent::save());

		// Se a ação for edição retorna da acao de update
		if($this->post->acao != 'incluir')
			return $retorno;

		return $this->vinculaAnswerToCard($this->post->idcard, $retorno['insertId']);
	}

	private function trataDuplicidade($palavra, $retornoInsert)
	{
		if(!isset($retornoInsert['errorCodeDB']) || !$retornoInsert['errorCodeDB'] || $retornoInsert['errorCodeDB'] != "1062")
			return $retornoInsert;

		$retorno['insertId'] = $this->getIdAnswer($palavra);
		return $retorno;
	}

	public function vinculaAnswerToCard($idcard, $idanswer)
	{
		$this->setDicionarioErro();
		$arr['idcard'] = $idcard;
		$arr['idanswer'] = $idanswer;
		return $this->ApiDB->insert($arr, 'answerscard');
	}

	public function desvinculaAnswerFromCard()
	{
		return $this->ApiDB->delete('answerscard', $this->post->id);
	}

	public function getIdAnswer($palavra){return $this->ApiDB->getBy($this->tabela, $palavra, 'id', 'word')['registro'];}
}
