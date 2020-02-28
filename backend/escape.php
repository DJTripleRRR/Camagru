<?php
	include_once('../config/database.php');
	$DB = explode( ';', $dsn );
	$database = substr( $DB[ 1 ], 7 );
	$db = new PDO( "$DB[0]", $db_username, $db_password );
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	class esc
	{
		public static function str($string)
		{
			if(ctype_digit($string))
				$string = intval($string);
			else
				$string = addcslashes($string, '%_');
			return $string;
		}
		public static function html($string)
		{
			return htmlentities($string);
		}
	}
?>