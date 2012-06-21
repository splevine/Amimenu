<?php
require('config.php');

function webcheck ($url) {
        $ch = curl_init ($url) ;
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1) ;
        $res = curl_exec ($ch) ;
        curl_close ($ch) ;
        return ($res) ;
}

$name = $_REQUEST['name'];
$phonerest = '+'.$_REQUEST['phonerest'];
$phonerestq =$_REQUEST['phonerest'];
$usuario = $_REQUEST['usuario'];
$email = $_REQUEST['email'];
$db = new PDO($dsn, $username, $password);



 $sql="SELECT * FROM `jos_gmapfp` WHERE `tel` = $phonerest and `published` =1 and `recomendado` =1;";  
 //mysql_query("SELECT * FROM  jos_gmapfp WHERE  tel ='$phonerest'");
$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo 1;
    exit;
}

$rows = array();
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $realid="".$r['id'];
    $realname="".$r['nom'];
    $dartoque="".$r['recomendado']."";
}

if($dartoque == 1){

$date = date("Y-m-d");

//define the receiver of the email
$to = 'slaptot@gmail.com';
//define the subject of the email
$subject = 'Dar toque realizado'; 
//define the message to be sent. Each line should be separated with \n
$message = "Establecimiento:".$realname."\n\n Usuario:".$name."\n\n Telefono:".$usuario." \n\n Email:".$email.""; 
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: info@amimenu.es\r\nReply-To: slaptot@gmail.com";
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
		

$sqll="INSERT INTO jos_dartoque VALUES('','$realid','$realname','$date','$name','$usuario') ";
$db->query("SET NAMES utf8");
$rs = $db->query($sqll);
if (!$rs) {
    echo 1;
    exit;
}

//Clickatell user and Password
$user = "XXXXXXX";
$passwordclick = "XXXXXXX";
$api_id = "XXXXXXX";
//
$baseurl ="http://api.clickatell.com";
$text="http://amimenu.mowaps.com,  ".$realname.".There is a costumer with name -";
$usuario;
$name;
$textoenvio=urlencode($text." ".$name." - and phone ".$usuario." need your call.");
$to;


// auth call
$url = "$baseurl/http/auth?user=$user&password=$passwordclick&api_id=$api_id";


$erg = webcheck($url) ;

$sess = split(":",$erg);
if ($sess[0] == "OK") {

$sess_id = trim($sess[1]); // remove any whitespace

$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$phonerest&text=$textoenvio";
// do sendmsg call

$erg = webcheck($url) ;
//curl_exec($ret);
//curl_close($ret);


$send = split(":",$erg);

if ($send[0] == "ID"){
echo 0;
}else{
echo 1;
exit();
}

} else {
echo 1;
exit();
}
//Establecimiento sin tener privilegios de toque

} else{
echo 1;
exit();
}
	

?>