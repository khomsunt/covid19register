<?php
include('../include/config.php');

$evaluate_level=0;
$evaluate_level_home=0;
$evaluate_level_work=0;
for ($i=3;$i>=1;$i=$i-1) {
    $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$_POST['changwat_out_code'].$_POST['ampur_out_code']."' ";
    $obj=$connect->prepare($sql);
    $obj->execute();
    $count=$obj->rowCount();
    if ($count>0) {
        $evaluate_level_home=$i;
        break;
    }
    else {
        $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=".$i." and tambon_code_full='".$_POST['changwat_out_code'].$_POST['ampur_out_code'].$_POST['tambon_out_code']."' ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $count=$obj->rowCount();
        if ($count>0) {
            $evaluate_level_home=$i;
            break;
        }   
    }

    $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$_POST['changwat_work_code'].$_POST['ampur_work_code']."' ";
    $obj=$connect->prepare($sql);
    $obj->execute();
    $count=$obj->rowCount();
    if ($count>0) {
        $evaluate_level_work=$i;
        break;
    }
    else {
        $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=".$i." and tambon_code_full='".$_POST['changwat_work_code'].$_POST['ampur_work_code'].$_POST['tambon_work_code']."' ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $count=$obj->rowCount();
        if ($count>0) {
            $evaluate_level_work=$i;
            break;
        }   
    }
}

$evaluate_level=$evaluate_level_home;
if ($evaluate_level_work>$evaluate_level_home) {
    $evaluate_level=$evaluate_level_work;
}

if ($evaluate_level<3) {
    if ($_POST['occupation_id']!="" & $_POST['occupation_id']!=99) {
        $evaluate_level=2;
    }
}

// if ($evaluate_level==2){ //
//     $risk_level_id=99; 
//     $auto_cut_status_id=0;
// }else{
//     $risk_level_id=$evaluate_level; 
//     $auto_cut_status_id=1;
// }

$sql=" insert into covid_register ( ". 
" fname,lname,cid,tel,occupation_id ".
" ,tambon_out_code,ampur_out_code,changwat_out_code ". 
" ,tambon_work_code,ampur_work_code,changwat_work_code ". 
" ,date_to_sakonnakhon ". 
" ,house_in_no,moo_in_code,tambon_in_code,ampur_in_code ". 
// " ,risk_level_id,auto_cut_status_id ".
" ,evaluate_level ".
" ,date_to_sakonnakhon_text,note ".
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
// ",".$risk_level_id.
// ",".$auto_cut_status_id.
",".$evaluate_level.
",'".$_POST['date_to_sakonnakhon_text']."' ".
",'".$_POST['note']."' ".
" ) ";

$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
$registerLastInsertId=$connect->lastInsertId();
///// $registerLastInsertId="";
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
