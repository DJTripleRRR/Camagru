<?php
include_once '../config/database.php';
include_once 'escape.php';
if (empty( $_POST['email'])) {
	echo("<script LANGUAGE='JavaScript'>
    window.alert('Please provide an email.');
    window.location.href='../view/registration_form.php';
    </script>");
	exit;
}
 else if (empty($_POST['login'])) {
	echo("<script LANGUAGE='JavaScript'>
    window.alert('Please provide a username.');
    window.location.href='../view/registration_form.php';
    </script>");
	exit;
}
 else if ( empty( $_POST['mdp'] ) ) {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please provide an password.');
    window.location.href='../view/registration_form.php';
    </script>");
	exit;
} else if (strlen($_POST['mdp']) < 8) {
	echo("<script LANGUAGE='JavaScript'>
    window.alert('Password must be longer than 7 characters.');
    window.location.href='../view/registration_form.php';
    </script>");
	exit;
} else if ($_POST['mdp'] != $_POST['remdp' ] ) {
	echo("<script LANGUAGE='JavaScript'>
    window.alert('Passwords do not match.');
    window.location.href='../view/registration_form.php';
    </script>");
	exit;
} else {
	try {
		$log = esc::str( $_POST['login'] );
		$db = new PDO( "$DB[0]", $db_username, $db_password );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$stmt = $db->prepare( 'SELECT COUNT(*) FROM Camagru.users WHERE login = :login' );
		$stmt->bindParam( ':login', $log, PDO::PARAM_STR );
		$stmt->execute();
	} catch ( PDOException $mess ) {
		echo 'Error: ' . $mess->getMessage();
		exit;
	}
	if ( $stmt->fetchColumn() ) {
		echo( "<script LANGUAGE='JavaScript'>
    window.alert('Username already in use.');
    window.location.href='../view/registration_form.php';
    </script>" );
		exit;
	}
	$passwd = hash( 'whirlpool', esc::str( $_POST['mdp'] ) );
	$hash = md5( rand( 0, 1000 ) );
	$email = esc::str( $_POST['email'] );
	try {
		$stmt = $db->prepare( 'INSERT INTO Camagru.users (email, login, passwd, hash) VALUES (:email, :login, :passwd, :hash)' );
		$stmt->bindParam( ':email', $email, PDO::PARAM_STR );
		$stmt->bindParam( ':login', $log, PDO::PARAM_STR );
		$stmt->bindParam( ':passwd', $passwd, PDO::PARAM_STR );
		$stmt->bindParam( ':hash', $hash, PDO::PARAM_STR );
		$stmt->execute();
	} catch ( PDOException $mess ) {
		echo 'Error: ' . $mess->getMessage();
		exit;
	}
	$to = $email;
	$subject = 'Camagru - Verification';
	$message = '
Thank you for signing up to Camagru, we look forward to having you use our service!
Once you have acitavated your account by using the link below you can login using your username and password.

	Username: ' . $log . '
    
	Please click this link to activate your account:
	http://localhost:8888/Camagru/backend/verify.php?email=' . $email . '&hash=' . $hash . '
	';
	$headers = 'From:rysmith@wethinkcode.co.za' . "\r\n";
	$emailsent = mail( $to, $subject, $message, $headers );
	$_SESSION['login'] = $log;
	if( $emailsent == true ) {
            echo( "<script LANGUAGE='JavaScript'>
    window.alert('Account was created successfully, please check your email to activate your account.');
    window.location.href='../index.php';
    </script>" );
         }else {
        $errorMessage = error_get_last()['message'];
            echo( "<script LANGUAGE='JavaScript'>
    window.alert('An error occured and the email could not be sent.');
    </script>" );
         }
}
?>