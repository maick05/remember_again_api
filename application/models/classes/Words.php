<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Words extends Dados
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
}
