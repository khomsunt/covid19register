<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include('../include/config.php');
    $today=date("Y-m-d");
    if (!isset($_POST['register_datetime'])){
        $_POST['register_datetime']=$today;
    }
    $sql_ampur_rate="SELECT * from ampur_rate";
    $obj=$connect->prepare($sql_ampur_rate);
    $obj->execute();
    $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    echo "<br><br><br><br>";
    //print_r($rows);
    
    $title="รายงานการประเมินความเสี่ยง";
    include("./autoTable.php");
?>
