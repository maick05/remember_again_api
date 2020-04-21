<?php header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS'); 
header('Access-Control-Allow-Headers: X-Requested-With, content-type, X-Token, x-token');?>

<?php $frameworkUrl = $this->config->item('header_framework'); ?>

<!DOCTYPE html>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=$frameworkUrl?>/semantic/dist/semantic.min.css">
	<!-- <link rel="stylesheet" href="<?=$frameworkUrl?>/font/css/all.css" type="text/css"> -->
	<script src="<?=$frameworkUrl?>/js/jquery.min.js"></script>
	<script src="<?=$frameworkUrl?>/semantic/dist/semantic.min.js"></script>
	<script defer src="<?=$frameworkUrl?>/complementos/template/jquery.tmpl.min.js"></script>
	<script defer src="<?=$frameworkUrl?>/font/js/all.js"></script>
	<!-- <script defer src="<?=$frameworkUrl?>/js/helpers/loader.js?n=1"></script> -->
	<!-- <script defer src="<?=$frameworkUrl?>/js/helpers/message.js?n=1"></script> -->
	<script defer src="<?=$frameworkUrl?>/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<script defer src="<?=$frameworkUrl?>/js/helpers/swal.js"></script>
<script defer src="<?=$frameworkUrl?>/semantic/ready.js"></script>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CodeSky</title>
	<link rel="stylesheet" type="text/css" href="http://www.codesky.com.br/framework/semantic/dist/semantic.min.css">
	<link rel="stylesheet" href="http://www.codesky.com.br/framework/font/css/all.css" type="text/css">
	<link rel="stylesheet" href="assets/css/estilo.css" media="screen" type="text/css">
	<script src="http://www.codesky.com.br/framework/js/jquery.min.js"></script>
	<script src="http://www.codesky.com.br/framework/semantic/dist/semantic.min.js"></script>
	<script defer src="http://www.codesky.com.br/framework/font/js/all.js"></script>
	<script defer src="http://www.codesky.com.br/framework/js/helpers/loader.js"></script>
	<script defer src="http://www.codesky.com.br/framework/js/helpers/message.js"></script>
	<script defer src="http://www.codesky.com.br/framework/node_modules/sweetalert/dist/sweetalert.min.js"></script>
	<script defer src="http://www.codesky.com.br/framework/js/helpers/swal.js"></script>
	<meta name="viewport" content="width=device-width, user-scalable=no"> -->
