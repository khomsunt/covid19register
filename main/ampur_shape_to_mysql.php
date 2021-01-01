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

$sql="select * from Amphoe_PROV";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows);
try {
    $Shapefile = new ShapefileReader('../Shapefile/Amphoe_PROV.shp');
    $a_json_points=[];
    while ($Geometry = $Shapefile->fetchRecord()) {
        $data=$Geometry->getArray();
        $points=$data['rings'][0]['points'];
        $a_points=[];
        foreach ($points as $key => $value) {
            array_push($a_points,$value['x'].",".$value['y']);
        }
        $json_points=implode("|",$a_points);
        // echo "<br>".$json_points;
        array_push($a_json_points,$json_points);
    }        

    foreach ($rows as $key => $value) {
        $sql="update Amphoe_PROV set points='".$a_json_points[$key]."' where amp_id=".($key+1);
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

