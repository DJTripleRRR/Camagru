<?php
include_once( 'header.php' );
?>
<html>
<section class="overlay" id="overlay">
	<div class="form">
		<div class="form-inner">
			<div class="form-content">
				<h1>Registration</h1>
					<form action="../backend/create.php" method="post">
						<label for="email">Email address:</label><br>
						<input type="email" name="email"/><br/>
						<label for="login">Username:</label><br>
						<input type="text" name="login"/><br/>
						<label for="mdp">Password:</label><br>
						<input type="password" name="mdp"/><br/>
						<label for="remdp">Confirm password:</label><br>
						<input type="password" name="remdp"/><br/>
						<input class="submit" type="submit" name="check"/><br/>
					</form>
			</div>
		</div>
	</div>
</section>
    </html>