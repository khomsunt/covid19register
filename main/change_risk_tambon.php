<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
print_r ($_POST);
include('../include/config.php');
$sql ="update tambon set risk_status_id=:risk_status_id where tambon_code_full=:tambon_code_full";
$obj=$connect->prepare($sql);
$obj->execute([ 'risk_status_id' => $_POST['risk_status_id'],'tambon_code_full' => $_POST['tambon_code_full']]);
?>