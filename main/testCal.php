<?php
include('../include/config.php');

print_r($_GET);
$evaluate_level=0;
$evaluate_level_home=0;
$evaluate_level_work=0;
for ($i=3;$i>=1;$i=$i-1) {
    $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$_GET['changwat_out_code'].$_GET['ampur_out_code']."' ";
    $obj=$connect->prepare($sql);
    $obj->execute();
    $count=$obj->rowCount();
    if ($count>0) {
        $evaluate_level_home=$i;
        break;
    }
    else {
        $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=3 and tambon_code_full='".$_GET['changwat_out_code'].$_GET['ampur_out_code'].$_GET['tambon_out_code']."' ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $count=$obj->rowCount();
        if ($count>0) {
            $evaluate_level_home=$i;
            break;
        }   
    }

    $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$_GET['changwat_work_code'].$_GET['ampur_work_code']."' ";
    $obj=$connect->prepare($sql);
    $obj->execute();
    $count=$obj->rowCount();
    if ($count>0) {
        $evaluate_level_work=$i;
        break;
    }
    else {
        $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=3 and tambon_code_full='".$_GET['changwat_work_code'].$_GET['ampur_work_code'].$_GET['tambon_work_code']."' ";
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
    if ($_GET['occupation_id']!="" & $_GET['occupation_id']!=99) {
        $evaluate_level=2;
    }
}

if ($evaluate_level==2){
    $risk_level_id=99; 
    $auto_cut_status_id=0;
}else{
    $risk_level_id=$evaluate_level; 
    $auto_cut_status_id=1;
}

echo "<br>evaluate_level=".$evaluate_level;
?>
