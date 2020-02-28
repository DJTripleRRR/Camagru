<?php
session_start();
include_once 'database.php';
include_once 'escape.php';
if ( empty( $_POST['login'] ) || empty( $_POST['passwd'] ) ) {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please fill in the password and username fields.');
    window.location.href='../view/del_user_form.php';
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
	$stmt = $db->prepare('DELETE FROM Camagru.users WHERE login = :login');
	$stmt->bindParam(':login', $_POST[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $error) {
	echo 'Error: '.$error->getMessage();
	exit;
}
try {
	$stmt = $db->prepare('DELETE FROM Camagru.likes WHERE login = :login');
	$stmt->bindParam(':login', $_POST[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $error) {
	echo 'Error: '.$error->getMessage();
	exit;
}
try {
	$stmt = $db->prepare('DELETE FROM Camagru.comments WHERE login = :login');
	$stmt->bindParam(':login', $_POST[login], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $error) {
	echo 'Error: '.$error->getMessage();
	exit;
}
        } else {
			echo( "<script LANGUAGE='JavaScript'>
    window.alert('Incorrect password.');
    window.location.href='../view/login_form.php';
    </script>" );
			exit();
        }
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
                    <input type="text" name="login" placeholder='Enter username:' /><br />
                    <label for="passwd">Password:</label><br>
                    <input type="password" name="passwd" placeholder='Enter password:' /><br />
                    <a href='forgot_password.php'>Forgot your password?</a><br />
                    <input class="submit" type="submit" name="../backend/login.php" /><br />
                </form>
            </div>
        </div>
    </div>
</section>

</html>