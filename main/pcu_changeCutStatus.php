<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// print_r($_POST);
include('../include/config.php');
$sql="update covid_register set 
cut_status_id=".$_POST['cut_status_id']." 
where covid_register_id=".$_POST['covid_register_id'];
$obj=$connect->prepare($sql);
$obj->execute();
echo $sql;
?>
