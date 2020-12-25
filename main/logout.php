<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION["user_id"] = "";
$_SESSION["node_id"] = "";
$_SESSION["group_id"] = "";
header( "location: ./index.php" );
?>