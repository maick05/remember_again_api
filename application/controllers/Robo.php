<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Robo extends CI_Controller
{
	public function api()
	{
		$acao = 'alterar';
		$tabela = 'asteroides';
		$idlogservico = '';
		$this->load->model('Robos/RoboAsteroides');

		$this->Log->iniciarServico('Robo - '.$acao.'('.$tabela.')', $idlogservico);

		for($i = 21; $i <= 30; $i++)
		{
			$this->RoboAsteroides->iniciar('alterar', 'asteroides', $i, $idlogservico);
		}

		$this->Log->finalizarServico($idlogservico);
		pre('Fim');
    }
}
