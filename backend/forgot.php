<?php

include_once 'database.php';
include_once 'escape.php';

if (empty($_POST['email'])) {
	echo( "<script LANGUAGE='JavaScript'>
    window.alert('Please provide the email you used on signup.');
    window.location.href='../view/forgot_password.php';
    </script>");
}

try {
	$email = esc::str($_POST['email']);
	$db = new PDO( "$DB[0]", $db_username, $db_password );
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$stmt = $db->prepare('SELECT * FROM Camagru.users WHERE email = :email');
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	$stmt->execute();
} catch (PDOException $error) {
	echo 'Error :'.$error->getMessage();
}
if ($stmt->fetchColumn()) {
	try {
		$newpass = rand(5, 4000000);
		$stmt = $db->prepare('UPDATE Camagru.users SET passwd = :passwd WHERE email = :email');
		$stmt->bindParam(':passwd', $newpass, PDO::PARAM_STR);
		$stmt->bindParam('email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$to = $email;
		$subject = 'Camagru - New Password';
		$message = '
        Hello from the Camagru team! You requested a new password, please follow the link below to reset your password.
        http://localhost:8888/Camagru/view/newpass_form.php?email='.$email.'&hash='.$newpass.'
	';
		$headers = 'From:rysmith@wethinkcode.co.za' . "\r\n";
		$emailsent = mail($to, $subject, $message, $headers);
        if( $emailsent == true ) {
            echo( "<script LANGUAGE='JavaScript'>
    window.alert('A new password has been created, please check your email for further instructions.');
    window.location.href='../index.php';
    </script>" );
         }else {
        $errorMessage = error_get_last()['message'];
            echo( "<script LANGUAGE='JavaScript'>
    window.alert('An error occured and the email could not be sent. Please try again');
    </script>" );
	}
    } 
    catch (PDOException $msg) {
		echo "Error : ".$msg->getMessage();	
		exit;
	}
}
?>
