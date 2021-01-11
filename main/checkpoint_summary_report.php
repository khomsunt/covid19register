<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../include/config.php');
include_once('../include/functions.php');

$sql_changwat_risk="select * from changwat_risk where risk_status_id=5";
$obj=$connect->prepare($sql_changwat_risk);
$obj->execute($params);
$rows_changwat_risk=$obj->fetchAll(PDO::FETCH_ASSOC);

// print_r($rows_changwat_risk);

$sql="select f.real_date_to_sakonnakhon as `l|d||วันที่`,count(*) as `c|n|s|รวม`,";
$a_sql_add=[];
$a_changwat_risk=[];
foreach ($rows_changwat_risk as $key => $value) {
    array_push($a_changwat_risk,"'".$value['changwat_code']."'");
    array_push($a_sql_add,"sum(if(f.real_risk_area_changwat='".$value['changwat_code']."',1,0)) as `c|n|s|".$value['changwat_name']."` ");
}

$sql_add=implode(",",$a_sql_add);
$sql_add.=",sum(if(f.real_risk_area_changwat not in(".implode(",",$a_changwat_risk)."),1,0)) as `c|n|s|อื่นๆ` ";
$sql.=$sql_add;
$sql.=" from from_real_risk f left join changwat c on f.real_risk_area_changwat=c.changwat_code where f.checkpoint_id=401 group by f.real_date_to_sakonnakhon";
// echo "<br><br><br>sql=".$sql;

$obj=$connect->prepare($sql);
$obj->execute($params);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
$title="จำนวนการลงทะเบียนที่ ".$_SESSION['office_name']." รายวัน";
include("./autoTable.php");

?>