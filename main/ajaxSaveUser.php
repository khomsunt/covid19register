<?php
include('../include/config.php');

$sql=" insert into user ( ". 
" user_login,user_password,prename_id,fname ".
" ,lname,phone,office_id,line_token,group_id,status_id ". 
" ) ".
" value ( ".
"'".$_POST['user_login']."' ".
",'md5(".$_POST['user_password'].")' ".
",'".$_POST['prename_id']."' ".
",'".$_POST['fname']."' ".
",'".$_POST['lname']."' ".
",'".$_POST['phone']."' ".
",'".$_POST['office_id']."' ".
",'".$_POST['line_token']."' ".
",'".$_POST['group_id']."' ".
",'".$_POST['status_id']."' ".
" ) ";

$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
$usernameLastInsertId=$connect->lastInsertId();

if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

// $s=$sql;
$s="";
$x=array("sql"=>$s,"data"=>array("status"=>$status,"usernameLastInsertId"=>$usernameLastInsertId));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
