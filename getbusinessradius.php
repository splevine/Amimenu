<?php
 

require('config.php'); 

// Search parameters

$lat = $_GET['lat'];
$lng = $_GET['lng'];
$radius = $_GET['radius'];
if($radius=="Radius"){
$radius=10;
}
 
// Constants related to the surface of the Earth
$earths_radius = 6371;
$surface_distance_coeffient = 111.320;
 
// Spherical Law of Cosines
$distance_formula = "$earths_radius * ACOS( SIN(RADIANS(glat)) * SIN(RADIANS($lat)) + COS(RADIANS(glng - $lng)) * COS(RADIANS(glat)) * COS(RADIANS($lat)) )";
 
// Create a bounding box to reduce the scope of our search
$lng_b1 = $lng - $radius / abs(cos(deg2rad($lat)) * $surface_distance_coeffient);
$lng_b2 = $lng + $radius / abs(cos(deg2rad($lat)) * $surface_distance_coeffient);
$lat_b1 = $lat - $radius / $surface_distance_coeffient;
$lat_b2 = $lat + $radius / $surface_distance_coeffient;
 
// Construct our sql statement


$db = new PDO($dsn, $username, $password);
$sql = "SELECT id, nom,ville,pay,tel, glat, glng,intro,img, ($distance_formula) AS distance
FROM jos_gmapfp
WHERE (glat BETWEEN $lat_b1 AND $lat_b2) AND (glng BETWEEN $lng_b1 AND $lng_b2) and published=1
HAVING distance < $radius
ORDER BY distance ASC LIMIT 0,9;";
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
?>