<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Answers extends Dados
{
	private $joinAnswersCard = array('tabela' => 'answerscard', 'coluna' => 'idanswer');
	public $idcard;
	public $acerto;
	public $resposta;
	private $tabelaVinculo = 'answerscard';
	private $tabelaLog = 'loganswers';

	function __construct($obj=null)
	{
		$this->tabela = 'answers';

		if(!validaObj($obj))
			return;

		if(isset($obj->nome))
			$this->arrDados['word'] = $obj->nome;

		$this->setArrayProp($obj);
	}

	public function setDicionarioErro()
	{
		$this->ApiDB->dicionarioErro = array(
			'1062' => 'Já existe uma resposta para esse card!'
		);
	}

	public function listBy()
	{
		$where['normal'] = array($this->tabelaVinculo.'.idcard' => $this->idcard);
		return $this->ApiDB->getAllByJoin($this->tabela, $where, array($this->joinAnswersCard));
	}

	public function save()
	{
		$this->db->trans_begin();

		// Caso de erro de duplicidade espera para fazer outra acao
		$this->ApiDB->arrExpectedError = array('1062');

		// Executa o metodo de salvar padrao usando a tabela do objeto
		$retorno = $this->trataDuplicidade($this->arrDados['word'], parent::save());

		// Se a ação for edição retorna da acao de update
		if($this->acao != 'incluir')
			return $retorno;

		return $this->vinculaAnswerToCard($this->idcard, $retorno['insertId']);
	}

	private function trataDuplicidade($palavra, $retornoInsert)
	{
		if(!isset($retornoInsert['errorCodeDB']) || !$retornoInsert['errorCodeDB'] || $retornoInsert['errorCodeDB'] != "1062")
			return $retornoInsert;

		$retorno['insertId'] = $this->getIdAnswer($palavra);
		return $retorno;
	}

	public function vinculaAnswerToCard($idcard, $idanswer)
	{
		$this->setDicionarioErro();
		$arr['idcard'] = $idcard;
		$arr['idanswer'] = $idanswer;
		return $this->ApiDB->insert($arr, $this->tabelaVinculo);
	}

	public function desvinculaAnswerFromCard(){return $this->ApiDB->delete($this->tabelaVinculo, $this->id);}

	public function getIdAnswer($palavra){return $this->ApiDB->getBy($this->tabela, $palavra, 'id', 'word')['registro'];}

	public function logarTentativa($idanswer=false)
	{
		$arr['dtanswer'] = Date('Y-m-d h:i:s');
		$arr['acerto'] = $this->acerto;
		$arr['idcard'] = $this->idcard;
		$arr['answer'] = $idanswer ? $idanswer : null;

		$this->move();

		return $this->ApiDB->insert($arr, $this->tabelaLog);
	}

	public function matchAnswer()
	{
		$respostas = $this->listBy();

		//Verifica se tem respostas, se não tem retorna
		if(empty($respostas['results']))
			return $respostas;

		//Pega a resposta e trata os espaços case
		$this->resposta = strtolower(trim($this->resposta));
		$respostas = arrayToLower(array_column($respostas['results'], 'word'));

		//Trata retorno da mensagem
		$this->acerto = in_array($this->resposta, $respostas);

		$this->logarTentativa($this->resposta);

		// Move o card para o proximo nivel do container
		$this->move();

		return returnMessage($this->acerto,
			$this->acerto ? 'Parabéns! Você acertou.' : 'Que pena! Você Errou.',
			'returnTry',
			'',
			array('acerto' => $this->acerto),
			true);
	}

	public function move()
	{
		$obj = (object) array('id' => $this->idcontainer, 'idcard' => $this->idcard, 'acerto' => $this->acerto);
		$container = new Containers($obj);
		$container->moveCardToContainer();
	}
}
