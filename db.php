<?php
header('charset:utf-8');
$mysql_hostname = "localhost.com";
$mysql_user = "XXXXXXX";
$mysql_password = "XXXXXXX";
$mysql_database = "XXXXXXX";
$prefix = "";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");

?>