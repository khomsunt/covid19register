<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
print_r($_POST);
$risk_level_datetime=date("Y-m-d H:i:s");
include('../include/config.php');
$sql="update covid_register set 
cut_status_id=".$_POST['cut_status_id'].",
date_arrived_sakonnakhon='".$_POST['date_arrived_sakonnakhon']."',
date_leaved_sakonnakhon='".$_POST['date_leaved_sakonnakhon']."',
risk_level_user_id=".$_SESSION['user_id'].",
risk_level_datetime='".$risk_level_datetime."' 
where covid_register_id=".$_POST['covid_register_id'];
$obj=$connect->prepare($sql);
$obj->execute();
echo $sql;
?>
