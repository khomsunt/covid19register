<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../include/config.php');

$checkpoint_token=isset($_GET['checkpoint_id'])?$_GET['checkpoint_id']:null;

$sql="select * from checkpoint_qrcode where token=:checkpoint_token limit 1 ";
$obj=$connect->prepare($sql);
$obj->execute([ 'checkpoint_token' => $checkpoint_token ]);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
$rows_count=$obj->rowCount();
if ($rows_count>0) {
  $checkpoint_office_id=$rows[0]['office_id'];
}
else {
  $checkpoint_office_id='';
}

// echo "<br>".$sql;
// echo "<br>checkpoint_token-".$checkpoint_token;
// echo "<br>checkpoint_office_id-".$checkpoint_office_id;

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

$villcode="47".$_POST['ampur_in_code'].$_POST['tambon_in_code'].$_POST['moo_in_code'];
$sqlV="select * from village where status_id=1 and villcode=:villcode order by id limit 1 ";
// $sqlV="select * from village where status_id=1 and villcode='".$villcode."' order by id limit 1 ";
$objV=$connect->prepare($sqlV);
$objV->execute([ 'villcode' => $villcode ]);
// $objV->execute();
$count_village=$objV->rowCount();
$rows_village=$objV->fetchAll(PDO::FETCH_ASSOC);
$hospcode="";
if ($count_village>0) {
    $hospcode=$rows_village[0]['pcucode'];
}

// $register_user_id='null';
// if ($_SESSION['user_id']!='') {
//     $register_user_id=$_SESSION['user_id'];
// }

$register_user_id=(isset($_SESSION['user_id']))?$_SESSION['user_id']:'null';
$date_out_sakonnakhon=($_POST['date_out_sakonnakhon_db']!="")?",'".$_POST['date_out_sakonnakhon_db']."' ":",null";
$checkpoint_id=($_POST['checkpoint_id']!="")?",'".$_POST['checkpoint_id']."' ":",null";

$sql=" insert into covid_register ( ". 
" fname,lname,cid,tel,occupation_id ".
" ,tambon_out_code,ampur_out_code,changwat_out_code ". 
" ,tambon_work_code,ampur_work_code,changwat_work_code ". 
" ,date_to_sakonnakhon ". 
" ,house_in_no,moo_in_code,tambon_in_code,ampur_in_code ". 
// " ,risk_level_id,auto_cut_status_id ".
" ,evaluate_level,date_to_sakonnakhon_text,note,hospcode,moo_in_code_new,register_user_id,date_out_sakonnakhon ".
" ,checkpoint_id,age_range_id,road_soi_in ".
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
",'".$_POST['date_to_sakonnakhon_db']."' ".
",'".$_POST['house_in_no']."' ".
",'".$_POST['moo_in_code']."' ".
",'".$_POST['tambon_in_code']."' ".
",'".$_POST['ampur_in_code']."' ".
// ",".$risk_level_id.
// ",".$auto_cut_status_id.
",".$evaluate_level.
",'".$_POST['date_to_sakonnakhon']."' ".
",'".$_POST['note']."' ".
",'".$hospcode."'".
",'".$_POST['moo_in_code']."' ".
",".$register_user_id."".
$date_out_sakonnakhon.
$checkpoint_id.
",'".$_POST['age_range_id']."' ".
",'".$_POST['road_soi_in']."' ".
" ) ";

// echo $sql;

$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
$registerLastInsertId=$connect->lastInsertId();
// echo "<br><br><br>---- ".$registerLastInsertId;
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>รายงานตัวเข้าสกลนคร</title>
  <script src="../js/jquery-3.5.1.min.js"></script>
</head>

<body style="background-color: #b9ddff;  background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: 500px; background-position: top right;">
</body>
</html>
<script>
function goPageSuggestion() {
  window.location="suggestion_skn.php?registerLastInsertId=<?php echo $registerLastInsertId;?>&cid=<?php echo $_POST['cid'];?>&tel=<?php echo $_POST['tel'];?>";
};
goPageSuggestion();
</script>