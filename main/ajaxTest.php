<?php
include('../include/config.php');

$sql="select * from ".$_POST["query_table"]." ";
if ($_POST["query_where"] != "") {
    $sql.=" where ".$_POST["query_where"];
}
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows, JSON_UNESCAPED_UNICODE);
?>
