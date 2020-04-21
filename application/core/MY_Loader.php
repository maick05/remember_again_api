<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Loader extends CI_loader 
{
	public function template($view, $dados = array(), $out=false)
	{
		
		$data['out'] = $out;


		$this->view("estrutura/header", $dados);

		$this->loadHiddens();

		$this->view($view, $dados);
		echo '</div>';

	}

	public function loadHiddens()
	{
		echo "<input type='hidden' value='{$this->config->item('hostFixo')}' id='url'>";
	}
}
