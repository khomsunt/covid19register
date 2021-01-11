<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["user_id"] = "";
$_SESSION["node_id"] = "";
$_SESSION["group_id"] = "";
$_SESSION["office_id"] = "";
$_SESSION["office_code"] = "";
$_SESSION["office_name"] = "";
$_SESSION["ampur_code"] = "";





header( "location: ./index.php" );
?>