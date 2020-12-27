<?php
include('../include/config.php');

$status="";

$sql=" select * from covid_register where cid=:cid ";
$obj=$connect->prepare($sql);
$execute_status=$obj->execute([ 'cid' => $_POST['cid'] ]);
// $execute_status=$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

$s=$sql;
// $s="";
$x=array("sql"=>$s, "data"=>array("status"=>$status, "register_data"=>$rows));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
