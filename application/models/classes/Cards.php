<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cards extends Dados
{
	private $joinAnswersCard = array('tabela' => 'answerscard', 'coluna' => 'idcard');
	private $joinAnswer = array('tabela' => 'answers', 'coluna' => 'id', 'tabelaJoin' => 'answerscard', 'colunaJoin' => 'idanswer');

	function __construct($obj=false)
	{
		$this->tabela = 'cards';

		if(!validaObj($obj))
			return;

		if(isset($obj->nome))
			$this->arrDados['word'] = $obj->nome;

		$this->setProp('id', $obj);
		$this->setProp('idcontainer', $obj);
		$this->setProp('acao', $obj);
	}

	public function listByContainer()
	{
		$where['normal'] = array('idcontainer' => $this->idcontainer);
		$where['or'] = array(
							'#1' => 'dtanswer IS NULL',
							"#2" => 'dtanswer <= DATE_SUB(NOW(), INTERVAL 16 HOUR)'
						);

		$retorno = $this->ApiDB->getAllByJoin(
			$this->tabela,
			$where,
			array($this->joinAnswersCard, $this->joinAnswer),
			'cards.id, cards.word as card, answers.word as resposta, idcontainer');

		$retorno['results'] = $this->trataResultCards($retorno['results']);
		return $retorno;
	}

	public function trataResultCards($results)
	{
		$arr = array();
		foreach ($results as $card){
			$arr[$card['card']]['id'] = $card['id'];
			$arr[$card['card']]['card'] = $card['card'];
			$arr[$card['card']]['idcontainer'] = $card['idcontainer'];
			$arr[$card['card']]['respostas'][] = $card['resposta'];
		}

		return array_values($arr);
	}
}
