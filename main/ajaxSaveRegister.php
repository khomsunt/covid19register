<?php
include('../include/config.php');

$sql=" insert into covid_register ( ". 
" prename_id,fname,lname,cid,tel ".
" ,moo_out,tambon_out_code,ampur_out_code,changwat_out_code ". 
" ,occupation_id,date_to_sakonnakhon,touch_history ". 
" ,house_in_no,tambon_in_code,ampur_in_code,changwat_in_code ". 
" ) ".
" value ( ".
"'".$_POST['prename_id']."' ".
",'".$_POST['fname']."' ".
",'".$_POST['lname']."' ".
",'".$_POST['cid']."' ".
",'".$_POST['tel']."' ".
",'".$_POST['moo_out']."' ".
",'".$_POST['tambon_out_code']."' ".
",'".$_POST['ampur_out_code']."' ".
",'".$_POST['changwat_out_code']."' ".
",'".$_POST['occupation_id']."' ".
",'".$_POST['date_to_sakonnakhon']."' ".
",'".$_POST['touch_history']."' ".
",'".$_POST['house_in_no']."' ".
",'".$_POST['tambon_in_code']."' ".
",'".$_POST['ampur_in_code']."' ".
",'".$_POST['changwat_in_code']."' ".
" ) ";

$obj=$connect->prepare($sql);
$obj->execute();
$registerLastInsertId=$connect->lastInsertId();
// $registerLastInsertId=123;
$s=$sql;
// $s="";
// $s=$_POST;
$x=array("sql"=>$s,"data"=>array("registerLastInsertId"=>$registerLastInsertId));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
