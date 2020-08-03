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
		$this->setProp('id', $obj);
		$this->setProp('idcard', $obj);
		$this->setProp('acerto', $obj);
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
		return $this->ApiDB->update(array('idcontainer' => $nextContainer), 'cards', $this->idcard);
	}
}
