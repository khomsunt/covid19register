<?php
error_reporting( error_reporting() & ~E_NOTICE );

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}

include('../include/config.php');
include('../include/functions.php');

$date_start=date("2020-12-01");
$date_end=date("Y-m-d");
if ($_GET['register_datetime_start']!='') {
    $date_start=substr($_GET['register_datetime_start'],0,10);
}
if ($_GET['register_datetime_end']!='') {
    $date_end=substr($_GET['register_datetime_end'],0,10);
}

// echo "<br><br><br>";
// echo "<br><br><br>";
// echo "<br><br><br>";

// var_dump($_SESSION);

$office_code=$_SESSION['office_code'];
// $office_code='05443';
// echo "<br>A- ".$_SESSION['office_code'];
// echo "<br>B- ".$office_code;

if ($office_code=='00034') {
  $query_office_code="";
}
else {
  $query_office_code=" r.hospcode='".$office_code."' and ";
}

$sql=" select 
r.date_to_sakonnakhon `l|d||วันเข้าสกลนคร`
,af.ampur_name `l|c||อำเภอ`
,concat(r.hospcode,' ',replace(f.office_name,'โรงพยาบาลส่งเสริมสุขภาพตำบล','รพ.สต.')) `l|c||หน่วยบริการ`
,ff.office_name `l|c||FLIGHT`
,r.seat_on_flight `l|c||SEAT`
,asr.airport_screen_result_name `l|c||ผลคัดกรองที่สนามบิน`
,fname `l|c||ชื่อ`
,lname `l|c||สกุล`
,cid `l|c||เลขบัตรประชาชน`
,tel `l|c||โทรศัพท์`
,o.occupation_name `l|c||อาชีพ`
,ca.changwat_name `l|c||ที่อยู่ก่อนเข้าสกลนคร_จังหวัด`
,aa.ampur_name `l|c||ที่อยู่ก่อนเข้าสกลนคร_อำเภอ`
,cb.changwat_name `l|c||ที่ทำงานก่อนเข้าสกลนคร_จังหวัด`
,ab.ampur_name `l|c||ที่ทำงานก่อนเข้าสกลนคร_อำเภอ`
,house_in_no `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_เลขที่`
,moo_in_code+0 `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_หมู่`
,t1.tambon_name `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_ตำบล`
,a1.ampur_name `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_อำเภอ`
from covid_register r
inner join office ff on ff.office_id=r.checkpoint_id 
left join office f on f.office_code=r.hospcode 
left join ampur47 af on af.ampur_code_full=concat('47',r.ampur_in_code)
left join coccupation o on o.occupation_id=r.occupation_id
left join changwat ca on ca.changwat_code=r.changwat_out_code
left join ampur aa on aa.ampur_code_full=concat(r.changwat_out_code,r.ampur_out_code)
left join changwat cb on cb.changwat_code=r.changwat_work_code
left join ampur ab on ab.ampur_code_full=concat(r.changwat_work_code,r.ampur_work_code)
left join ampur47 a1 on a1.ampur_code_full=concat(changwat_in_code,ampur_in_code)
left join tambon47 t1 on t1.tambon_code_full=concat(changwat_in_code,ampur_in_code,tambon_in_code)
left join airport_screen_result asr on asr.airport_screen_result_id=r.airport_screen_result_id
where r.checkpoint_id in (407,408,409,410)
order by r.date_to_sakonnakhon,af.ampur_code,concat(r.hospcode,r.moo_in_code),f.office_name,r.fname,r.lname
";
// echo "<br><br><br><br><br><br>".$sql;
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

$title="รายชื่อผู้รายงานตัวเข้าสกลนครเดินทางด้วยเครื่องบิน";
include("./autoTable.php");
?>
<link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>
<style>
    .cursor-hand{
        cursor:hand;
    }
</style>
<script>
// $(function(){
// })
</script>
<?php
include("./footer.php");
?>