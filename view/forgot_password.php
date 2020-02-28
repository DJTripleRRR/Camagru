<?php

include_once('header.php');

?>

<html>
<section class="overlay" id="overlay">
	<div class="form">
		<div class="form-inner">
			<div class="form-content">
                <h1>Forgot Password</h1>
	<form action="../backend/forgot.php" method="post">
		<label for="email">Email address:</label><br>
        <input type="email" name="email"/><br/>
		<input class="submit" type="submit" name="check"/><br/>
	</form>
</html>
