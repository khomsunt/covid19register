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
af.ampur_name `l|c||อำเภอ`
,hospcode `l|c||รหัส`
,replace(office_name,'โรงพยาบาลส่งเสริมสุขภาพตำบล','รพ.สต.') `l|c||หน่วยบริการ`
,fname `l|c||ชื่อ`
,lname `l|c||สกุล`
,cid `l|c||เลขบัตรประชาชน`
,tel `l|c||โทรศัพท์`
,o.occupation_name `l|c||อาชีพ`
,ca.changwat_name `l|c||ที่อยู่ก่อนเข้าสกลนคร_จังหวัด`
,aa.ampur_name `l|c||ที่อยู่ก่อนเข้าสกลนคร_อำเภอ`
,cb.changwat_name `l|c||ที่ทำงานก่อนเข้าสกลนคร_จังหวัด`
,ab.ampur_name `l|c||ที่ทำงานก่อนเข้าสกลนคร_อำเภอ`
,r.date_to_sakonnakhon `l|c||วันที่จะเข้าสกลนคร`
,house_in_no `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_เลขที่`
,moo_in_code+0 `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_หมู่`
,t1.tambon_name `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_ตำบล`
,a1.ampur_name `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_อำเภอ`
from covid_register r
left join office f on f.office_code=r.hospcode
left join ampur47 af on af.ampur_code=f.ampur_code
left join coccupation o on o.occupation_id=r.occupation_id
left join changwat ca on ca.changwat_code=r.changwat_out_code
left join ampur aa on aa.ampur_code_full=concat(r.changwat_out_code,r.ampur_out_code)
left join changwat cb on cb.changwat_code=r.changwat_work_code
left join ampur ab on ab.ampur_code_full=concat(r.changwat_work_code,r.ampur_work_code)
left join ampur47 a1 on a1.ampur_code_full=concat(changwat_in_code,ampur_in_code)
left join tambon47 t1 on t1.tambon_code_full=concat(changwat_in_code,ampur_in_code,tambon_in_code)
where ".$query_office_code.
" (changwat_out_code in ('10','74','11','75','12','73','13','63','70') or changwat_work_code in ('10','74','11','75','12','73','13','63','70'))
and !(concat(changwat_out_code,ampur_out_code) in ('7401','7402','1303','1306','1040','1022','1039','1033','1021','1101','1203','5001','2004','7707','2701')
or concat(changwat_work_code,ampur_work_code) in ('7401','7402','1303','1306','1040','1022','1039','1033','1021','1101','1203','5001','2004','7707','2701'))
and date_to_sakonnakhon between '2021-04-09' and now()
order by af.ampur_code,r.hospcode,r.date_to_sakonnakhon
";
$sql=" select 
af.ampur_name `l|c||อำเภอ`
,hospcode `l|c||รหัส`
,replace(office_name,'โรงพยาบาลส่งเสริมสุขภาพตำบล','รพ.สต.') `l|c||หน่วยบริการ`
,fname `l|c||ชื่อ`
,lname `l|c||สกุล`
,cid `l|c||เลขบัตรประชาชน`
,tel `l|c||โทรศัพท์`
,o.occupation_name `l|c||อาชีพ`
,ca.changwat_name `l|c||ที่อยู่ก่อนเข้าสกลนคร_จังหวัด`
,aa.ampur_name `l|c||ที่อยู่ก่อนเข้าสกลนคร_อำเภอ`
,cb.changwat_name `l|c||ที่ทำงานก่อนเข้าสกลนคร_จังหวัด`
,ab.ampur_name `l|c||ที่ทำงานก่อนเข้าสกลนคร_อำเภอ`
,r.date_to_sakonnakhon `l|c||วันที่จะเข้าสกลนคร`
,house_in_no `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_เลขที่`
,moo_in_code+0 `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_หมู่`
,t1.tambon_name `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_ตำบล`
,a1.ampur_name `l|c||ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก_อำเภอ`
from from_real_risk_songkran64 r
left join office f on f.office_code=r.hospcode
left join ampur47 af on af.ampur_code=f.ampur_code
left join coccupation o on o.occupation_id=r.occupation_id
left join changwat ca on ca.changwat_code=r.changwat_out_code
left join ampur aa on aa.ampur_code_full=concat(r.changwat_out_code,r.ampur_out_code)
left join changwat cb on cb.changwat_code=r.changwat_work_code
left join ampur ab on ab.ampur_code_full=concat(r.changwat_work_code,r.ampur_work_code)
left join ampur47 a1 on a1.ampur_code_full=concat(changwat_in_code,ampur_in_code)
left join tambon47 t1 on t1.tambon_code_full=concat(changwat_in_code,ampur_in_code,tambon_in_code)
where ".$query_office_code." 
real_risk = 202
and date_to_sakonnakhon between '2021-04-09' and now()
order by af.ampur_code,r.hospcode,r.date_to_sakonnakhon
";

// echo "<br><br><br>".$sql;
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

$title="รายชื่อผู้รายงานตัวเข้าสกลนคร กลุ่มสีส้ม ตามวันที่แจ้งจะเข้าสกลนคร ตั้งแต่วันที่ 9 เมษายน 2564";
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

    //     $('#quarantine_period').prop('checked','<?php echo $_GET['quarantine_period']; ?>'==1?true:false);
    //     $('#quarantine_complete').prop('checked','<?php echo $_GET['quarantine_complete']; ?>'==1?true:false);
    //     $('#quarantine_escape').prop('checked','<?php echo $_GET['quarantine_escape']; ?>'==1?true:false);
    //     $('#quarantine_unfilled').prop('checked','<?php echo $_GET['quarantine_unfilled']; ?>'==1?true:false);

    //     $('.-_-_ชื่ออำเภอ').addClass("cursor-hand").click(function(){
    //         var x=location.href.split('/');
    //         var u=x[x.length-1];
    //         var e=u.split('?');
    //         var a=[];
    //         let ampur_code=$(this).parent().parent().children().find("span").html().trim();
    //         a.push('ampur_code='+ampur_code);
    //         a.push('register_datetime_start='+$('#register_datetime_start').val());
    //         a.push('register_datetime_end='+$('#register_datetime_end').val());
    //         if ($("#quarantine_period").prop('checked')==true) {
    //             a.push("quarantine_period=1");
    //         }
    //         if ($("#quarantine_complete").prop('checked')==true) {
    //             a.push("quarantine_complete=1");
    //         }
    //         if ($("#quarantine_escape").prop('checked')==true) {
    //             a.push("quarantine_escape=1");
    //         }
    //         if ($("#quarantine_unfilled").prop('checked')==true) {
    //             a.push("quarantine_unfilled=1");
    //         }
    //         var url_params="";
    //         if (a.length>0) {
    //             url_params="?"+a.join('&');
    //         }
    //         window.location=e[0]+url_params;
    //     });

    //     $('.datepicker').datepicker({
    //         format: 'yyyy-mm-dd',
    //         todayBtn: false,
    //         language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
    //         thaiyear: true, //Set เป็นปี พ.ศ.
    //         autoclose: true,
    //     });

    //     $(".btn-search").click(function(){
    //         var x=location.href.split('/');
    //         var u=x[x.length-1];
    //         var e=u.split('?');
    //         var a=[];
    //         a.push('register_datetime_start='+$('#register_datetime_start').val());
    //         a.push('register_datetime_end='+$('#register_datetime_end').val());
    //         if ($("#quarantine_period").prop('checked')==true) {
    //             a.push("quarantine_period=1");
    //         }
    //         if ($("#quarantine_complete").prop('checked')==true) {
    //             a.push("quarantine_complete=1");
    //         }
    //         if ($("#quarantine_escape").prop('checked')==true) {
    //             a.push("quarantine_escape=1");
    //         }
    //         if ($("#quarantine_unfilled").prop('checked')==true) {
    //             a.push("quarantine_unfilled=1");
    //         }
    //         var url_params="";
    //         if (a.length>0) {
    //             url_params="?"+a.join('&');
    //         }
    //         window.location=e[0]+url_params;
    //     });
    // })
</script>
<?php
// $sql=" 
// select risk_level,group_concat(concat(changwat_name,' ') order by CONVERT (changwat_name USING tis620) asc) c_name,count(*) c_count from (
//   select c.changwat_code,c.changwat_name,max(a.risk_status_id) risk_level from changwat c
//   inner join ampur a on a.changwat_code=c.changwat_code
//   where c.changwat_code<>'99'
//   group by c.changwat_code
// ) x group by risk_level
// ";

// $obj=$connect->prepare($sql);
// $obj->execute();
// $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// $c_red_strong_count="";
// $c_red_strong_list="";
// $c_red_count="";
// $c_red_list="";
// $c_red_weak_count="";
// $c_red_weak_list="";
// $c_orange_count="";
// $c_orange_list="";
// $c_yellow_count="";
// $c_yellow_list="";

// for ($i=0;$i<count($rows);$i=$i+1) {
//   if ($rows[$i]['risk_level']==5) {
//     $c_red_strong_count=$rows[$i]['c_count'];
//     $c_red_strong_list=$rows[$i]['c_name'];
//   }
//   if ($rows[$i]['risk_level']==3) {
//     $c_red_count=$rows[$i]['c_count'];
//     $c_red_list=$rows[$i]['c_name'];
//   }
//   if ($rows[$i]['risk_level']==4) {
//     $c_red_weak_count=$rows[$i]['c_count'];
//     $c_red_weak_list=$rows[$i]['c_name'];
//   }
//   if ($rows[$i]['risk_level']==2) {
//     $c_orange_count=$rows[$i]['c_count'];
//     $c_orange_list=$rows[$i]['c_name'];
//   }
//   if ($rows[$i]['risk_level']==1) {
//     $c_yellow_count=$rows[$i]['c_count'];
//     $c_yellow_list=$rows[$i]['c_name'];
//   }
// }

?>
<!-- <div style="padding-left: 20px; padding-bottom: 50px;">
<b>หมายเหตุ</b>
<br><b>1. พื้นที่ควบคุมสูงสุด</b> จำนวน <?php echo ($c_red_strong_count+$c_red_count+$c_red_weak_count); ?> จังหวัด แบ่งเป็น 2 กลุ่มย่อย
<div style="padding-left: 30px;">
    <b>1.1 กลุ่มสีแดงเข้ม</b> จำนวน <?php echo $c_red_strong_count; ?> จังหวัด ได้แก่ <?php echo $c_red_strong_list; ?>
    <br><b>1.1 กลุ่มสีแดง</b> จำนวน <?php echo $c_red_count; ?> จังหวัด ได้แก่ <?php echo $c_red_list; ?>
    <br><b>1.2 กลุ่มสีแดงอ่อน</b> จำนวน <?php echo $c_red_weak_count; ?> จังหวัด ได้แก่ <?php echo $c_red_weak_list; ?>
</div>
<b>2. พื้นที่ควบคุม</b> จำนวน <?php echo $c_orange_count; ?> จังหวัด ได้แก่ <?php echo $c_orange_list; ?>
<br><b>3. พื้นที่เฝ้าระวังสูงสุด</b> จำนวน <?php echo $c_yellow_count; ?> จังหวัด ได้แก่ <?php echo $c_yellow_list; ?>
<br><b>4. ใหม่* </b> หมายถึง รายใหม่ ณ วันที่ <?php echo thailongdate($date_end); ?>
</div> -->
<?php
include("./footer.php");
?>