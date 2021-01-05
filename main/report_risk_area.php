<?php
error_reporting( error_reporting() & ~E_NOTICE );

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../include/config.php');
include('../include/functions.php');

$today=date("Y-m-d");
if (!isset($_POST['register_datetime'])){
    $_POST['register_datetime']=$today;
}
$sql_changwat_red="select a.changwat_code,c.changwat_name 
    from ampur a 
    left join changwat c on a.changwat_code=c.changwat_code 
    where a.risk_status_id=3 
    group by a.changwat_code";
$obj=$connect->prepare($sql_changwat_red);
$obj->execute();
$rows_changwat_red=$obj->fetchAll(PDO::FETCH_ASSOC);

$sql="
SELECT `f`.`ampur_in_code` AS `l|c||<br>_อำเภอ_รหัสอำเภอ`
,a.ampur_name as `l|c|รวม|<br>_อำเภอ_ชื่ออำเภอ`
,sum(if(left(register_datetime,10)='".$_POST['register_datetime']."',1,0)) `r|n|s|ลงทะเบียน_เข้าสกลนคร_ใหม่` 
,count(*) `r|n|s|ลงทะเบียน_เข้าสกลนคร_ทั้งหมด`  
";
$a_changwat_red=[];
foreach ($rows_changwat_red as $key => $value) {
    $sql_risk_3=" 
    sum(if(left(from_red,2)='".$value['changwat_code']."' and date_to_sakonnakhon =left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(สีแดง)_".$value['changwat_name']."_ใหม่`, 
    sum(if(left(from_red,2)='".$value['changwat_code']."' and date_to_sakonnakhon<=left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(สีแดง)_".$value['changwat_name']."_สะสม` 
    ";
    array_push($a_changwat_red,$sql_risk_3);
}
$sql_risk_3=",".implode(",",$a_changwat_red);
$sql_risk="
,sum(if(from_red is not null and from_red!='' and date_to_sakonnakhon =left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด_ใหม่` 
,sum(if(from_red is not null and from_red!='' and date_to_sakonnakhon<=left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด_สะสม` 
,sum(if(from_orange is not null and from_orange!='' and date_to_sakonnakhon =left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุม_ใหม่` 
,sum(if(from_orange is not null and from_orange!='' and date_to_sakonnakhon<=left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุม_สะสม` 
,sum(if(from_yellow is not null and from_yellow!='' and date_to_sakonnakhon =left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่เฝ้าระวังสูงสุด_ใหม่` 
,sum(if(from_yellow is not null and from_yellow!='' and date_to_sakonnakhon<=left('".$_POST['register_datetime']."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่เฝ้าระวังสูงสุด_สะสม` 
from from_risk f 
inner join ampur47 a on a.ampur_code=f.ampur_in_code 
where f.cut_status_id!=2 and left(f.register_datetime,10)<=left('".$_POST['register_datetime']."',10) 
group by a.ampur_code_full 
order by a.ampur_code_full 
";  
$sql=$sql.$sql_risk_3.$sql_risk;
// echo "<br><br><br>".$sql;
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
?>
<form id="search" method="post">
    <div class="form-group"  style="margin-top:60px; padding: 20px;">
        <label for="exampleFormControlInput1">วันที่เดินทางเข้าถึงสกลนคร </label>
        <div class="input-group mb-3">
        <input name="register_datetime" class="form-control datepicker" id="register_datetime" onkeydown="return false" value="<?php echo $_POST['register_datetime']; ?>"/>
        <div class="input-group-append">
            <button class="btn btn-outline-secondary btn-search" type="button">ค้นหา</button>
        </div>
        </div>
    </div>
</form>
<?php
$title="จำนวนผู้แจ้งเดินทางเข้าสกลนคร วันที่ ".thailongdate($_POST['register_datetime']);
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
            console.log(ampur_code,"<?php echo $_POST['register_datetime']; ?>");
        })
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true, //Set เป็นปี พ.ศ.
            autoclose: true,
        });
        $(".btn-search").click(function(){
            $("#search").submit();
        })
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