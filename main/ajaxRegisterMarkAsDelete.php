<?php
include('../include/config.php');

$sql=" update covid_register set cut_status_id=2 where covid_register_id in (".$_POST['covid_register_id_list_string'].") ";
// $sql=" update covid_register set cut_status_id=2 where covid_register_id in (:id_list) ";
$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
// $execute_status=$obj->execute([ 'id_list' => $_POST['covid_register_id_list_string'] ]);

$status="";
if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

// $s=$sql;
$s="";
$x=array("sql"=>$s, "data"=>array("status"=>$status));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
