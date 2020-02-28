<?php
session_start();

include_once "../config/database.php";

try {
	$DB = explode( ';', $dsn );
	$database = substr( $DB[ 1 ], 7 );
	$db = new PDO( "$DB[0]", $db_username, $db_password );
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$stmt = $db->prepare( 'SELECT admin FROM Camagru.users WHERE login = :log' );
	$stmt->bindParam( ':log', $_SESSION[ 'login' ], PDO::PARAM_STR );
	$stmt->execute();
} catch ( PDOException $error ) {
	echo 'Error: ' . $error->getMessage();
	exit;
}
$admin = $stmt->fetchColumn();
?>  
<html>
	<head>
		<title>Camagru</title>
		<link rel='stylesheet' type='text/css' href='../resources/style.css'>
	</head>
	<body>
<?php if($_SESSION[ 'login' ] && $_SESSION[ 'login' ] != "") : ?>
	<div class='logo'><h4>CAMAGRU</h4></div>
	<li><a href="..\backend\logout.php">Logout</a></li>
	<ul class='nav-links'>
        <?php if($admin == 1) : ?>
		<li><a href="admin.php">Admin</a></li>
        <?php endif; ?>
	<li><a href="editor.php">Editor</a><li>
	</ul>
    <div class='burger'>
	   <div class='line1'></div>
	   <div class='line2'></div>
	   <div class='line3'></div>
	</div>
<?php else : ?>
    <div class='logo'><h4>CAMAGRU</h4></div>
    <ul class='nav-links'>
	   <li><a href="login_form.php">Login</a></li>
	   <li><a href="registration_form.php">Register</a></li>
    </ul>
    <div class='burger'>
	   <div class='line1'></div>
	   <div class='line2'></div>
	   <div class='line3'></div>
	</div>
<?php endif; ?>
    </body>
</html>