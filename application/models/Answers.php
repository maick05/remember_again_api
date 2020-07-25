<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answers extends Dados
{
	function __construct()
	{
		$this->tabela = 'words';
	}

	public function getDadosPost()
	{
		$this->arrDados['palavra'] = $this->post->nome;
		return $this->arrDados;
	}

	public function listBy()
	{
		$id = $this->post->id;
		return $this->ApiDB->getAllByJoin('answers', $id, array(array('tabela' => 'answersword', 'coluna' => 'idanswer')), 'answersword.idword');
	}
}
