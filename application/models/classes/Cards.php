<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cards extends Dados
{
	function __construct()
	{
		$this->tabela = 'cards';
	}

	public function getDadosPost()
	{
		$this->arrDados['word'] = $this->post->nome;
		return $this->arrDados;
	}
}
