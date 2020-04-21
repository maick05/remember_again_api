<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
	public function index()
	{
//		$trad =  current($this->consulta(1));

//		$dados['palavra'] = ucfirst($trad['palavra']);
//		$dados['word'] = $this->Forca->hang($trad['word']);
		$dados['teclado'] = $this->Forca->getTeclado();
		$this->load->template('forca', $dados);
	}

	public function getWord($index)
	{
		$word = $this->consulta()[$index];
		$arr['word'] = json_encode($this->Forca->hang($word['word']));
		$arr['palavra'] = $word['palavra'];
		echo json_encode($arr, JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE);
	}

	public function consulta($limit=1000)
	{
		$this->db->select('palavras.word as word, palavras2.word as palavra');
		$this->db->join('traducoes trad', 'trad.idpalavra1 = palavras.id');
		$this->db->join('palavras palavras2', 'trad.idpalavra2 = palavras2.id');
		return $this->db->get('palavras', $limit)->result_array();
	}

}
