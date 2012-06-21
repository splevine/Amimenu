<?php
require('config.php'); 
$email = $_REQUEST['email'];
$token = $_REQUEST['token'];

$db = new PDO($dsn, $username, $password);
$sql = "DELETE FROM jos_gmapfp WHERE email = '$email' AND token = '$token';";

$rs = $db->query($sql);
$count = $rs->rowCount();
echo $count;
$db = NULL;
?>