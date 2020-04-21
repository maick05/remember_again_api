<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$frameworkUrl = $this->config->item('header_framework');

import('assets/js/pages/forca.js', 'js', false);
import('assets/js/conversoes.js', 'js', false);

$action = 'db/save';
$action = $this->config->item('hostFixo').$action;

?>

<br>
	<?php if(isset($_SESSION['mensagem'])): ?>
		<div class="mensagem" style="width: 70%; margin: auto;">
			<div class="ui <?=$_SESSION['mensagem']['status']?> message">
				<i class="close icon"></i>
				<div class="header">
					<?=$_SESSION['mensagem']['texto']?>
				</div>
				<p></p>
			</div>
			<br>
		</div>
	<?php
		unset($_SESSION['mensagem']);
		endif;
	?>

	<div style="width: 70%; margin: auto; margin-top: -45px; background: transparent; padding: 20px; border-radius: 9px;">
		<h2 class="ui dividing header" style="height: 700px">
		<form id="form" class="ui form" action="<?=''?>" method="POST">

			<div style="overflow: auto; height: 100%; text-align: center">
				<div class="ui cards guess-word" style="max-width: max-content; margin: auto;">

				</div>
				<div class="ui massive label palavra" style="width: 80%; border-radius: 9px; border:2px solid black">

				</div>
				<br>
				<div class="ui medium image" style="margin-top: 10px">
					<img src="assets/img/forca/forca-1.jpg" data-etapa="1">
				</div>
				<br>
				<div class="teclado" style="margin-top: 20px">
					<div class="ui cards" style="max-width: max-content; margin: auto;">
						<?=$teclado?>
					</div>
				</div>
			</div>
		</form>
	</div>
	<br>
</div>
