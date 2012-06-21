<?php
require('config.php');
$state =$_GET['country']; 
$sql="SELECT UPPER(departement) AS departement FROM jos_gmapfp WHERE pay LIKE '%{$state}%' AND `published`=1 GROUP BY departement ORDER BY departement;";
$encodable = array();

mysql_connect($host, $username, $password);
mysql_select_db($database) or die("Unable to select database");
mysql_query("SET NAMES UTF8");
$result = mysql_query($sql);

while($obj = mysql_fetch_object($result))
{
$encodable[] = $obj;
}

$encoded = json_encode($encodable);

print_r($encoded);

mysql_close();
?>