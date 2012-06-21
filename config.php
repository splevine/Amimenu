<?php 
$callback = $_REQUEST['callback'];
$detailid = $_REQUEST['detailid'];
$code = $_REQUEST['code'];
$phonerest = $_REQUEST['phonerest'];
if ($callback) {
header('Content-Type: application/x-json');
}else if ($detailid) {

}else if ($code) {

}else if ($phonerest) {

}else{
    header('Content-Type: application/x-json;charset=utf-8"');
}        
$dsn = 'mysql:dbname=XXXXXX;host=localhost.com';
$host="localhost.com";
$username="XXXXXXX";
$password="XXXXXXX";
$database='XXXXXXX'; 
?> 