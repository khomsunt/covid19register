<?php
date_default_timezone_set("Asia/Bangkok");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

$sql="select 
    c.* 
    from covid_register c
    where c.cut_status_id=0 and c.risk_level_id<99";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows);
$now_date_time=date('Y-m-d H:i:s');
foreach ($rows as $rows_i => $row) {
    echo "<br><br>";
    // print_r($row);
    $sql="insert into covid_register_cut ";
    $a_row_key=array();
    $a_value=array();
    foreach ($row as $row_key => $value) {
        // echo "<br>key=".$row_key." : ".$value;
        array_push($a_row_key,$row_key);
        array_push($a_value,"'".$value."'");
    }
    array_push($a_row_key,'cut_datetime');
    array_push($a_value,"'".$now_date_time."'");
    array_push($a_row_key,'cut_user_id');
    array_push($a_value,"'".$_SESSION['user_id']."'");
    $keys=implode(",",$a_row_key);
    $values=implode(",",$a_value);
    $sql.="(".$keys.") value (".$values.")";
    // echo "<br>sql=".$sql;
    $obj=$connect->prepare($sql);
    $obj->execute();

    $sql_update="update covid_register set cut_status_id=1 where covid_register_id=".$row['covid_register_id'];
    // echo "<br>sql_update=".$sql_update;
    $obj=$connect->prepare($sql_update);
    $obj->execute();
    header("Location: ./cut_data.php");
}
?>
