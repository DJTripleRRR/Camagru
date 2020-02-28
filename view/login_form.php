<?php
include_once( 'header.php' );
?>

<html>
<section class="overlay" id="overlay">
	<div class="form">
		<div class="form-inner">
			<div class="form-content">
				<h1>Login</h1>
				<form action="../backend/login.php" method="post">
						<label for="login">Username:</label><br>
						<input type="text" name="login" placeholder='Enter username:'/><br/>
						<label for="passwd">Password:</label><br>
						<input type="password" name="passwd" placeholder='Enter password:'/><br/>
						<a href='forgot_password.php'>Forgot your password?</a><br/>
						<input class="submit" type="submit" name="../backend/login.php"/><br/>
				</form>
			</div>
		</div>
	</div>
</section>
</html>