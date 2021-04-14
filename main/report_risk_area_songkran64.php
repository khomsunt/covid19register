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

// $date_start=date("2020-12-01");
// $date_end=date("Y-m-d");
// if ($_GET['register_datetime_start']!='') {
//     $date_start=substr($_GET['register_datetime_start'],0,10);
// }
// if ($_GET['register_datetime_end']!='') {
//     $date_end=substr($_GET['register_datetime_end'],0,10);
// }

$sql= " select 
concat(a.ampur_code,' ',a.ampur_name) `l|c||อำเภอ`
,count(*) `r|n|s|ทั้งหมด`
,sum(if(real_risk=203,1,0)) `r|n|s|สีเทา_ทั้งหมด`
,sum(if(real_risk=203 and left(date_to_sakonnakhon,10)=left(now(),10),1,0)) `r|n|s|สีเทา_วันนี้`
,sum(if(real_risk=202,1,0))  `r|n|s|สีส้ม_ทั้งหมด`
,sum(if(real_risk=202 and left(date_to_sakonnakhon,10)=left(now(),10),1,0))  `r|n|s|สีส้ม_วันนี้`
from from_real_risk_songkran64 r
inner join office o on office_code=r.hospcode
inner join ampur47 a on a.ampur_code=o.ampur_code
group by a.ampur_code;
";

$sql=$sql.$sql_risk_3.$sql_risk;
// echo "<br><br><br>".$sql;
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- <div style="padding: 20px; padding-top: 120px; max-width: 900px;">
    <div class="card" style="margin-bottom: 5px;">
        <div class="card-header">ตัวเลือกการแสดงรายงาน</div>
        <div class="card-body" style="padding: 5px; padding-left: 20px;">

            <div class="controls form-inline">
                <span style="margin-right: 10px;">วันที่เดินทางเข้าถึงสกลนคร ระหว่าง</span>
                <input name="register_datetime_start" class="form-control datepicker" id="register_datetime_start" onkeydown="return false" value="<?php echo $date_start; ?>" style="width: 120px; text-align: center;" />
                <span> &nbsp; ถึง &nbsp; </span>
                <input name="register_datetime_end" class="form-control datepicker" id="register_datetime_end" onkeydown="return false" value="<?php echo $date_end; ?>" style="width: 120px; text-align: center;" />
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_period">
                <label class="form-check-label" for="quarantine_period">
                    แสดงคอลัมน์ อยู่ระหว่างกักตัว (หมายถึง จำนวนผู้ที่อยู่ระหว่างกักตัว สะสม)
                </label>
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_complete">
                <label class="form-check-label" for="quarantine_complete">
                    แสดงคอลัมน์ กักตัวครบ14วัน (หมายถึง กักตัวครบ14วันแล้ว ทั้งที่ยังอยู่ในพื้นที่และที่ออกจากพื้นที่ไปแล้ว สะสม)
                </label>
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_escape">
                <label class="form-check-label" for="quarantine_escape">
                    แสดงคอลัมน์ ออกจากพื้นที่ (หมายถึง ออกจากพื้นที่ก่อนครบ14วัน สะสม)
                </label>
            </div>

            <div class="form-check" style="padding-top: 5px; padding-bottom: 5px;">
                <input type="checkbox" class="form-check-input" id="quarantine_unfilled">
                <label class="form-check-label" for="quarantine_unfilled">
                    แสดงคอลัมน์ ยังไม่ป้อนข้อมูล (หมายถึง ยังไม่ป้อนข้อมูล สะสม)
                </label>
            </div>

            <div style="text-align: right;">
                <button class="btn btn-success btn-search" type="button">ประมวลผล</button>
            </div>

        </div>
    </div>
</div> -->
<?php
$title="จำนวนผู้ที่จะเดินทางเข้าสกลนคร ตั้งแต่ 9 เมษายน 2564 เป็นต้นมา ";
include("./autoTable.php");
?>
<style>
    .cursor-hand{
        cursor:hand;
    }
</style>
<?php
include("./footer.php");
?>