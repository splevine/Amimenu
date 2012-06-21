<?php
require('config.php'); 
$email = $_GET["email"];
$token = $_GET["token"];
$db = new PDO($dsn, $username, $password);
//$sql = "SELECT id, nom, intro, ville,tel, glat, glng FROM jos_gmapfp;";
 $sql = "SELECT * 
FROM jos_gmapfp
WHERE token =  '$token'
AND email =  '$email'";

$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo "An SQL error occured.\n".$restaurantid;
    exit;
}

$rows = array();
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $r;
}
print json_encode($rows);
$db = NULL;
?>