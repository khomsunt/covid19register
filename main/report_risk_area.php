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

$sql_changwat_red="select a.changwat_code,c.changwat_name 
from ampur a 
left join changwat c on a.changwat_code=c.changwat_code 
where a.risk_status_id in (3,5) 
group by a.changwat_code";
$obj=$connect->prepare($sql_changwat_red);
$obj->execute();
$rows_changwat_red=$obj->fetchAll(PDO::FETCH_ASSOC);

if ($_GET['ampur_code']=='') {
    $sql="
    SELECT `f`.`ampur_in_code` AS `l|c||-_-_รหัสอำเภอ`
    ,a.ampur_name as `l|c|รวม|-_-_ชื่ออำเภอ`
    ,sum(if(left(register_datetime,10)='".$today."',1,0)) `r|n|s|ลงทะเบียน_เข้าสกลนคร_ใหม่` 
    ,count(*) `r|n|s|ลงทะเบียน_เข้าสกลนคร_ทั้งหมด`  
    ";
    $a_changwat_red=[];
    foreach ($rows_changwat_red as $key => $value) {
        $cc=$value['changwat_code'];
        $sql_risk_3=" 
        sum(if('".$cc."' in (left(from_red_strong,2),left(from_red,2)) and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ใหม่` 
        ,sum(if('".$cc."' in (left(from_red_strong,2),left(from_red,2)) and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_สะสม` 
        ";
        if ($_GET['quarantine_period']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (51)) or (left(from_red,2)='".$cc."' and real_risk in (31)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ระหว่างกักตัว` 
            ";
        }
        if ($_GET['quarantine_complete']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (5,52)) or (left(from_red,2)='".$cc."' and real_risk in (3,32)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_กักตัวครบ14วัน` 
            ";
        }
        if ($_GET['quarantine_escape']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (50)) or (left(from_red,2)='".$cc."' and real_risk in (30)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ออกจากพื้นที่` 
            ";
        }
        if ($_GET['quarantine_unfilled']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (59)) or (left(from_red,2)='".$cc."' and real_risk in (99)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ยังไม่ป้อนข้อมูล` 
            ";
        }
        array_push($a_changwat_red,$sql_risk_3);
    }
    $sql_risk_3=",".implode(",",$a_changwat_red);
    $sql_risk="
    ,sum(if( ((from_red_strong is not null and from_red_strong!='') or (from_red is not null and from_red!='')) and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ใหม่`
    ,sum(if(from_red is not null and from_red!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_สะสม` ";
    if ($_GET['quarantine_period']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (51)) or (from_red is not null and from_red!='' and real_risk in (31)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ระหว่างกักตัว` ";
    }
    if ($_GET['quarantine_complete']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (5,52)) or (from_red is not null and from_red!='' and real_risk in (3,32)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_กักตัวครบ14วัน` ";
    }
    if ($_GET['quarantine_escape']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (50)) or (from_red is not null and from_red!='' and real_risk in (30)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ออกจากพื้นที่` ";
    }
    if ($_GET['quarantine_unfilled']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (59)) or (from_red is not null and from_red!='' and real_risk in (99)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ยังไม่ป้อนข้อมูล` ";
    }
    $sql_risk.=" ,sum(if(from_red_weak is not null and from_red_weak!='' and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงอ่อน)_ใหม่` 
    ,sum(if(from_red_weak is not null and from_red_weak!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงอ่อน)_สะสม` 
    ,sum(if(from_orange is not null and from_orange!='' and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุม_ใหม่` 
    ,sum(if(from_orange is not null and from_orange!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุม_สะสม` 
    ,sum(if(from_yellow is not null and from_yellow!='' and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่เฝ้าระวังสูงสุด_ใหม่` 
    ,sum(if(from_yellow is not null and from_yellow!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่เฝ้าระวังสูงสุด_สะสม` 
    from from_real_risk f 
    inner join ampur47 a on a.ampur_code=f.ampur_in_code 
    where f.cut_status_id!=2 and left(f.register_datetime,10)<=left('".$today."',10) 
    group by a.ampur_code_full 
    order by a.ampur_code_full 
    ";
}
else {
    $sql="
    SELECT o.office_code AS `l|c||-_-_รหัส`
    ,if(o.office_name is not null,o.office_name,'(ไม่ระบุหมู่จำแนกหน่วยบริการไม่ได้)') as `l|c|รวม|-_-_หน่วยบริการ`
    ,sum(if(left(register_datetime,10)='".$today."',1,0)) `r|n|s|ลงทะเบียน_เข้าสกลนคร_ใหม่` 
    ,count(*) `r|n|s|ลงทะเบียน_เข้าสกลนคร_ทั้งหมด`  
    ";
    $a_changwat_red=[];
    foreach ($rows_changwat_red as $key => $value) {
        $cc=$value['changwat_code'];
        $sql_risk_3=" 
        sum(if('".$cc."' in (left(from_red_strong,2),left(from_red,2)) and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ใหม่` 
        ,sum(if('".$cc."' in (left(from_red_strong,2),left(from_red,2)) and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_สะสม` 
        ";
        if ($_GET['quarantine_period']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (51)) or (left(from_red,2)='".$cc."' and real_risk in (31)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ระหว่างกักตัว` 
            ";
        }
        if ($_GET['quarantine_complete']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (5,52)) or (left(from_red,2)='".$cc."' and real_risk in (3,32)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_กักตัวครบ14วัน` 
            ";
        }
        if ($_GET['quarantine_escape']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (50)) or (left(from_red,2)='".$cc."' and real_risk in (30)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ออกจากพื้นที่` 
            ";
        }
        if ($_GET['quarantine_unfilled']=='1') {
            $sql_risk_3.=" 
            ,sum(if( ( (left(from_red_strong,2)='".$cc."' and real_risk in (59)) or (left(from_red,2)='".$cc."' and real_risk in (99)) ) ,1,0)) `r|n|s|พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_".$value['changwat_name']."_ยังไม่ป้อนข้อมูล` 
            ";
        }
        array_push($a_changwat_red,$sql_risk_3);
    }
    $sql_risk_3=",".implode(",",$a_changwat_red);
    $sql_risk="
    ,sum(if( ((from_red_strong is not null and from_red_strong!='') or (from_red is not null and from_red!='')) and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ใหม่`
    ,sum(if(from_red is not null and from_red!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_สะสม` ";
    if ($_GET['quarantine_period']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (51)) or (from_red is not null and from_red!='' and real_risk in (31)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ระหว่างกักตัว` ";
    }
    if ($_GET['quarantine_complete']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (5,52)) or (from_red is not null and from_red!='' and real_risk in (3,32)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_กักตัวครบ14วัน` ";
    }
    if ($_GET['quarantine_escape']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (50)) or (from_red is not null and from_red!='' and real_risk in (30)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ออกจากพื้นที่` ";
    }
    if ($_GET['quarantine_unfilled']=='1') {
        $sql_risk.="
        ,sum(if( ( (from_red_strong is not null and from_red_strong!='' and real_risk in (59)) or (from_red is not null and from_red!='' and real_risk in (99)) ) ,1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงเข้มและแดง)_ยังไม่ป้อนข้อมูล` ";
    }
    $sql_risk.=" ,sum(if(from_red_weak is not null and from_red_weak!='' and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงอ่อน)_ใหม่` 
    ,sum(if(from_red_weak is not null and from_red_weak!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุมสูงสุด(แดงอ่อน)_สะสม` 
    ,sum(if(from_orange is not null and from_orange!='' and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุม_ใหม่` 
    ,sum(if(from_orange is not null and from_orange!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่ควบคุม_สะสม` 
    ,sum(if(from_yellow is not null and from_yellow!='' and real_date_to_sakonnakhon =left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่เฝ้าระวังสูงสุด_ใหม่` 
    ,sum(if(from_yellow is not null and from_yellow!='' and real_date_to_sakonnakhon<=left('".$today."',10),1,0)) `r|n|s|แบ่งตามพื้นที่_พื้นที่เฝ้าระวังสูงสุด_สะสม` 
    from from_risk f 
    inner join ampur47 a on a.ampur_code=f.ampur_in_code 
    left join office o on o.office_code=f.hospcode
    where f.cut_status_id!=2 and left(f.register_datetime,10)<=left('".$today."',10) and a.ampur_code='".$_GET['ampur_code']."'
    group by f.hospcode 
    order by o.office_type, o.office_code 
    ";
}

$sql=$sql.$sql_risk_3.$sql_risk;
// echo "<br><br><br>".$sql;
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
?>
<div style="padding: 20px; padding-top: 80px; max-width: 900px;">
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-header">ตัวเลือกการแสดงรายงาน</div>
        <div class="card-body" style="padding: 5px; padding-left: 20px;">

            <div class="controls form-inline">
                <div style="margin-right: 10px;">วันที่เดินทางเข้าถึงสกลนคร</div>
                <div>
                    <input name="register_datetime" class="form-control datepicker" id="register_datetime" onkeydown="return false" value="<?php echo $today; ?>" style="width: 120px; text-align: center;" />
                </div>
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_period">
                <label class="form-check-label" for="quarantine_period">
                    แสดงคอลัมน์ อยู่ระหว่างกักตัว (หมายถึง จำนวนผู้ที่อยู่ระหว่างกักตัว สะสม ณ วันเวลาที่ประมวลผลรายงาน)
                </label>
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_complete">
                <label class="form-check-label" for="quarantine_complete">
                    แสดงคอลัมน์ กักตัวครบ14วัน (หมายถึง กักตัวครบ14วันแล้ว ทั้งที่ยังอยู่ในพื้นที่และที่ออกจากพื้นที่ไปแล้ว สะสม ณ วันเวลาที่ประมวลผลรายงาน)
                </label>
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_escape">
                <label class="form-check-label" for="quarantine_escape">
                    แสดงคอลัมน์ ออกจากพื้นที่ (หมายถึง ออกจากพื้นที่ก่อนครบ14วัน สะสม ณ วันเวลาที่ประมวลผลรายงาน)
                </label>
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_unfilled">
                <label class="form-check-label" for="quarantine_unfilled">
                    แสดงคอลัมน์ ยังไม่ป้อนข้อมูล (หมายถึง ยังไม่ป้อนข้อมูล สะสม ณ วันเวลาที่ประมวลผลรายงาน)
                </label>
            </div>

            <div style="text-align: right;">
                <button class="btn btn-success btn-search" type="button">ประมวลผล</button>
            </div>

        </div>
    </div>
</div>
<?php
$title="จำนวนผู้แจ้งเดินทางเข้าสกลนคร วันที่ ".thailongdate($today);
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

        $('#quarantine_period').prop('checked','<?php echo $_GET['quarantine_period']; ?>'==1?true:false);
        $('#quarantine_complete').prop('checked','<?php echo $_GET['quarantine_complete']; ?>'==1?true:false);
        $('#quarantine_escape').prop('checked','<?php echo $_GET['quarantine_escape']; ?>'==1?true:false);
        $('#quarantine_unfilled').prop('checked','<?php echo $_GET['quarantine_unfilled']; ?>'==1?true:false);

        $('.-_-_ชื่ออำเภอ').addClass("cursor-hand").click(function(){
            let ampur_code=$(this).parent().parent().children().find("div").html().trim();
            // console.log(ampur_code,"<?php echo $today; ?>");
            var x=location.href.split('/');
            var u=x[x.length-1];
            var e=u.split('?');
            window.location=e[0]+'?register_datetime='+$('#register_datetime').val()+'&ampur_code='+ampur_code;
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true, //Set เป็นปี พ.ศ.
            autoclose: true,
        });

        $(".btn-search").click(function(){
            var x=location.href.split('/');
            var u=x[x.length-1];
            var e=u.split('?');
            var a=[];
            a.push('register_datetime='+$('#register_datetime').val());
            if ($("#quarantine_period").prop('checked')==true) {
                a.push("quarantine_period=1");
            }
            if ($("#quarantine_complete").prop('checked')==true) {
                a.push("quarantine_complete=1");
            }
            if ($("#quarantine_escape").prop('checked')==true) {
                a.push("quarantine_escape=1");
            }
            if ($("#quarantine_unfilled").prop('checked')==true) {
                a.push("quarantine_unfilled=1");
            }
            var url_params="";
            if (a.length>0) {
                url_params="?"+a.join('&');
            }
            window.location=e[0]+url_params;
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
$c_red_count="";
$c_red_list="";
$c_red_weak_count="";
$c_red_weak_list="";
$c_orange_count="";
$c_orange_list="";
$c_yellow_count="";
$c_yellow_list="";

for ($i=0;$i<count($rows);$i=$i+1) {
  if ($rows[$i]['risk_level']==5) {
    $c_red_strong_count=$rows[$i]['c_count'];
    $c_red_strong_list=$rows[$i]['c_name'];
  }
  if ($rows[$i]['risk_level']==3) {
    $c_red_count=$rows[$i]['c_count'];
    $c_red_list=$rows[$i]['c_name'];
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
<br><b>1. พื้นที่ควบคุมสูงสุด</b> จำนวน <?php echo ($c_red_strong_count+$c_red_count+$c_red_weak_count); ?> จังหวัด แบ่งเป็น 2 กลุ่มย่อย
<div style="padding-left: 30px;">
    <b>1.1 กลุ่มสีแดงเข้ม</b> จำนวน <?php echo $c_red_strong_count; ?> จังหวัด ได้แก่ <?php echo $c_red_strong_list; ?>
    <br><b>1.1 กลุ่มสีแดง</b> จำนวน <?php echo $c_red_count; ?> จังหวัด ได้แก่ <?php echo $c_red_list; ?>
    <br><b>1.2 กลุ่มสีแดงอ่อน</b> จำนวน <?php echo $c_red_weak_count; ?> จังหวัด ได้แก่ <?php echo $c_red_weak_list; ?>
</div>
<b>2. พื้นที่ควบคุม</b> จำนวน <?php echo $c_orange_count; ?> จังหวัด ได้แก่ <?php echo $c_orange_list; ?>
<br><b>3. พื้นที่เฝ้าระวังสูงสุด</b> จำนวน <?php echo $c_yellow_count; ?> จังหวัด ได้แก่ <?php echo $c_yellow_list; ?>
</div>
<?php
include("./footer.php");
?>