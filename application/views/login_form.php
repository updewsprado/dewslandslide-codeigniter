<div id="login_form">
	<h1>Login, User!</h1>
	<?php
	if (($this->session->userdata('first_name') != "" || is_null($this->session->userdata('first_name'))) && ($this->session->userdata('last_name') != "" || is_null($this->session->userdata('last_name')))) {
		header( "Location: /home" );
	} else {
		echo form_open('lin/validate_credentials');
		echo form_input('username', 'Username');
		echo form_password('password', 'Password');
		echo form_submit('submit', 'Login');
		//echo anchor('lin/signup', 'Create Account');
	}
	?>
</div>