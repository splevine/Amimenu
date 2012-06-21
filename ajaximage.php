<?php
include('db.php');
session_start();
$session_id='1'; // User session id
$path = "uploads/";

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");

	$namerest = htmlspecialchars(trim(utf8_decode($_POST['name'])));
$phone = htmlspecialchars(trim(utf8_decode($_POST['phone'])));
$intro = htmlspecialchars(trim(utf8_decode($_POST['intro'])));
$email = htmlspecialchars(trim(utf8_decode($_POST['email'])));
$website = htmlspecialchars(trim(utf8_decode($_POST['website'])));
$addre = htmlspecialchars(trim(utf8_decode($_POST['addresse'])));
$city = htmlspecialchars(trim(utf8_decode($_POST['city'])));
$postcode = htmlspecialchars(trim(utf8_decode($_POST['postcode'])));
$country = htmlspecialchars(trim(utf8_decode($_POST['country'])));
$state = htmlspecialchars(trim(utf8_decode($_POST['state'])));
$lat = htmlspecialchars(trim(utf8_decode($_POST['lat'])));
$lng = htmlspecialchars(trim(utf8_decode($_POST['lng'])));
$mondaymenu = htmlspecialchars(trim(utf8_decode($_POST['introlunes'])));
$tuesdaymenu = htmlspecialchars(trim(utf8_decode($_POST['intromartes'])));
$wenmenu = htmlspecialchars(trim(utf8_decode($_POST['intromiercoles'])));
$thmenu = htmlspecialchars(trim(utf8_decode($_POST['introjueves'])));
$frimenu = htmlspecialchars(trim(utf8_decode($_POST['introviernes'])));
$satmenu = htmlspecialchars(trim(utf8_decode($_POST['introsabado'])));
$sunmenu = htmlspecialchars(trim(utf8_decode($_POST['introdomingo'])));
$token = mt_rand(100000, 999999);

if($_FILES['fileToUpload']['name']!=''){


if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
$name = $_FILES['fileToUpload']['name'];
$size = $_FILES['fileToUpload']['size'];

if(strlen($name))
{
list($txt, $ext) = explode(".", $name);
}else{
$name = "pordefecto.png";
$size = 100;
list($txt, $ext) = explode(".", $name);
}

if(in_array($ext,$valid_formats))
{
if($size<(1024*1024)) // Image size max 1 MB
{
$actual_image_name = time().$session_id.".".$ext;
$tmp = $_FILES['fileToUpload']['tmp_name'];
$guardado = false;

    $sizes = array();
    $sizes['50'] = 50;
    $sizes['150'] = 150;
    $sizes['500'] = 500;

   
    list(,,$type) = getimagesize($_FILES['fileToUpload']['tmp_name']);
    $type = image_type_to_extension($type);

   if( move_uploaded_file($_FILES['fileToUpload']['tmp_name'], 'uploads/'.$actual_image_name)){
   $guardado=true;
   }

    $t = 'imagecreatefrom'.$type;
    $t = str_replace('.','',$t);
    $img = $t($path.$actual_image_name);

    foreach($sizes as $k=>$v){

        $width = imagesx( $img );
        $height = imagesy( $img );

        $new_width = $v;
        $new_height = floor( $height * ( $v / $width ) );

        $tmp_img = imagecreatetruecolor( $new_width, $new_height );
        imagealphablending( $tmp_img, false );
        imagesavealpha( $tmp_img, true );
        imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

        $c = 'image'.$type;
        $c = str_replace('.','',$c);
        $c( $tmp_img, $path.$k.'_'.$actual_image_name );

    }//

$result = mysql_query("SELECT * FROM countries WHERE name LIKE '$country';");
while ($row = mysql_fetch_object($result)) {
    $phone= '+'.$row->dialing_code.$phone;
}


if($guardado)
{
$activation = md5(uniqid(rand(), true));
mysql_query("INSERT INTO jos_gmapfp (nom, email,tel, web, ville, glat, glng,introlunes,intromartes,intromiercoles,introjueves,introviernes,introsabado,introdomingo, token,intro, img,pay,departement,adresse,codepostal,published,activation) VALUES ('$namerest', '$email','$phone', '$website', '$city', '$lat', '$lng','$mondaymenu','$tuesdaymenu','$wenmenu','$thmenu','$frimenu','$satmenu','$sunmenu', '$token', '$intro','$actual_image_name','$country','$state','$addre','$postcode','0','$activation');");

$subject = "Welcome to Amimenu!";
$body = '
<html>
<head>
</head>
<body>
	<p>Thanks for adding Restaurant to Amimenu!</p>
	Your account information:<br>
	-------------------------<br>
	Email: '.$email.'<br>
	Token: '.$token.'<br>
	-------------------------<br><br>
	Should you need to edit your information, please visit the map and click on the Remove me button.<br>
	Enter your email and unique token to edit or remove your entry from the database.<br>
	If you want to use "toque!" service, please send us an email with your email and token to activate it.<br>
	Toque!, let costumers send you SMS to ask you something about your business<br>
	
	<a href="http://amimenu.mowaps.com/activate.php?code='.$activation.'">Activation Link </a>
	
</body>
</html>
';
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: Amimenu <slaptot@gmail.com>' . "\r\n";
$cabeceras .= 'Bcc: slaptot@gmail.com' . "\r\n";
if (mail($email, $subject, $body,$cabeceras)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }

}
else
echo "failed";
}
else
echo "Image file size max 1 MB"; 
}
else
echo "Invalid file format.."; 
}
}
//If not image uploaded, default image
else{
$result = mysql_query("SELECT * FROM countries WHERE name LIKE '$country';");
while ($row = mysql_fetch_object($result)) {
    $phone= '+'.$row->dialing_code.$phone;
}
$actual_image_name = "pordefecto.png";
$activation = md5(uniqid(rand(), true));
mysql_query("INSERT INTO jos_gmapfp (nom, email,tel, web, ville, glat, glng,introlunes,intromartes,intromiercoles,introjueves,introviernes,introsabado,introdomingo, token,intro, img,pay,departement,adresse,codepostal,published,activation) VALUES ('$namerest', '$email','$phone', '$website', '$city', '$lat', '$lng','$mondaymenu','$tuesdaymenu','$wenmenu','$thmenu','$frimenu','$satmenu','$sunmenu', '$token', '$intro','$actual_image_name','$country','$state','$addre','$postcode','0','$activation');");

$subject = "Welcome to Amimenu!";
$body = '
<html>
<head>
</head>
<body>
	<p>Thanks for adding Restaurant to Amimenu!</p>
	Your account information:<br>
	-------------------------<br>
	Email: '.$email.'<br>
	Token: '.$token.'<br>
	-------------------------<br><br>
	Should you need to edit your information, please visit the map and click on the Remove me button.<br>
	Enter your email and unique token to edit or remove your entry from the database.<br>
	If you want to use "toque!" service, please send us an email with your email and token to activate it.<br>
	Toque!, let costumers send you SMS to ask you something about your business<br>
	
	<a href="http://amimenu.mowaps.com/activate.php?code='.$activation.'">Activation Link </a>
	
</body>
</html>
';
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: Amimenu <slaptot@gmail.com>' . "\r\n";
$cabeceras .= 'Bcc: slaptot@gmail.com' . "\r\n";
if (mail($email, $subject, $body,$cabeceras)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }

}


?>