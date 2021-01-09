<?php
include('../include/config.php');

 if($_POST['type_cut']=='new'){
$sql_update="update covid_register set cut_status_id=1,cut_datetime='".$_POST['open_datetime']."' where hospcode='".$_POST['office_code']."' and register_datetime<='".$_POST['open_datetime']."' and cut_status_id=0";    

$obj=$connect->prepare($sql_update);
$execute_status=$obj->execute();
 }

if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

$s=$sql_update;
// $s="";
$x=array("sql"=>$s,"data"=>array("status"=>$status,"registerLastInsertId"=>$registerLastInsertId));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
