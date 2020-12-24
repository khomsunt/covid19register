<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
print_r ($_POST);
include('../include/config.php');
$obj=$connect->prepare('update risk_area set status_id=:status_id where risk_area_id=:risk_area_id');
$obj->execute([ 'status_id' => $_POST['status_id'],'risk_area_id' => $_POST['risk_area_id']]);
?>