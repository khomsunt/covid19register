<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$_POST['cid']=str_replace('-','',$_POST['cid']);
$_POST['cid']=str_replace(' ','',$_POST['cid']);
$sql="SELECT * from covid_register where replace(replace(cid,'-',''),' ','') =:cid";
$obj=$connect->prepare($sql);
$obj->execute(['cid' => $_POST['cid']]);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
$_return["dataSource"]="covid";
$_return["data"]=$rows;
if (count($rows)==0){
    $sql="SELECT * from person where replace(replace(cid,'-',''),' ','') =:cid";
    $obj=$hdc_connect->prepare($sql);
    $obj->execute(['cid' => $_POST['cid']]);
    $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    $_return["dataSource"]="hdc";
    $_return["data"]=$rows;
}
echo json_encode($_return, JSON_UNESCAPED_UNICODE);
?>