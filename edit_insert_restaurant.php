<?php
include('db.php');
session_start();
$session_id='1'; // User session id
$path = "uploads/";

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
	$idrest = htmlspecialchars(trim(utf8_decode($_POST['idrestedit'])));
	$namerest = htmlspecialchars(trim(utf8_decode($_POST['nameedit'])));
$phone = htmlspecialchars(trim(utf8_decode($_POST['phoneedit'])));
$intro = htmlspecialchars(trim(utf8_decode($_POST['introedit'])));
$email = htmlspecialchars(trim(utf8_decode($_POST['emailedit'])));
$website = htmlspecialchars(trim(utf8_decode($_POST['websiteedit'])));
$addre = htmlspecialchars(trim(utf8_decode($_POST['addresseedit'])));
$city = htmlspecialchars(trim(utf8_decode($_POST['cityedit'])));
$postcode = htmlspecialchars(trim(utf8_decode($_POST['postcodeedit'])));
$country = htmlspecialchars(trim(utf8_decode($_POST['countryedit'])));
$state = htmlspecialchars(trim(utf8_decode($_POST['stateedit'])));
$lat = htmlspecialchars(trim(utf8_decode($_POST['latedit'])));
$lng = htmlspecialchars(trim(utf8_decode($_POST['lngedit'])));
$mondaymenu = htmlspecialchars(trim(utf8_decode($_POST['introlunesedit'])));
$tuesdaymenu = htmlspecialchars(trim(utf8_decode($_POST['intromartesedit'])));
$wenmenu = htmlspecialchars(trim(utf8_decode($_POST['intromiercolesedit'])));
$thmenu = htmlspecialchars(trim(utf8_decode($_POST['introjuevesedit'])));
$frimenu = htmlspecialchars(trim(utf8_decode($_POST['introviernesedit'])));
$satmenu = htmlspecialchars(trim(utf8_decode($_POST['introsabadoedit'])));
$sunmenu = htmlspecialchars(trim(utf8_decode($_POST['introdomingoedit'])));
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




if($guardado)
{

mysql_query("UPDATE jos_gmapfp
SET nom='$namerest', email='$email',tel='$phone', web='$website', ville='$city', glat='$lat', glng='$lng',introlunes='$mondaymenu',intromartes='$tuesdaymenu',intromiercoles='$wenmenu',introjueves='$thmenu',introviernes='$frimenu',introsabado='$satmenu',introdomingo='$sunmenu',  intro='$intro',img='$actual_image_name',pay='$country',departement='$state',adresse='$addre',codepostal='$postcode'
WHERE id='$idrest';");

$subject = "Welcome to Amimenu!";
$body = '
<html>
<head>
</head>
<body>
	<p>Thanks for edit your Restaurant in Amimenu!</p>
	Your account information:<br>
	-------------------------<br>
	Email: '.$email.'<br>
	Name: '.$token.'<br>
	-------------------------<br><br>
	Should you need to edit your information, please visit the map and click on the Remove me button.<br>
	Enter your email and unique token to remove your entry from the database.<br>
	Feel free to add yourself back to the map at any time!
</body>
</html>
';
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$cabeceras .= 'From: Amimenu <noreply@amimenu.com>' . "\r\n";
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


mysql_query("UPDATE jos_gmapfp
SET nom='$namerest', email='$email',tel='$phone', web='$website', ville='$city', glat='$lat', glng='$lng',introlunes='$mondaymenu',intromartes='$tuesdaymenu',intromiercoles='$wenmenu',introjueves='$thmenu',introviernes='$frimenu',introsabado='$satmenu',introdomingo='$sunmenu',  intro='$intro',pay='$country',departement='$state',adresse='$addre',codepostal='$postcode'
WHERE id='$idrest';");

$subject = "Welcome to Amimenu!";
$body = '
<html>
<head>
</head>
<body>
	<p>Thanks for edit your Restaurant in Amimenu!</p>
	Your account information:<br>
	-------------------------<br>
	Email: '.$email.'<br>
	Token: '.$token.'<br>
	-------------------------<br><br>
	Should you need to edit your information, please visit the map and click on the Remove me button.<br>
	Enter your email and unique token to remove your entry from the database.<br>
	Feel free to add yourself back to the map at any time!
</body>
</html>
';
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$cabeceras .= 'From: Amimenu <noreply@amimenu.com>' . "\r\n";
if (mail($email, $subject, $body,$cabeceras)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }

}


?>