<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Containers extends Dados
{
	public $lastNivel = 4;
	public $joinCards = array('tabela' => 'cards', 'coluna' => 'idcontainer');
	public $idcard;
	public $nivel;
	public $acerto;

	public function __construct($obj=null)
	{
		$this->tabela = 'containers';
		$this->setArrayProp($obj);
	}

	public function getNivel()
	{
		$this->nivel = $this->ApiDB->getBy($this->tabela, $this->id, 'nivel')['registro'];
		return $this->nivel;
	}

	public function getContainerNextNivel()
	{
		$this->getNivel();

		if(($this->nivel == 1 && !$this->acerto) || ($this->nivel == $this->lastNivel && $this->acerto))
			return $this->id;

		$next = $this->acerto ? 1 : -1;

		return $this->ApiDB->getBy($this->tabela, $this->nivel + $next, 'id', 'nivel')['registro'];
	}

	public function moveCardToContainer()
	{
		$nextContainer = $this->getContainerNextNivel();
		return $this->ApiDB->update(array('idcontainer' => $nextContainer, 'dtanswer' => date('Y-m-d H:i:s')), 'cards', $this->idcard);
	}

	public function getQtdCardsByContainer()
	{
		$where['normal'] = array('iduser' => $_SESSION['usuario']['id']);
		$where['or'] = array(
			'#1' => 'dtanswer IS NULL',
			'#3' => $this->montaQueryPeriodo()
		);

		$exists = 'exists (select 1 from answerscard where answerscard.idcard  = cards.id)';
		$arr = $this->ApiDB->getAllGroupBy('cards', 'idcontainer', $where, $exists, 'idcontainer');
		$arr['results'] = $this->formataArrayQtd($arr['results']);
		return $arr;
	}

	public function formataArrayQtd($arr)
	{
		$array = array(['qtd' => 0], ['qtd' => 0], ['qtd' => 0], ['qtd' => 0]);
		foreach ($arr as $key => $value)
		{
			if( $value['idcontainer'] == 1)
				$array[0] = $value;
			else if( $value['idcontainer'] == 2)
				$array[1] = $value;
			else if( $value['idcontainer'] == 3)
				$array[2] = $value;
			else
				$array[3] = $value;
		}

		return $array;
	}

	public function montaQueryPeriodo()
	{
		$query = "`dtanswer` <= DATE_SUB(NOW(), INTERVAL 16 HOUR) AND
				(
				  (idcontainer = 1 AND dtanswer <= DATE_SUB(NOW(), INTERVAL 1 DAY))
				  OR (idcontainer = 2 AND dtanswer <= DATE_SUB(NOW(), INTERVAL 7 DAY))
				  OR (idcontainer = 3 AND dtanswer <= DATE_SUB(NOW(), INTERVAL 15 DAY))
				  OR (idcontainer = 4 AND dtanswer <= DATE_SUB(NOW(), INTERVAL 30 DAY))
				 )";
		return $query;
	}
}
