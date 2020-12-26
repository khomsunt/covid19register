<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
print_r ($_POST);
include('../include/config.php');
$sql = "update ampur set risk_status_id=:risk_status_id where ampur_code_full=:ampur_code_full";
echo $sql;
$obj=$connect->prepare($sql);
$obj->execute([ 'risk_status_id' => $_POST['risk_status_id'],'ampur_code_full' => $_POST['ampur_code_full']]);

// $obj_tambon=$connect->prepare('update tambon set risk_status_id=:risk_status_id where ampur_code_full=:ampur_code_full');
// $obj_tambon->execute([ 'risk_status_id' => $_POST['risk_status_id'],'ampur_code_full' => $_POST['ampur_code_full']]);

?>