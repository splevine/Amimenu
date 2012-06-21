<?php
require('config.php'); 

$restarantid = $_GET["detailid"];
echo $restaurantid;
$db = new PDO($dsn, $username, $password);
 $sql = "select * from jos_gmapfp where id='$restarantid';";

$db->query("SET NAMES utf8");
$rs = $db->query($sql);
if (!$rs) {
    echo "An SQL error occured.\n".$restaurantid;
    exit;
}

$rows = array();
 $title = 'No Existe!';
   $desc = '';
   $dir = '';
   $img = 'pordefecto.png';
while($r = $rs->fetch(PDO::FETCH_ASSOC)) {
    $realid="".$r['id'];
    $id = $r['id'];
  $title = $r['nom'];
   $desc = $r['intro'];
   $dir = $r['adresse'];
   $img = $r['img'];
   $published= $r['published'];
   $lat = htmlspecialchars(trim($r['glat']));
   $lng = htmlspecialchars(trim($r['glng']));
}

   
   if($published==1){
    
   echo "<head>
   <meta charset='utf-8'>
    <title rel='localize[title]'>$title - Amimenu 2.0</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0'>
    <meta name='description' content='$desc' />
    <meta name='keywords' content='Restaurant,leaflet, users, map, javascript, cloudmade' />
    <meta name='author' content='Alberto Munoz Fuertes, http://mowaps.com' />
	<!-- iPhone -->
	<meta name='apple-mobile-web-app-capable' content='yes' /> 
  	<meta name='apple-mobile-web-app-status-bar-style' content='black' /> 
  	<link rel='apple-touch-icon-precomposed' sizes='114x114' href='homescreen/icon@2x.png' />
  	<link rel='apple-touch-icon-precomposed' sizes='72x72'   href='homescreen/icon-72.png' />
  	<link rel='apple-touch-icon-precomposed' sizes='57x57'   href='homescreen/icon.png' />
  	<link rel='apple-touch-icon-precomposed' href='homescreen/icon.png' />
	<link rel='apple-touch-startup-image' href='apple-touch-startup-image.png'>
	
    <link REL='SHORTCUT ICON' HREF='favicon.ico'>
     <link rel='stylesheet' href='lib/bootstrap/css/amimenu.min.css.gz' />
     <style>
      html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        position: absolute;
        overflow:auto;
      }
      .hero-unit{
      filter:alpha(opacity=80);
	-moz-opacity:0.8;
	-khtml-opacity: 0.8;
	opacity: 0.8;

      }
      #map {
        height:300px;
        -moz-border-radius: 6px; 
        -webkit-border-radius: 6px; 
        -moz-box-shadow: 0px 6px 3px -3px #888;
        -webkit-box-shadow: 0px 6px 3px -3px #888;
        box-shadow: 0px 6px 3px -3px #888; 
        background-color:white; border: solid 4px #80a8c1;
      }
      .navbar .brand {
        
        display: block;
float: left;
padding: 10px 55px 0px;
margin-left: -20px;
margin-bottom:10px;
font-size: 20px;
font-weight: 200;
line-height: 1;
color: #999;
      }
      .navbar .nav > li > a {
        padding: 13px 10px 11px;
      }
      .navbar .btn, .navbar .btn-group {
        margin-top: 8px;
      }
      .leaflet-top .leaflet-control {
        margin-top: 50px;
      }
      .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background: #f7f7f7;
        
      }
      .leaflet-popup-content{
      }
      .activeicon{
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        background-color: #80A8C1;

      }
      .getgeolocation {
       
       display:inline-block;
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        color: rgba(255, 255, 255, 1);
      }
      .getgeolocation a {
        background-color: rgba(255, 255, 255, 0.75);
        background-position: 50% 50%;
        background-repeat: no-repeat;
        background-image: url(img/location.png);
        display: block;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        width: 19px;
        height: 19px;
      }
      .getgeolocation a:hover {
        background-color: #fff;
      }
 .listing {
        position: absolute;
        left: 30px;
        top: 2px;
        margin-left: 10px;
        margin-top: 5px;
        padding: 5px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        color: rgba(255, 255, 255, 1);
        z-index: 100;
      }


      .geolocation {
        position: absolute;
        left: 0;
        top: 2px;
        margin-left: 10px;
        margin-top: 5px;
        padding: 5px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        color: rgba(255, 255, 255, 1);
        z-index: 9999;
      }
      .geolocation a {
        background-color: rgba(255, 255, 255, 0.75);
        background-position: 50% 50%;
        background-repeat: no-repeat;
        background-image: url(img/location.png);
        display: block;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        width: 19px;
        height: 19px;
      }
      .geolocation a:hover {
        background-color: #fff;
      }
      .unhappyMessage{
      color: #b94a48;
      }
      
      #example2{
    float:left;
    margin:80px 42% 0 42%;
  }
  .sharrre .box{
    background:#6f838c;
    background:-webkit-gradient(linear,left top,left bottom,color-stop(#6f838c,0),color-stop(#4d5e66,1));
    background:-webkit-linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    background:-moz-linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    background:-o-linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    background:linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#6f838c', endColorstr='#4d5e66',GradientType=0 );
    -webkit-box-shadow:0 1px 1px #d3d3d3;
    -moz-box-shadow:0 1px 1px #d3d3d3;
    box-shadow:0 1px 1px #d3d3d3;
    height:22px;
    display:inline-block;
    position:relative;
    padding:0px 55px 0 8px;
    -webkit-border-radius:3px;
    -moz-border-radius:3px;
    border-radius:3px;
    font-size:12px;
    float:left;
    clear:both;
    overflow:hidden;
    -webkit-transition:all 0.3s linear;
    -moz-transition:all 0.3s linear;
    -o-transition:all 0.3s linear;
    transition:all 0.3s linear;
  }
  .sharrre .left{
    line-height:22px;
    display:block;
    white-space:nowrap;
    text-shadow:0px 1px 1px rgba(255,255,255,0.3);
    color:#ffffff;
    -webkit-transition:all 0.2s linear;
    -moz-transition:all 0.2s linear;
    -o-transition:all 0.2s linear;
    transition:all 0.2s linear;
  }
  .sharrre .middle{
    position:absolute;
    height:22px;
    top:0px;
    right:30px;
    width:0px;
    background:#63707e;
    text-shadow:0px -1px 1px #363f49;
    color:#fff;
    white-space:nowrap;
    text-align:left;
    overflow:hidden;
    -webkit-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    -moz-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    -webkit-transition:width 0.3s linear;
    -moz-transition:width 0.3s linear;
    -o-transition:width 0.3s linear;
    transition:width 0.3s linear;
  }
  .sharrre .middle a{
    color:#fff;
    font-weight:bold;
    padding:0 9px 0 9px;
    text-align:center;
    float:left;
    line-height:22px;
    -webkit-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    -moz-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
  }
  .sharrre .right{
    position:absolute;
    right:0px;
    top:0px;
    height:100%;
    width:45px;
    text-align:center;
    line-height:22px;
    color:#4b5d61;
    background:#f1faf9;
    background:-webkit-gradient(linear,left top,left bottom,color-stop(#f1faf9,0),color-stop(#bacfd2,1));
    background:-webkit-linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    background:-moz-linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    background:-o-linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    background:linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#f1faf9', endColorstr='#bacfd2',GradientType=0 );
  }
  .sharrre .box:hover{
    padding-right:160px;
  }
  .sharrre .middle a:hover{
    text-decoration:none;
  }
  .sharrre .box:hover .middle{
    width:120px;
  } 

    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
    <![endif]-->
  </head>

  <body>

    <div class='navbar navbar-fixed-top'>
      <div class='navbar-inner'>
        <div class='container'>
                   <a class='brand' href='http://amimenu.mowaps.com' style='text-align: center; margin-left: auto; margin-right: auto;'>Beta <img src='img/logoheaderViejo.png'/></a>
          <div class='nav-collapse'>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class='container' style='margin-top:60px;'>
<div class='hero-unit'>
            <h1>$title</h1>
            <p><adress>$dir</adress></p>            
            <p>$desc</p>
            <div id='map'>&nbsp;</div>
          </div>
      
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src='js/jquery-1.7.1.min.js'></script>
    <script src='js/jquery.ez-bg-resize.js'></script>
    <script type='text/javascript' src='lib/Leaflet/leaflet.js'></script>
    <script>
         /*
 * ----------------------------- Background Image  -------------------------------------
 * http://johnpatrickgiven.com/jquery/background-resize/
 *
 */
     $('body').ezBgResize({
img : 'uploads/500_$img',
opacity : 0.5,
        center  : true
});
     
     /*
 * ----------------------------- Map initialization  -------------------------------------
 * Leaflet API http://leaflet.cloudmade.com
 *
 */
var map, mapquest;

var LeafIcon = L.Icon.extend({
		options : {
			iconUrl : 'markerMe.png',
			shadowUrl : 'marker-shadow.png',
			iconSize : new L.Point(25, 41),
			shadowSize : new L.Point(25, 41)
		}
	});
	var icon = new LeafIcon();

mapquest = new L.TileLayer(
		'http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png', {
			maxZoom : 17,
			minZoom : 4,
			subdomains : [ 'otile1', 'otile2', 'otile3', 'otile4' ],
			attribution : '<img src=\"img/logoheader.png\"/>'
		});

map = new L.Map('map', {
	center : new L.LatLng($lat, $lng),
	zoom : 14,
	layers : [ mapquest]
});


var city = new L.LatLng($lat, $lng); // geographical point (longitude and latitude)
map.setView(city, 13);
var markerLocation = new L.LatLng($lat, $lng);

var marker = new L.Marker(markerLocation);
map.addLayer(marker);


    </script>

  </body>";
  }else{
     echo "<head>
   <meta charset='utf-8'>
    <title rel='localize[title]'>$title - Amimenu 2.0</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0'>
    <meta name='description' content='$desc' />
    <meta name='keywords' content='Restaurant,leaflet, users, map, javascript, cloudmade' />
    <meta name='author' content='Alberto Munoz Fuertes, http://mowaps.com' />
	<!-- iPhone -->
	<meta name='apple-mobile-web-app-capable' content='yes' /> 
  	<meta name='apple-mobile-web-app-status-bar-style' content='black' /> 
  	<link rel='apple-touch-icon-precomposed' sizes='114x114' href='homescreen/icon@2x.png' />
  	<link rel='apple-touch-icon-precomposed' sizes='72x72'   href='homescreen/icon-72.png' />
  	<link rel='apple-touch-icon-precomposed' sizes='57x57'   href='homescreen/icon.png' />
  	<link rel='apple-touch-icon-precomposed' href='homescreen/icon.png' />
	<link rel='apple-touch-startup-image' href='apple-touch-startup-image.png'>
	
    <link REL='SHORTCUT ICON' HREF='favicon.ico'>
     <link rel='stylesheet' href='lib/bootstrap/css/amimenu.min.css.gz' />
     <style>
      html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        position: absolute;
        overflow:auto;
      }
      #map {
        height:300px;
        -moz-border-radius: 6px; 
        -webkit-border-radius: 6px; 
        -moz-box-shadow: 0px 6px 3px -3px #888;
        -webkit-box-shadow: 0px 6px 3px -3px #888;
        box-shadow: 0px 6px 3px -3px #888; 
        background-color:white; border: solid 4px #80a8c1;
      }
      .navbar .brand {
        
        display: block;
float: left;
padding: 10px 55px 0px;
margin-left: -20px;
margin-bottom:10px;
font-size: 20px;
font-weight: 200;
line-height: 1;
color: #999;
      }
      .navbar .nav > li > a {
        padding: 13px 10px 11px;
      }
      .navbar .btn, .navbar .btn-group {
        margin-top: 8px;
      }
      .leaflet-top .leaflet-control {
        margin-top: 50px;
      }
      .leaflet-popup-content-wrapper, .leaflet-popup-tip {
        background: #f7f7f7;
        
      }
      .leaflet-popup-content{
      }
      .activeicon{
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        background-color: #80A8C1;

      }
      .getgeolocation {
       
       display:inline-block;
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        color: rgba(255, 255, 255, 1);
      }
      .getgeolocation a {
        background-color: rgba(255, 255, 255, 0.75);
        background-position: 50% 50%;
        background-repeat: no-repeat;
        background-image: url(img/location.png);
        display: block;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        width: 19px;
        height: 19px;
      }
      .getgeolocation a:hover {
        background-color: #fff;
      }
 .listing {
        position: absolute;
        left: 30px;
        top: 2px;
        margin-left: 10px;
        margin-top: 5px;
        padding: 5px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        color: rgba(255, 255, 255, 1);
        z-index: 100;
      }


      .geolocation {
        position: absolute;
        left: 0;
        top: 2px;
        margin-left: 10px;
        margin-top: 5px;
        padding: 5px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 7px;
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        color: rgba(255, 255, 255, 1);
        z-index: 9999;
      }
      .geolocation a {
        background-color: rgba(255, 255, 255, 0.75);
        background-position: 50% 50%;
        background-repeat: no-repeat;
        background-image: url(img/location.png);
        display: block;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        width: 19px;
        height: 19px;
      }
      .geolocation a:hover {
        background-color: #fff;
      }
      .unhappyMessage{
      color: #b94a48;
      }
      
      #example2{
    float:left;
    margin:80px 42% 0 42%;
  }
  .sharrre .box{
    background:#6f838c;
    background:-webkit-gradient(linear,left top,left bottom,color-stop(#6f838c,0),color-stop(#4d5e66,1));
    background:-webkit-linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    background:-moz-linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    background:-o-linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    background:linear-gradient(top, #6f838c 0%, #4d5e66 100%);
    filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#6f838c', endColorstr='#4d5e66',GradientType=0 );
    -webkit-box-shadow:0 1px 1px #d3d3d3;
    -moz-box-shadow:0 1px 1px #d3d3d3;
    box-shadow:0 1px 1px #d3d3d3;
    height:22px;
    display:inline-block;
    position:relative;
    padding:0px 55px 0 8px;
    -webkit-border-radius:3px;
    -moz-border-radius:3px;
    border-radius:3px;
    font-size:12px;
    float:left;
    clear:both;
    overflow:hidden;
    -webkit-transition:all 0.3s linear;
    -moz-transition:all 0.3s linear;
    -o-transition:all 0.3s linear;
    transition:all 0.3s linear;
  }
  .sharrre .left{
    line-height:22px;
    display:block;
    white-space:nowrap;
    text-shadow:0px 1px 1px rgba(255,255,255,0.3);
    color:#ffffff;
    -webkit-transition:all 0.2s linear;
    -moz-transition:all 0.2s linear;
    -o-transition:all 0.2s linear;
    transition:all 0.2s linear;
  }
  .sharrre .middle{
    position:absolute;
    height:22px;
    top:0px;
    right:30px;
    width:0px;
    background:#63707e;
    text-shadow:0px -1px 1px #363f49;
    color:#fff;
    white-space:nowrap;
    text-align:left;
    overflow:hidden;
    -webkit-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    -moz-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    -webkit-transition:width 0.3s linear;
    -moz-transition:width 0.3s linear;
    -o-transition:width 0.3s linear;
    transition:width 0.3s linear;
  }
  .sharrre .middle a{
    color:#fff;
    font-weight:bold;
    padding:0 9px 0 9px;
    text-align:center;
    float:left;
    line-height:22px;
    -webkit-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    -moz-box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
    box-shadow:-1px 0px 1px rgba(255,255,255,0.4), 1px 1px 2px rgba(0,0,0,0.2) inset;
  }
  .sharrre .right{
    position:absolute;
    right:0px;
    top:0px;
    height:100%;
    width:45px;
    text-align:center;
    line-height:22px;
    color:#4b5d61;
    background:#f1faf9;
    background:-webkit-gradient(linear,left top,left bottom,color-stop(#f1faf9,0),color-stop(#bacfd2,1));
    background:-webkit-linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    background:-moz-linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    background:-o-linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    background:linear-gradient(top, #f1faf9 0%, #bacfd2 100%);
    filter:progid:DXImageTransform.Microsoft.gradient( startColorstr='#f1faf9', endColorstr='#bacfd2',GradientType=0 );
  }
  .sharrre .box:hover{
    padding-right:160px;
  }
  .sharrre .middle a:hover{
    text-decoration:none;
  }
  .sharrre .box:hover .middle{
    width:120px;
  } 

    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
    <![endif]-->
  </head>

  <body>

    <div class='navbar navbar-fixed-top'>
      <div class='navbar-inner'>
        <div class='container'>
                   <a class='brand' href='http://amimenu.mowaps.com' style='text-align: center; margin-left: auto; margin-right: auto;'>Beta <img src='img/logoheaderViejo.png'/></a>
          <div class='nav-collapse'>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class='container' style='margin-top:60px;'>
<div class='hero-unit'>
            <h1>Not Activated!</h1>
          </div>
      
    </div> <!-- /container -->

  </body>";
  }

?>