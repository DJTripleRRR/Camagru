<?php
include_once '../config/database.php';
include_once 'escape.php';
try {
	$email = esc::str($_GET['email']);
	$DB = explode( ';', $dsn );
	$database = substr( $DB[ 1 ], 7 );
	$db = new PDO( "$DB[0]", $db_username, $db_password );
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$stmt = $db->prepare('SELECT COUNT(*) FROM Camagru.users WHERE email = :email AND hash = :hash');
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->bindParam(':hash', $_GET['hash'], PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $error) {
	echo "Error : ".$error->getMessage();
	exit;
}
if ($stmt->fetchColumn()) {
	try {
		$stmt = $db->prepare("UPDATE Camagru.users SET active = '1' WHERE email = :email AND hash = :hash");
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':hash', $_GET[hash], PDO::PARAM_STR);
		$stmt->execute();
	} catch (PDOException $error) {
		echo "Error : ".$error->getMessage();
		exit;
	}
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Account has been activated successfully. We hope you enjoy using our service');
    window.location.href='../view/gallery.php';
    </script>" );
} else {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Account activation was not successful please try again.');
    window.location.href='../index.php';
    </script>" );
}
?>
	</body>
</html>