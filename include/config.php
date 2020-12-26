<?php
<<<<<<< HEAD
=======

>>>>>>> 47b78cd1e27424f50f26a72bfb97230d82ad4809
$projectTitle="รายงานตัวเข้าสกลนคร";
$host='';
$username='';
$password='';
$port='';
$db='';


$query_string="mysql:host=".$host.";dbname=".$db.";port=".$port;
try {
    $connect=new PDO($query_string,$username,$password);    
} catch (Exception $exc) {
    echo $exc->getMessage();
    exit;
}

$sql="SET NAMES utf8";
$obj_sql=$connect->prepare($sql);
try {
    $obj_sql->execute();
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}

?>
