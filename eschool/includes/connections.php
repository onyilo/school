<?php
// connect to database
$connection = mysql_connect('localhost', 'root','');
if (!$connection){
	die('Database connection failed: ' . $mysql_error());
}

// Select database to use
$db_select = mysql_select_db('eschool', $connection);
if (!$db_select){
	die('Database selection failed: ' . $mysql_error());
}
?>