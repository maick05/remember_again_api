<?php

function pre($p, $die=true){
	echo "<pre>";
	print_r($p);
	echo "</pre>";
//	echo "<script>$('#loading').addClass('hide');</script>";
	if($die)
		die;
}

function enc($p){
	$arr['mensagem'] = $p;
	echo json_encode($arr);
	die;
}

function import($url, $type, $filemtype=true)
{
	if($filemtype)
		echo 1;
	else
		echo "<script src='".base_url().$url."'></script>";
}

function array_null($array)
{
	return array_map(function($value) {
		return $value === "" ? NULL : $value;
	}, $array);
}

function validaObj($obj)
{
	$obj = array_filter((array) $obj);
	return !empty($obj) && $obj && $obj != null;
}

function setError($cond, $msg, &$erro='S')
{
	if($cond)
		return null;

	$_SESSION['mensagem']['status'] = 'error';
	$_SESSION['mensagem']['texto'] = $msg;
	$erro = 'S';
	return $msg;
}

function returnMessage($success, $message, $key, $type, $arrAdicional=array(), $validarSucess=false)
{
	$retorno = $arrAdicional;
	$retorno['sucesso'] = $success;
	$retorno['mensagem'] = $message;
	$retorno['key'] = $key;
	if($validarSucess)
		$type = $success ? 'success' : 'danger';
	$retorno['type'] = $type;
	return $retorno;
}

function doesMatch($op, $campo, $val)
{
	switch ($op)
	{
		case preg_match('/(>)(<)/', $op) == 1:
			if(!$val)
				return false;
			break;
		case '=':
			return $campo == $val;
			break;
		case '!=':
			return $campo !== $val;
			break;
		case '>':
			return $campo > intval($val);
			break;
		case '>=':
			return $campo >= intval($val);
			break;
		case '<=':
			return $campo <= intval($val);
			break;
		case '<':
			return $campo < intval($val);
			break;
		case 'in':
			return in_array($campo, explode(',', $val));
			break;
		case 'not in':
			return !in_array($campo, explode(',', $val));
			break;
		case 'not null':
			return trim($campo);
			break;
		case 'is null':
			return !$campo;
		default:
			return false;
			break;
	}
}

function arrayToLower($arr){return array_combine(array_map('strtolower', $arr), $arr);}

function arrayTrim($arr){
	$newArray = array();
	foreach ($arr as $key => $value){
		$newArray[trim($key)] = trim($value);
	}
	return $newArray;
}

function array_shift_key(&$arr){
	$firstKey = current(array_keys($arr));
	$firstElement = $arr[$firstKey];
	unset($arr[$firstKey]);
	return array($firstKey => $firstElement);
}

function generateRandomString($length = 50) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
