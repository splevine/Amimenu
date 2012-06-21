<?php
require('config.php'); 
//trim($_POST['searching']);
//$query = htmlspecialchars($_GET["searching"]);
$query =$_GET['searching'];
$ville =$_GET['city'];
$state =$_GET['state'];
$country =$_GET['country'];


if($query){
$db = new PDO($dsn, $username, $password);
$sql = "SELECT id, nom,ville,pay,tel, glat, glng,intro,img FROM jos_gmapfp WHERE nom LIKE '%{$query}%' OR ville LIKE '%{$query}%' OR intro LIKE '%{$query}%' OR pay LIKE '%{$query}%' and published=1;";
$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo "An SQL error occured.\n";
    exit;
}

$rows = array();
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $r;
}
print json_encode($rows);
$db = NULL;
//Search City
}else if($ville){
$db = new PDO($dsn, $username, $password);
$sql = "SELECT id, nom,ville,pay,tel, glat, glng,intro,img FROM jos_gmapfp WHERE ville LIKE '%{$ville}%' and published=1;";
$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo "An SQL error occured.\n";
    exit;
}

$rows = array();
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $r;
}
print json_encode($rows);
$db = NULL;
//Search State
}else if($state){
$db = new PDO($dsn, $username, $password);
$sql = "SELECT id, nom,ville,pay,tel, glat, glng,intro,img FROM jos_gmapfp WHERE departement LIKE '%{$state}%' and published=1;";
$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo "An SQL error occured.\n";
    exit;
}

$rows = array();
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $r;
}
print json_encode($rows);
$db = NULL;

}
//Search Country
else if($country){
$db = new PDO($dsn, $username, $password);
$sql = "SELECT id, nom,ville,pay,tel, glat, glng,intro,img FROM jos_gmapfp WHERE pay LIKE '%{$country}%' and published=1;";
$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo "An SQL error occured.\n";
    exit;
}

$rows = array();
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $r;
}
print json_encode($rows);
$db = NULL;

}
else{

$db = new PDO($dsn, $username, $password);
$sql = "SELECT id, nom,ville,tel, glat, glng,intro,img FROM jos_gmapfp WHERE published=1 ORDER BY RAND() LIMIT 0,9;";
$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo "An SQL error occured.\n";
    exit;
}

$rows = array();
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $r;
}
print json_encode($rows);
$db = NULL;
}
?>