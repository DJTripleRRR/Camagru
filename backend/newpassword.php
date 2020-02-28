<?php

if (empty($_POST['mdp']) || empty($_POST['remdp']) || empty($_POST['email'])) {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please fill in the password and email fields.');
    window.location.href='../view/newpassword.php';
    </script>" );
} else if (strlen($_POST['mdp']) < 8) {
	echo("<script LANGUAGE='JavaScript'>
    window.alert('Password must be longer than 7 characters.');
    window.location.href='../view/newpassword.php';
    </script>");
} else if ($_POST['mdp'] != $_POST['remdp' ] ) {
	echo("<script LANGUAGE='JavaScript'>
    window.alert('Passwords do not match.');
    window.location.href='../view/registration_form.php';
    </script>");
}

try {
	include_once '../config/database.php';
include_once 'escape.php';
	$email = esc::str($_POST['email']);
	$db = new PDO( "$DB[0]", $db_username, $db_password );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$stmt = $db->prepare('SELECT COUNT(*) FROM Camagru.users WHERE email = :email');
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $error) {
	echo "Error : ".$error->getMessage();
	exit;
}
$passwd = hash('whirlpool', esc::str($_POST['mdp']));
if ($stmt->fetchColumn()) {
	try {
		$stmt = $db->prepare("UPDATE Camagru.users SET passwd = :passwd WHERE email = :email");
		$stmt->bindParam(':passwd', $passwd, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
	} catch (PDOException $msg) {
		echo "Error : ".$msg->getMessage();
		exit;
	}
	echo("<script LANGUAGE='JavaScript'>
    window.alert('Your password has been successfully changed.');
    window.location.href='../index.php';
    </script>");
}

?>