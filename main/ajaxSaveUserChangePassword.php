<?php
include('../include/config.php');

$sql="update user set ( ". 
" user_login,user_password,prename_id,fname ".
" ,lname,phone,office_id,line_token,group_id,status_id ". 
" ) ".
" value ( ".
"'".$_POST['user_login']."' ".
",'".$_POST['user_password']."' ".
" WHERE user_id ='".$_POST['user_id']."'";

$sql="update user set ". 
" user_login='".$_POST['user_login']."' ".
" ,user_password='".$_POST['user_password']."' ".
" WHERE user_id ='".$_POST['user_id']."'";

$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
$usernameLastInsertId=$connect->lastInsertId();

if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

$s=$sql;
// $s="";
$x=array("sql"=>$s,"data"=>array("status"=>$status,"usernameLastInsertId"=>$usernameLastInsertId));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
