<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
include_once('../include/config.php');

$sql=" update covid_register 
set checkpoint_id= '".$_POST['checkpoint_id']."'
where covid_register_id=".$_POST['covid_register_id']."
";
$obj=$connect->prepare($sql);
$obj->execute();
echo json_encode($obj);
?>