<?php
include('../include/config.php');

$sql=" insert into risk_area ( ". 
" changwat_code,area_name,risk_start_datetime,risk_last_datetime ".
" ,status_id ". 
" ) ".
" value ( ".
"'".$_POST['changwat_code']."' ".
",'".$_POST['area_name']."' ".
",'".$_POST['risk_start_datetime']."' ".
",'".$_POST['risk_last_datetime']."' ".
",'".$_POST['status_id']."' ".
" ) ";

$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
$areaInsertId=$connect->lastInsertId();

if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

$s=$sql;
// $s="";
$x=array("sql"=>$s,"data"=>array("status"=>$status,"areaInsertId"=>$areaInsertId));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
