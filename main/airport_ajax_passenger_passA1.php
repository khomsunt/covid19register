<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
include_once('../include/config.php');

$sql_set="";
if ($_POST['action']=='pass') {
  $sql_set.=" airport_screen_A1_datetime=now() ";
}
else {
  $sql_set.=" airport_screen_A1_datetime=null ";
}

$sql=" update covid_register 
set ".$sql_set."
where covid_register_id=".$_POST['covid_register_id']."
";
$obj=$connect->prepare($sql);
$obj->execute();
echo json_encode($obj);
?>