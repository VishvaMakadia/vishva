<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_vishva";


$conn = mysql_connect($db_host, $db_user, $db_password);

if(!$conn){
	echo "Error in connection";
}

$db = mysql_select_db($db_name);

if(!$db){
	echo "Error with database";
}
?>
