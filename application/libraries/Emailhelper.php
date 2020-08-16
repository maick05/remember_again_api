<?php
class Emailhelper
{
	public static function send($para, $assunto='', $msg='')
	{
		$CI =& get_instance();
		$senderName = $CI->config->item('senderName');
		$senderEmail = $CI->config->item('senderEmail');

		$CI->load->library('email');

		$CI->email->from($senderEmail, $senderName);
		$CI->email->to($para);

		$CI->email->subject($assunto);
		$CI->email->message($msg);

		return $CI->email->send();
	}
}
?>
