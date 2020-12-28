<?php
include('../include/config.php');

$status="";

$sql=" select * from covid_register where cid=:cid and tel=:tel ".
" and cut_status_id = 0 ". 
" and (date_arrived_sakonnakhon is null or date_arrived_sakonnakhon='') ".
" and date_to_sakonnakhon > left(now(),10) ";
$obj=$connect->prepare($sql);
$execute_status=$obj->execute([ 'cid' => $_POST['cid'],'tel' => $_POST['tel'] ]);
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
