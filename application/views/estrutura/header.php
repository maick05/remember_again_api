
<!DOCTYPE html>
<html lang="en"> 
<head>
	<meta charset="utf-8">
	<title>Wikispace</title>
	<?php $this->load->view('estrutura/headerFramework');?>
	<link rel="stylesheet" href="<?=base_url() ?>assets/css/estilo.css?<?=filemtime('assets/css/estilo.css');?>" media="screen" type="text/css">
	<?php import('assets/js/script.js', 'js', false); ?>
	<meta name="viewport" content="width=device-width, user-scalable=no">


</head>
	<body style="background: url('https://farm4.static.flickr.com/3738/9468424070_1eb9cf02a1_b.jpg');background-size: cover;background-position: 20% 50%;">

	<?php $this->load->view('estrutura/modals');?>
