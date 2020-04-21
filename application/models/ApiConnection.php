<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiConnection extends CI_Model
{
	public function connect($url, $post=false)
	{
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		if($post) {
			curl_setopt($ch, CURLOPT_POST, true);
//			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		}

		curl_setopt( $ch, CURLOPT_HEADER, true );
		$retorno['response'] = curl_exec( $ch );
		$retorno['status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$retorno['info'] = curl_getinfo($ch);

		curl_close( $ch );
		return $retorno;
	}
}
