<?php
error_reporting( error_reporting() & ~E_NOTICE );

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../include/config.php');
include('../include/functions.php');

$today=date("Y-m-d");
if ($_GET['register_datetime']!='') {
    $today=substr($_GET['register_datetime'],0,10);
}

$sql="
SELECT real_risk_area_changwat `|c||รหัส` 
,c.changwat_name `l|c|รวม|ชื่อจังหวัด` 
,SUM(arrived_skn_new_case) `r|n|s|รายใหม่` 
,SUM(in_14_days) `r|n|s|อยู่ระหว่างกักตัว` 
,SUM(complete_14_days) `r|n|s|กักตัวครบ14วัน` 
,SUM(no_data_arrived_date) `r|n|s|ไม่มีข้อมูลวันเข้าสกลนคร` 
FROM (
	SELECT covid_register_id,hospcode,real_date_to_sakonnakhon,real_risk_area_changwat
	,IF(real_date_to_sakonnakhon='".$today."',1,0) arrived_skn_new_case
	,TIMESTAMPDIFF(DAY,real_date_to_sakonnakhon,'".$today."') days_count
	,IF(TIMESTAMPDIFF(DAY,real_date_to_sakonnakhon,'".$today."')<=14,1,0) in_14_days
	,IF(TIMESTAMPDIFF(DAY,real_date_to_sakonnakhon,'".$today."')>14,1,0) complete_14_days
	,IF(real_date_to_sakonnakhon IS NULL OR real_date_to_sakonnakhon='0000-00-00',1,0) no_data_arrived_date
	FROM from_real_risk 
	WHERE cut_status_id!=2
) z
INNER JOIN (
	SELECT changwat_code FROM ampur a WHERE risk_status_id=3 GROUP BY changwat_code
) a ON a.changwat_code=z.real_risk_area_changwat
INNER JOIN changwat c ON c.changwat_code=a.changwat_code
GROUP BY real_risk_area_changwat
";
// echo "<br><br><br>".$sql;
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
?>
<form id="search" method="post">
    <div class="form-group"  style="margin-top:60px; padding: 20px;">
        <label for="exampleFormControlInput1">วันที่เดินทางเข้าถึงสกลนคร </label>
        <div class="input-group mb-3">
        <input name="register_datetime" class="form-control datepicker" id="register_datetime" onkeydown="return false" value="<?php echo $today; ?>"/>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-search" type="button">ค้นหา</button>
        </div>
        </div>
    </div>
</form>
<?php
$title="จำนวนกลุ่มเสี่ยงสูงสุด(สีแดง)ที่กักตัว ณ วันที่ ".thailongdate($today);
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
    $(function(){
        $(".ชื่ออำเภอ").addClass("cursor-hand");
        $(".ชื่ออำเภอ").click(function(){
            let ampur_code=$(this).parent().parent().children().find("div").html().trim();
            // console.log(ampur_code,"<?php echo $_GET['register_datetime']; ?>");
            var x=location.href.split('/');
            var u=x[x.length-1];
            var e=u.split('?');
            window.location=e[0]+'?register_datetime='+$('#register_datetime').val()+'&ampur_code='+ampur_code;
        });

        $(".ชื่อจังหวัด").addClass("cursor-hand");
        $(".ชื่อจังหวัด").click(function(){
            let changwat_code=$(this).parent().parent().children().find("div").html().trim();
            // console.log(changwat_code,"<?php echo $_GET['register_datetime']; ?>");
            var x=location.href.split('/');
            var u=x[x.length-1];
            var e=u.split('?');
            window.location=e[0]+'?register_datetime='+$('#register_datetime').val()+'&changwat_code='+changwat_code;
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true, //Set เป็นปี พ.ศ.
            autoclose: true,
        });
        $(".btn-search").click(function(){
            // $("#search").submit();
            var x=location.href.split('/');
            var u=x[x.length-1];
            var e=u.split('?');
            window.location=e[0]+'?register_datetime='+$('#register_datetime').val();
        });
    })
</script>
<?php
$sql=" 
select risk_level,group_concat(concat(changwat_name,' ') order by CONVERT (changwat_name USING tis620) asc) c_name,count(*) c_count from (
  select c.changwat_code,c.changwat_name,max(a.risk_status_id) risk_level from changwat c
  inner join ampur a on a.changwat_code=c.changwat_code
  where c.changwat_code<>'99'
  group by c.changwat_code
) x group by risk_level
";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
$c_red_strong_count="";
$c_red_strong_list="";
$c_red_weak_count="";
$c_red_weak_list="";
$c_orange_count="";
$c_orange_list="";
$c_yellow_count="";
$c_yellow_list="";
for ($i=0;$i<count($rows);$i=$i+1) {
  if ($rows[$i]['risk_level']==3) {
    $c_red_strong_count=$rows[$i]['c_count'];
    $c_red_strong_list=$rows[$i]['c_name'];
  }
  if ($rows[$i]['risk_level']==4) {
    $c_red_weak_count=$rows[$i]['c_count'];
    $c_red_weak_list=$rows[$i]['c_name'];
  }
  if ($rows[$i]['risk_level']==2) {
    $c_orange_count=$rows[$i]['c_count'];
    $c_orange_list=$rows[$i]['c_name'];
  }
  if ($rows[$i]['risk_level']==1) {
    $c_yellow_count=$rows[$i]['c_count'];
    $c_yellow_list=$rows[$i]['c_name'];
  }
}

?>
<div style="padding-left: 20px; padding-bottom: 50px;">
<b>หมายเหตุ</b>
<br><b>1. พื้นที่ควบคุมสูงสุด</b> จำนวน <?php echo ($c_red_strong_count+$c_red_weak_count); ?> จังหวัด แบ่งเป็น 2 กลุ่มย่อย
<div style="padding-left: 30px;">
    <b>1.1 กลุ่มสีแดง</b> จำนวน <?php echo $c_red_strong_count; ?> จังหวัด ได้แก่ <?php echo $c_red_strong_list; ?>
    <br><b>1.2 กลุ่มสีแดงอ่อน</b> จำนวน <?php echo $c_red_weak_count; ?> จังหวัด ได้แก่ <?php echo $c_red_weak_list; ?>
</div>
<b>2. พื้นที่ควบคุม</b> จำนวน <?php echo $c_orange_count; ?> จังหวัด ได้แก่ <?php echo $c_orange_list; ?>
<br><b>3. พื้นที่เฝ้าระวังสูงสุด</b> จำนวน <?php echo $c_yellow_count; ?> จังหวัด ได้แก่ <?php echo $c_yellow_list; ?>
</div>
<?php
include("./footer.php");
?>