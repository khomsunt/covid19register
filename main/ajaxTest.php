<?php
include('../include/config.php');

$sql="select * from ".$_POST["query_table"]." ";

if ($_POST["query_where"] != "") {
    $sql.=" where ".$_POST["query_where"];
}

if ($_POST["query_order"] != "") {
    $sql.=" order by ".$_POST["query_order"];
}

$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

// echo json_encode($rows, JSON_UNESCAPED_UNICODE);

// $s=$sql;
$s="";
$x=array("sql"=>$s,"data"=>$rows);
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
