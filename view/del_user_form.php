<?php

session_start();

include_once('../backend/database.php');
try {
	$DB = explode( ';', $dsn );
	$database = substr( $DB[ 1 ], 7 );
	$db = new PDO( "$DB[0]", $db_username, $db_password );
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $db->prepare('SELECT admin FROM Camagru.users WHERE login = :log');
	$stmt->bindParam(':log', $_SESSION['login'], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $error) {
	echo 'Error: '.$error->getMessage();
	exit;
}
$admin = $stmt->fetchColumn();

if ($admin == 1) {
	include_once('header.php');
} else {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('You do not have the correct admin rights to access this page.');
    window.location.href='../index.php';
    </script>" );
}

?>

<html>
<section class="overlay" id="overlay">
	<div class="form">
		<div class="form-inner">
			<div class="form-content">
				<h1>Delete Account</h1>
                <p>Are you sure you want to go? We can't stop you.</p>
                <p>Please confirm your username and password to delete your account.</p>
				<form action="../backend/login.php" method="post">
						<label for="login">Username:</label><br>
						<input type="text" name="login" placeholder='Enter username:'/><br/>
						<label for="passwd">Password:</label><br>
						<input type="password" name="passwd" placeholder='Enter password:'/><br/>
						<input class="submit" type="submit" name="../backend/del_user.php"/><br/>
				</form>
			</div>
		</div>
	</div>
</section>
</html>
