<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{
	public $post = null;
	private $classe = null;

	public function action($classe, $acao)
	{
		$retorno = [];

		try {
			$this->post = json_decode(file_get_contents('php://input'));

			if(!$this->post)
				$this->post = (object) $this->input->post();

			$classe = ucfirst($classe);
			$obj = new $classe();
			$retorno = $obj->$acao();
			$this->db->trans_commit();
		}
		catch (Error $e) {
			$this->db->trans_rollback();
			$retorno = returnMessage(false, $e->getMessage(), 'erroPHP', 'danger');
		}
		catch (Exception $e) {
			$this->db->trans_rollback();
			$retorno = returnMessage(false, $e->getMessage(), 'erroPHP', 'danger');
		}
		echo json_encode($retorno);
	}
}
