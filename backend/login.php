<?php
session_start();
include_once 'database.php';
include_once 'escape.php';
if ( empty( $_POST['login'] ) || empty( $_POST['passwd'] ) ) {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please fill in the password and username fields.');
    window.location.href='../view/login_form.php';
    </script>" );
	exit();
} else {
	try {
		$log = esc::str( $_POST['login'] );
		$db = new PDO( "$DB[0]", $db_username, $db_password );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$stmt = $db->prepare( 'SELECT COUNT(*) FROM Camagru.users WHERE login = :login' );
		$stmt->bindParam( ':login', $log, PDO::PARAM_STR );
		$stmt->execute();
	} catch ( PDOException $error ) {
		echo 'Error :' . $error->getMessage();
	}
	if ( $user = $stmt->fetchColumn() ) {
		try {
			$passwd = hash( 'whirlpool', esc::str( $_POST[ 'passwd' ] ) );
			$stmt = $db->prepare( 'SELECT COUNT(*) FROM Camagru.users WHERE passwd = :passwd AND login = :login' );
			$stmt->bindParam( ':login', $log, PDO::PARAM_STR );
			$stmt->bindParam( ':passwd', $passwd, PDO::PARAM_STR );
			$stmt->execute();
		} catch ( PDOException $error ) {
			echo 'Error :' . $error->getMessage();
		}
		if ( $stmt->fetchColumn() ) {
			try {
				$stmt = $db->prepare( "SELECT COUNT(*) FROM Camagru.users WHERE passwd = :passwd AND login = :login AND active = '1'" );
				$stmt->bindParam( ':login', $log, PDO::PARAM_STR );
				$stmt->bindParam( ':passwd', $passwd, PDO::PARAM_STR );
				$stmt->execute();
			} catch ( PDOException $error ) {
				echo 'Error :' . $error->getMessage();
			}
			if ( $stmt->fetchColumn() ) {
				$_SESSION[ 'login' ] = $log;
				echo( "<script LANGUAGE='JavaScript'>
    window.alert('Welcome back!');
    window.location.href='../view/gallery.php';
    </script>" );
				exit();
			} else {
				echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please activate account.');
    window.location.href='../view/login_form.php';
    </script>" );
			}
		} else {
			echo( "<script LANGUAGE='JavaScript'>
    window.alert('Incorrect password.');
    window.location.href='../view/login_form.php';
    </script>" );
			exit();
		}
		echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please try again.');
    window.location.href='../view/login-form.php';
    </script>" );
		exit();
	}
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please try again.');
    window.location.href='../view/login_form.php';
    </script>" );
	exit();
}
?>