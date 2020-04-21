<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forca extends CI_Model
{
	public function getTeclado()
	{
		$letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'X', 'W','Y','Z'];
		shuffle($letras);

		$teclado = '';
		foreach ($letras as $i => $letter)
		{
			$arr['letra'] = strtoupper($letter);
			$teclado .= $this->getLetter($arr, $i, 'tecla clicar');
		}

		return $teclado;
	}

	public function hang($word)
	{
		$split = str_split($word);
		$forca = [];

		foreach ($split as $i => $letter)
		{
			$arr['letra'] = strtoupper($letter);
			$l = [];
			$this->getLetter($arr, $i, 'letter revelar','__', $l);
			$forca[] = $l;
		}

		return $forca;
	}

	public function getLetter($info, $i, $classe='', $sub='', &$arr=[])
	{
		$style = "margin-right: 1px !important;";
		$letra = $info['letra'];
		if($sub)
			$letra = $sub;
		else
			$style .= 'margin: 5px;';

		if($i == 0 && $sub)
			$style .= " margin-left: -1px !important;";
		$let = "<div class=\"card letra {$classe}\" style=\"{$style}\" data-letra='{$info['letra']}' data-revela='0'>{$letra}</div>";

		$arr['style'] = $style;
		$arr['sub'] = $letra;
		$arr['letra'] = $info['letra'];
		$arr['classe'] = $classe;

//		return $arr;
		return trim($let);
	}
}
