<?php
require('config.php'); 

$restarantid = $_GET["restaurantid"];
$db = new PDO($dsn, $username, $password);
//$sql = "SELECT id, nom, intro, ville,tel, glat, glng FROM jos_gmapfp;";
 $sql = "select * from jos_gmapfp where id='$restarantid' and published=1;";

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