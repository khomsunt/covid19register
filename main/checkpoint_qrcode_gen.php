<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
include('../include/functions.php');
$toDay=date("Y-m-d");

//$sql="select * from office o where o.office_type=19";
//$sql="select * from office o where o.office_type=19 and office_id > 406";
$sql="select * from office o where o.office_type=19 and office_id not in (407,408,409,410)";

$obj=$connect->prepare($sql);
$obj->execute($params);
$rows_office_19=$obj->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows_office_19 as $k => $v) {
    $sql="select * from checkpoint_qrcode c where office_id=".$v['office_id']." and qrcode_date='".$toDay."'";
    $obj=$connect->prepare($sql);
    $obj->execute($params);
    $rows_this_office=$obj->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows_this_office)==0){
        $token="ด่านตรวจ:".$v['office_id'].",".$toDay;
        $sql="insert into checkpoint_qrcode (office_id,qrcode_date,token) value (".$v['office_id'].",'".$toDay."',md5('".$token."'))";
        $obj=$connect->prepare($sql);
        $obj->execute($params);
    }    
}
?>