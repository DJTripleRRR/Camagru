<?php

include_once 'database.php';

try {
	$DB = explode( ';', $dsn );
	$database = substr( $DB[ 1 ], 7 );
	$db = new PDO( "$DB[0]", $db_username, $db_password );
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$db->exec( "CREATE DATABASE IF NOT EXISTS $database" );
	echo "Database '$database' created successfully.<br>";
	$db->exec( "use $database" );
	$db->exec("CREATE TABLE IF NOT EXISTS users (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		email VARCHAR(255) NOT NULL,
		login VARCHAR(255) NOT NULL,
		passwd VARCHAR(255) NOT NULL,
		hash VARCHAR(255) NOT NULL,
		admin INT(9) DEFAULT 0,
		active INT(9) DEFAULT 0)");
	echo "Table 'users' created successfully.<br>";
} catch ( PDOException $error ) {
	echo "<br>Connection failed:" . $sql . '<br>' . $error->getMessage();
}
//$db->exec("CREATE TABLE IF NOT EXISTS gallery (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//	login VARCHAR(255) NOT NULL,
//	img VARCHAR(255) NOT NULL)");
//echo "Table 'gallery' created successfully.<br>";
//$db->exec("CREATE TABLE IF NOT EXISTS commentaire (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//	login VARCHAR(255) NOT NULL,
//	id_image VARCHAR(255) NOT NULL,
//	comment VARCHAR(255) NOT NULL)");
//echo "Table 'commentaire' created successfully.<br>";
//$db->exec("CREATE TABLE IF NOT EXISTS jaime (id INT(9) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
//	login VARCHAR(255) NOT NULL,
//	id_image VARCHAR(255) NOT NULL)");
//echo "Table 'jaime' created successfully.<br><br><br>";
try {
	/* $mail = 'djtriplerrr@gmail.com';
	$name = 'DJTripleRRR';
	$pass = 'd3068f59aa0148fbe5b930dfb4f31db1311f4f0c2b652e3d0e6907f2fd28b140f2cc9ca802cede3bd5608fd1296328e4a7cc5314849ed0c9d09dcc3e80f557fd';
	$hash = 'ba2fd310dcaa8781a9a652a31baf3c68';
	$one = 1;
	$zero = 0;
	$stmt = $db->prepare( 'INSERT INTO users (id, email, username, passwrd, hash, admin, active) VALUES (NULL, :email, :login, :passwrd, :hash, :admin, :active)' );
	$stmt->bindParam( ':email', $mail, PDO::PARAM_STR );
	$stmt->bindParam( ':username', $name, PDO::PARAM_STR );
	$stmt->bindParam( ':passwrd', $pass, PDO::PARAM_STR );
	$stmt->bindParam( ':hash', $hash, PDO::PARAM_STR );
	$stmt->bindParam( ':admin', $one, PDO::PARAM_STR );
	$stmt->bindParam( ':active', $one, PDO::PARAM_STR );
	$stmt->execute();
	$stmt = $db->prepare( 'INSERT INTO users (id, email, username, passwrd, hash, admin, active) VALUES (NULL, :email, :login, :passwrd, :hash, :admin, :active)' );
	$mail = 'ryanfucquasmith@gmail.com';
	$name = 'ryanfucquasmith';
	$pass = 'cc8c74dc072e25db099cb60bc8683657736bc95f65f6a0164d52aae721c9367bdf06dfa8844107a815ab3e4c21c08bda71aaa7382a781696ece90d3e0ecae460';
	$hash = 'd14220ee66aeec73c49038385428ec4c';
	$stmt->bindParam( ':email', $mail, PDO::PARAM_STR );
	$stmt->bindParam( ':username', $name, PDO::PARAM_STR );
	$stmt->bindParam( ':passrwd', $pass, PDO::PARAM_STR );
	$stmt->bindParam( ':hash', $hash, PDO::PARAM_STR );
	$stmt->bindParam( ':admin', $zero, PDO::PARAM_STR );
	$stmt->bindParam( ':active', $one, PDO::PARAM_STR );
	$stmt->execute();
	$stmt = $db->prepare( 'INSERT INTO users (id, email, username, passwrd, hash, admin, active) VALUES (NULL, :email, :login, :passwrd, :hash, :admin, :active)' );
	$mail = 'rysmith@student.wethinkcode.co.za';
	$name = 'rysmith';
	$pass = 'd3068f59aa0148fbe5b930dfb4f31db1311f4f0c2b652e3d0e6907f2fd28b140f2cc9ca802cede3bd5608fd1296328e4a7cc5314849ed0c9d09dcc3e80f557fd';
	$hash = '210194c475687be6106a3b84';
	$stmt->bindParam( ':email', $mail, PDO::PARAM_STR );
	$stmt->bindParam( ':username', $name, PDO::PARAM_STR );
	$stmt->bindParam( ':passwrd', $pass, PDO::PARAM_STR );
	$stmt->bindParam( ':hash', $hash, PDO::PARAM_STR );
	$stmt->bindParam( ':admin', $zero, PDO::PARAM_STR );
	$stmt->bindParam( ':active', $one, PDO::PARAM_STR );
	$stmt->execute();
	echo "Table 'users' filled.<br>"; */
	$mail = 'djtriplerrr@gmail.com';
	$name = 'djtriplerrr';
	$pass = 'c1f85fcc7d37d583c41d957cf7792a9e13807d294ca7d095729ce0eb283bb6ae305ac136e6dd227ecec58483a981cb455bee59473a758ceccbd68e20dacc3ad4';
	$hash = 'fa3a3c407f82377f55c19c5d403335c7';
	$one = 1;
	$zero = 0;
	$stmt = $db->prepare('INSERT INTO users (email, login, passwd, hash, admin, active) VALUES (:email, :login, :passwd, :hash, :admin, :active)');
	$stmt->bindParam(':email', $mail, PDO::PARAM_STR);
	$stmt->bindParam(':login', $name, PDO::PARAM_STR);
	$stmt->bindParam(':passwd', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
	$stmt->bindParam(':admin', $one, PDO::PARAM_STR);
	$stmt->bindParam(':active', $one, PDO::PARAM_STR);
	$stmt->execute();
	$stmt = $db->prepare('INSERT INTO users (email, login, passwd, hash, admin, active) VALUES (:email, :login, :passwd, :hash, :admin, :active)');
	$mail = 'rysmith@student.wethinkcode.co.za';
	$name = 'rysmith';
	$pass = 'c1f85fcc7d37d583c41d957cf7792a9e13807d294ca7d095729ce0eb283bb6ae305ac136e6dd227ecec58483a981cb455bee59473a758ceccbd68e20dacc3ad4';
	$hash = '2bcab9d935d219641434683dd9d18a03';
	$stmt->bindParam(':email', $mail, PDO::PARAM_STR);
	$stmt->bindParam(':login', $name, PDO::PARAM_STR);
	$stmt->bindParam(':passwd', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
	$stmt->bindParam(':admin', $zero, PDO::PARAM_STR);
	$stmt->bindParam(':active', $one, PDO::PARAM_STR);
	$stmt->execute();
	$stmt = $db->prepare('INSERT INTO users (email, login, passwd, hash, admin, active) VALUES (:email, :login, :passwd, :hash, :admin, :active)');
	$mail = 'ryanfucquasmith@gmail.com';
	$name = 'ryanfucquasmith';
	$pass = 'c1f85fcc7d37d583c41d957cf7792a9e13807d294ca7d095729ce0eb283bb6ae305ac136e6dd227ecec58483a981cb455bee59473a758ceccbd68e20dacc3ad4';
	$hash = 'e07413354875be01a996dc560274708e';
	$stmt->bindParam(':email', $mail, PDO::PARAM_STR);
	$stmt->bindParam(':login', $name, PDO::PARAM_STR);
	$stmt->bindParam(':passwd', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
	$stmt->bindParam(':admin', $zero, PDO::PARAM_STR);
	$stmt->bindParam(':active', $one, PDO::PARAM_STR);
	$stmt->execute();
	echo "Initial users added to table.<br>";
} catch ( PDOException $e ) {
	echo "<br>Initial user creation failed:" . $sql . '<br>' . $e->getMessage();
}
$db = null;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Camagru</title>
</head>

<body>
	<form action="../index.php" class="inline">
		<button autofocus="autofocus" tabindex="1">Index</button>
	</form>
</body>
</html>