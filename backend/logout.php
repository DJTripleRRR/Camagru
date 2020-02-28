<?php
	session_start();
	session_destroy();
	 echo( "<script LANGUAGE='JavaScript'>
    window.alert('Logged out successfully.');
    window.location.href='../index.php';
    </script>" );
?>