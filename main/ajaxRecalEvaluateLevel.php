<?php
include('../include/config.php');

$status="";

$sql=" select * from covid_register ";
$obj=$connect->prepare($sql);
// $obj->execute([ 'cut_datetime' => $_POST['cut_datetime'] ]);
$obj->execute();
$rowsCR=$obj->fetchAll(PDO::FETCH_ASSOC);

for ($n=0;$n<count($rowsCR);$n=$n+1) {

    $evaluate_level=0;
    $evaluate_level_home=0;
    $evaluate_level_work=0;
    for ($i=3;$i>=1;$i=$i-1) {
        $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$rowsCR[$n]['changwat_out_code'].$rowsCR[$n]['ampur_out_code']."' ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $count=$obj->rowCount();
        if ($count>0) {
            $evaluate_level_home=$i;
            break;
        }
        else {
            $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=3 and tambon_code_full='".$rowsCR[$n]['changwat_out_code'].$rowsCR[$n]['ampur_out_code'].$rowsCR[$n]['tambon_out_code']."' ";
            $obj=$connect->prepare($sql);
            $obj->execute();
            $count=$obj->rowCount();
            if ($count>0) {
                $evaluate_level_home=$i;
                break;
            }   
        }

        $sql=" select ampur_code_full from ampur a where a.risk_status_id=".$i." and ampur_code_full='".$rowsCR[$n]['changwat_work_code'].$rowsCR[$n]['ampur_work_code']."' ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $count=$obj->rowCount();
        if ($count>0) {
            $evaluate_level_work=$i;
            break;
        }
        else {
            $sql=" select tambon_code_full from ampur a left join tambon t on a.ampur_code_full=t.ampur_code_full where t.risk_status_id=3 and tambon_code_full='".$rowsCR[$n]['changwat_work_code'].$rowsCR[$n]['ampur_work_code'].$rowsCR[$n]['tambon_work_code']."' ";
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
        if ($rowsCR[$n]['occupation_id']!="" & $rowsCR[$n]['occupation_id']!=99) {
            $evaluate_level=2;
        }
    }
        
    $sqlUp=" update covid_register set evaluate_level=".$evaluate_level." where covid_register_id=".$rowsCR[$n]['covid_register_id'];
    $objUp=$connect->prepare($sqlUp);
    $execute_status=$objUp->execute();
}

if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

$s=$sqlUp;
// $s="";
$x=array("sql"=>$s,"data"=>array("status"=>$status));
echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
