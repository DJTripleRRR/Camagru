<?php

include_once('header.php');
if ($_GET['msg']) {echo("<script LANGUAGE='JavaScript'>
    window.alert(\"".htmlentities($_GET['msg'])."\");
    window.location.href='newpassword.php';
    </script>");}

?>

<html>
<section class="overlay" id="overlay">
	<div class="form">
		<div class="form-inner">
			<div class="form-content">
                <h1>Create New Password</h1>
			<form action="../backend/newpassword.php" method="post">
				<label for="email">Email address:</label><br>
						<input type="email" name="email"/><br/>
				<label for="mdp">Password:</label><br>
						<input type="password" name="mdp"/><br/>
				<label for="remdp">Confirm password:</label><br>
						<input type="password" name="remdp"/><br/>
				<input class="submit" type="submit" name="check"/><br/>
                <a href = "../index.php">Return to homepage</a>
			</form>
		</div>
		</div>
	</div>
</section>
    </html>