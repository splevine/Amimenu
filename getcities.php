<?php
require('config.php'); 
$query =$_GET['state'];
$sql="SELECT UPPER(ville) AS ville FROM jos_gmapfp WHERE departement LIKE '%{$query}%' and `published`=1 GROUP BY ville ORDER BY ville;";
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

echo $encoded;

mysql_close();
?>