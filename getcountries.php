<?php
require('config.php'); 
$sql="SELECT UPPER(pay) AS pay FROM jos_gmapfp WHERE `published`=1 GROUP BY pay ORDER BY pay;";
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