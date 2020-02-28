<?php
include_once '../backend/escape.php';

if ($_GET['error']) {echo( "<script LANGUAGE='JavaScript'>
window.alert(\"".htmlentities($_GET['msg'])."\");
    window.location.href='gallery.php';</script>");}
session_start();

if ($_SESSION['login']) {
	if (!$_GET['page']) {
		header('Location: gallery.php?page=1');
	}
	include_once 'header.php';
} else {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Guest user.');
    window.location.href='../index.php';
    </script>" );
}
$page = esc::str(intval($_GET['page']));
if (strlen($page) > 10) {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Guest user.');
    window.location.href='gallery.php';
     </script>" );
	exit;
}
include_once '../backend/database.php';

$nb = ($page - 1) * 10;
try {
	$db = new PDO( "$DB[0]", $db_username, $db_password );
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$stmt = $db->prepare( 'SELECT * FROM Camagru.gallery ORDER BY id DESC LIMIT 10 OFFSET :nb' );
		$stmt->bindParam( ':login', $log, PDO::PARAM_STR );
		$stmt->execute();
	} catch ( PDOException $error ) {
		echo 'Error: ' . $error->getMessage();
		exit;
}

$sql = $stmt->fetchAll();
if (!$sql) {
	if ($page > 1 AND $page < 3) {
		$preview = $page - 1;
		header("Location: gallery.php?page=$prev");
		exit;
	} else {
		echo '<h4>There is no photos in the gallery. Be the first to post a picture!</h4>';
	}
}
echo "<center><ul class='pagination1'>";
try {
	$stmt = $db->prepare("SELECT COUNT(*) from gallery");
	$stmt->execute();
} catch (PDOException $error) {
	echo 'Error: '.$error->getMessage();
	exit;
}
$nb = ($stmt->fetchColumn() - 1) / 10 + 1;
$previous = $page - 1;
if ($previous > 0) {
	echo "<li><a href='?page=$previous'>&laquo;</a></li>";
}
for ($i = 1; $i <= $nb; ++$i) {
	echo "<li><a  href='?page=$i'>$i</a></li>";
}
$next = $page + 1;
if ($next < $nb) {
	echo "<li><a href='?page=$next'>&raquo;</a></li>";
}
echo "</ul></center>";

echo '<br/>';
echo "<div>";
foreach ($sql as $key => $value) {
	echo "<div class='boximg'>";
	try {
		$stmt = $db->prepare("SELECT COUNT(*) FROM Camagru.likes WHERE id_image = :id_img");
		$stmt->bindParam(':id_img', $value[id], PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $error) {
		echo 'Error: '.$error->getMessage();
		exit;
	}
	$likes = $stmt->fetchColumn();
	try {
		$stmt = $db->prepare("SELECT admin from Camagru.users WHERE login = :log");
		$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
		$stmt->execute();
	} catch (PDOException $error) {
		echo 'Error: '.$error->getMessage();
		exit;
	}
	$admin = $stmt->fetchColumn();
	if ($value[login] == $_SESSION[login] || $admin == 1) {
		echo "<a href='remove.php?img=$value[id]&page=$page'><img src='images/trash.png' width='30' style='position:absolute'></a>";
	}
	echo "<img src='$value[img]' style='width:400px'><br/>
		User : <i>$value[login]<br/></i>
		Likes : $jaime";
		try {
			$stmt = $db->prepare('SELECT COUNT(*) FROM Camagru.likes WHERE login = :log AND id_image = :id_img');
			$stmt->bindParam(':log', $_SESSION[login], PDO::PARAM_STR);
			$stmt->bindParam(':id_img', $value[id], PDO::PARAM_INT);
			$stmt->execute();
		} catch (PDOException $error) {
			echo 'Error: '.$error->getMessage();
			exit;
		} if ($stmt->fetchColumn()) {	
			echo "<a href='like.php?id_image=$value[id]&page=$page' style='float:right;margin-top:-20px'>
					<img src='../resources/images/unlike.png' width='30' height='30' style='margin-top:10px'>
				</a>";
		} else {
			echo "<a href='like.php?id_image=$value[id]&page=$page' style='float:right;margin-top:-20px'>
					<img src='../resources/images/like.png' width='30' height='30' style='margin-top:10px'>
				</a>";
		}
	echo "<form class='com' action='comment.php?id_image=$value[id]&page=$page' method='post'><br/>
			<input class='comform' style='width:100%' type='text' placeholder='Comment' name='comm' required>
			<input class='submit' type='submit' name='Validate'/>
		</form>"; 

	try {
		$stmt = $db->prepare("SELECT * FROM Camagru.comments WHERE id_image = :id_img");
		$stmt->bindParam(':id_img', $value[id], PDO::PARAM_INT);
		$stmt->execute();
	} catch (PDOException $error) {
		echo 'Error: '.$error->getMessage();
		exit;
	}
	$sql = $stmt->fetchAll();
	if ($sql) {
		echo "<div class='comment'>";
		foreach ($sql as $key => $var) {
			echo "by <i>$var[login]</i> : $var[comment] <hr>";
		}
		echo '</div>';
	}
	echo '</div>';
}
echo "</div>";

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>