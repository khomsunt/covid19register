<?php
include('../include/config.php');

$evaluate_level=0;
for ($i=3;$i>=1;$i=$i-1) {
    $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$_POST['changwat_out_code'].$_POST['ampur_out_code']."' ";
    $obj=$connect->prepare($sql);
    $obj->execute();
    $count=$obj->rowCount();
    if ($count>0) {
        $evaluate_level=$i;
        break;
    }
    else {
        $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=3 and tambon_code_full='".$_POST['changwat_out_code'].$_POST['ampur_out_code'].$_POST['tambon_out_code']."' ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $count=$obj->rowCount();
        if ($count>0) {
            $evaluate_level=$i;
            break;
        }   
    }

    $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$_POST['changwat_work_code'].$_POST['ampur_work_code']."' ";
    $obj=$connect->prepare($sql);
    $obj->execute();
    $count=$obj->rowCount();
    if ($count>0) {
        $evaluate_level=$i;
        break;
    }
    else {
        $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=3 and tambon_code_full='".$_POST['changwat_work_code'].$_POST['ampur_work_code'].$_POST['tambon_work_code']."' ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $count=$obj->rowCount();
        if ($count>0) {
            $evaluate_level=$i;
            break;
        }   
    }
}

if ($evaluate_level<3) {
    if ($_POST['occupation_id']!="" & $_POST['occupation_id']!=99) {
        $evaluate_level=2;
    }
}

$sql=" insert into covid_register ( ". 
" fname,lname,cid,tel,occupation_id ".
" ,tambon_out_code,ampur_out_code,changwat_out_code ". 
" ,tambon_work_code,ampur_work_code,changwat_work_code ". 
" ,date_to_sakonnakhon ". 
" ,house_in_no,moo_in_code,tambon_in_code,ampur_in_code ". 
" ,evaluate_level ".
" ) ".
" value ( ".
" '".$_POST['fname']."' ".
",'".$_POST['lname']."' ".
",'".$_POST['cid']."' ".
",'".$_POST['tel']."' ".
",'".$_POST['occupation_id']."' ".
",'".$_POST['tambon_out_code']."' ".
",'".$_POST['ampur_out_code']."' ".
",'".$_POST['changwat_out_code']."' ".
",'".$_POST['tambon_work_code']."' ".
",'".$_POST['ampur_work_code']."' ".
",'".$_POST['changwat_work_code']."' ".
",'".$_POST['date_to_sakonnakhon']."' ".
",'".$_POST['house_in_no']."' ".
",'".$_POST['moo_in_code']."' ".
",'".$_POST['tambon_in_code']."' ".
",'".$_POST['ampur_in_code']."' ".
",".$evaluate_level.
" ) ";

$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
$registerLastInsertId=$connect->lastInsertId();
// $registerLastInsertId="";
$status="";
if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

// $s=$sql;
$s="";
$x=array("sql"=>$s,"data"=>array("status"=>$status,"registerLastInsertId"=>$registerLastInsertId));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>