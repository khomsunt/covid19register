<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

require_once("../Shapefile/ShapefileAutoloader.php");
Shapefile\ShapefileAutoloader::register();

use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;

$sql="select * from TH_Province";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows);
$abstain=2;
try {
    $Shapefile = new ShapefileReader('../Shapefile/TH_PROVINCE2012.shp');
    $a_json_points=[];
    while ($Geometry = $Shapefile->fetchRecord()) {
        $data=$Geometry->getArray();
        print_r($data);
        $points=$data['rings'][0]['points'];
        $a_points=[];
        for ($x = 0; $x < count($points); $x+=$abstain) {
            array_push($a_points,$points[$x]['x'].",".$points[$x]['y']);
        }
        $json_points=implode("|",$a_points);
        echo "<br>".$json_points;
        array_push($a_json_points,$json_points);
    }        

    foreach ($rows as $key => $value) {
        $sql="update TH_Province set points10='".$a_json_points[$key]."' where prov_id=".($key+1);
        // echo "<br>sql=".$sql;
        $obj=$connect->prepare($sql);
        $obj->execute();
        echo "<br>key=".$key;

    }
} catch (ShapefileException $e) {
    // Print detailed error information
    echo "Error Type: " . $e->getErrorType()
        . "\nMessage: " . $e->getMessage()
        . "\nDetails: " . $e->getDetails();
}

