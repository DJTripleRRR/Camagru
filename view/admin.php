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
				<h1>Admin</h1>
		<ul>
			<li><a href="del_user_form.php">Delete Account</a></li>
			<li><a href="change_login_form.php">Change Username</a></li>
			<li><a href="change_mail_form.php">Change Email</a></li>
		</ul>
            </div>
		</div>
	</div>
</section>
</html>

