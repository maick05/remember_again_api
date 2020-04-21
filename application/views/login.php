<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script src="assets/js/pages/login.js?n=1"></script>
</header>
<!DOCTYPE html>
<div class="ui middle aligned center aligned grid" style="height: 100%">
	<div class="ui column centered grid ui segment mob-div" style="max-width:550px;">
		<div class="column ui active inverted dimmer">
			<form class="ui form " style="display: " method="POST" action="logar">
				<div class="field">
					<label>Login:</label>
					<input type="text" name="login" placeholder="Login" id="login" data-validate="login" maxlength="40" required>
				</div>
				<div class="field">
					<label>Senha:</label>
					<input type="password" name="password" id="password" placeholder="Senha" maxlength="20" required>
				</div>
				<button class="ui primary button" type="submit" id="btn-login">Login</button>
				<div class="ui error message"></div>
				<div class="ui warning message" style="">
					<div class="header"></div>
					<span class="txtMessage"></span>
				</div>
			</form>
			<div class="ui large text loader disabled">Loading</div>
		</div>
	</div>
</div>
