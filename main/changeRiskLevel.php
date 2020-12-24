<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$obj=$connect->prepare('update covid_register set risk_level_id=:risk_level_id where covid_register_id=:covid_register_id');
$obj->execute([ 'risk_level_id' => $_POST['risk_level_id'], 'covid_register_id' => $_POST['covid_register_id'] ]);
?>