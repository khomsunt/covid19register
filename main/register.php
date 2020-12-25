<?php 
include('../include/config.php');

$changwat_code_samut_sakhon='74';

function thaiDateShort($d) {
  $r=$d;
  if (strlen($r)==10) {
    $x=explode("-",$r);
    $r=$x[2]." ".thaiMonthShort($x[1])." ".($x[0]+543);
  }
  return $r;
}

function thaiMonthShort($x) {
  $r=$x;
  switch ($x+0) {
    case 1:$r="ม.ค."; break;
    case 2:$r="ก.พ."; break;
    case 3:$r="มี.ค."; break;
    case 4:$r="เม.ย."; break;
    case 5:$r="พ.ค."; break;
    case 6:$r="มิ.ย."; break;
    case 7:$r="ก.ค."; break;
    case 8:$r="ส.ค."; break;
    case 9:$r="ก.ย."; break;
    case 10:$r="ต.ค."; break;
    case 11:$r="พ.ย."; break;
    case 12:$r="ธ.ค."; break;
  }
  return $r;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>register</title>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>

    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/"> -->

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <!-- <link href="../css/floating-labels.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>
  </head>

<body style="background-color: #b9ddff;">

<script>
var input_required=['fname','lname','cid','tel','ampur_in_code','tambon_in_code','moo_in_code'];
$(document).ready(function () {
  $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: true,
      language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
      thaiyear: true, //Set เป็นปี พ.ศ.
      autoclose: true
  });
  // }).datepicker("setDate", "0");//กำหนดเป็นวันปัจุบัน

  $(".required").css({
    'color':'red',
    'visibility':'hidden'
  });

  input_required.forEach(element => {
    $("#"+element).parent().find(".required").text(" *จำเป็น").css({'visibility':'visible'});
  });
});
</script>


<div class="container" style="background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: contain, cover; background-position: top center;">

  <div style="height: 100;"><br></div>
  <div style="display: flex; align-items: flex-start;">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
  </div>

  <h2 style="text-align:center; margin-top: 20px; margin-bottom: 20px;">ระบบรายงานตัวและคัดกรองความเสี่ยง COVID-19 จังหวัดสกลนคร</h2>

  <div class="form-group">
    <label for="exampleFormControlSelect1">คำนำหน้าชื่อ <span class="required"></span></label>
    <select class="form-control" id="prename_id">
    <option value="">--เลือก--</option>
<?php
$sql="select * from `prename` ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["prename_id"]."'>".$rows[$i]["prename_name"]."</option>";
}
?>
    </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">ชื่อ <span class="required"></span></label>
      <input type="text" class="form-control" id="fname" placeholder="ชื่อ">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">นามสกุล <span class="required"></span></label>
      <input type="text" class="form-control" id="lname" placeholder="นามสกุล">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">เลขบัตรประจำตัวประชาชน <span class="required"></span></label>
      <input type="text" class="form-control" id="cid" placeholder="เลขบัตรประจำตัวประชาชน">
    </div>
  
    <div class="form-group">
      <label for="exampleFormControlInput1">เบอร์โทรศัพท์ <span class="required"></span></label>
      <input type="text" class="form-control" id="tel" placeholder="เบอร์โทรศัพท์">
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">อาชีพ <span class="required"></span></label>
      <select class="form-control" id="occupation_id">
        <option value="">--เลือก--</option>
<?php
$sql="select * from `coccupation` ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["occupation_id"]."'>".$rows[$i]["occupation_name"]."</option>";
}
?>
      </select>
      <input type="text" class="form-control" id="occupation_other" placeholder="ระบุ อาชีพ" style="margin-top: 2px;display:none">
    </div>


    <label for="exampleFormControlInput1">เป็นแรงงานต่างด้าว ใช่หรือไม่? <span class="required"></span></label>
    <div class="form-group" style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="foreign_worker" id="foreign_worker0" value="0" checked>
        <label class="form-check-label" for="foreign_worker0">ไม่ใช่</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="foreign_worker" id="foreign_worker1" value="1" >
        <label class="form-check-label" for="foreign_worker1">ใช่</label>
      </div>
    </div>


    <div class="form-group" style="display: none;" id="foreign_worker_nation_box">
      <label for="exampleFormControlSelect1">สัญชาติของแรงงานต่างด้าว <span class="required"></span></label>
      <select class="form-control" id="foreign_worker_nation_id">
        <option value="">--เลือก--</option>
<?php
$sql="select * from foreign_worker_nation ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["foreign_worker_nation_id"]."'>".$rows[$i]["foreign_worker_nation_name"]."</option>";
}
?>
      </select>
    </div>


    <div class="card">
      <div class="card-header">ที่อยู่ก่อนเดินทางเข้าสกลนคร</div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1">จังหวัด <span class="required"></span></label>
          <select class="form-control" id="changwat_out_code">
            <option value="">--เลือก--</option>
  <?php
  $sql="select * from `changwat` order by changwat_name asc ";
  $obj=$connect->prepare($sql);
  $obj->execute();
  $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
  for ($i=0;$i<count($rows);$i++) {
    echo "<option value='".$rows[$i]["changwat_code"]."'>".$rows[$i]["changwat_name"]."</option>";
  }
  ?>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">อำเภอ <span class="required"></span></label>
          <select class="form-control" id="ampur_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">ตำบล <span class="required"></span></label>
          <select class="form-control" id="tambon_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">หมู่ <span class="required"></span></label>
          <input type="text" class="form-control" id="moo_out_code">
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">เลขที่/ชื่อสถานที่ <span class="required"></span></label>
          <input type="text" class="form-control" id="house_out_no">
        </div>
        
      </div>
    </div>


    <div class="form-group" style="margin-top: 20px;">
    <label for="exampleFormControlInput1">วันที่เดินทางเข้าถึงสกลนคร <span class="required"></span></label>
      <input name="datepicker" class="form-control datepicker" id="date_to_sakonnakhon"/>
    </div>

    <div class="card">
      <div class="card-header">ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก</div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">


        <div class="form-group">
        <label for="exampleFormControlSelect1">อำเภอ/เขต <span class="required"></span></label>
        <select class="form-control" id="ampur_in_code">
          <option value="">--เลือก--</option>
<?php
$sql="select * from `ampur` where changwat_code='47' ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["ampur_code"]."'>".$rows[$i]["ampur_name"]."</option>";
}
?>
        </select>
        </div>

        <div class="form-group">
        <label for="exampleFormControlSelect1">ตำบล/แขวง <span class="required"></span></label>
        <select class="form-control" id="tambon_in_code">
          <option value="">--เลือก--</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">หมู่ <span class="required"></span></label>
          <input type="text" class="form-control" id="moo_in_code">
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">เลขที่/ชื่อสถานที่ <span class="required"></span></label>
          <input type="text" class="form-control" id="house_in_no">
        </div>

      </div>
    </div>

    <div style="margin-top: 40px; border-bottom: solid 1px black;">
      <h4>ท่านมีประวัติเสี่ยงต่อการติดเชื้อดังต่อไปนี้ หรือไม่?</h4>
    </div>

    <label for="exampleFormControlInput1">ข้อที่ 1. ท่านได้เดินทางมาจากหรืออาศัยอยู่ในพื้นที่(ภายในประเทศไทย)ที่มีการรายงานการติดเชื้อหรือไม่ ภายใน 1 เดือนที่ผ่านมา <span class="required"></span></label>
    <div class="form-group" style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q1_enter_risk_area" id="q1_enter_risk_area0" value="0" checked>
        <label class="form-check-label" for="q1_enter_risk_area0">ไม่ใช่</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q1_enter_risk_area" id="q1_enter_risk_area1" value="1" >
        <label class="form-check-label" for="q1_enter_risk_area1">ใช่</label>
      </div>
    </div>

    <div style="margin-top: -15px; margin-bottom: 20px; display: none;" id="risk_area_box">
      ระบุพื้นที่เสี่ยง
      <div style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
<?php
$sql="select c.* from changwat c inner join ( ". 
" select changwat_code from risk_area where status_id is not null and status_id=1 group by changwat_code ". 
" ) x on x.changwat_code=c.changwat_code ". 
" order by if(c.changwat_code='".$changwat_code_samut_sakhon."',1,10) asc ,c.changwat_name asc ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  $changwat_red="N";
  if ($rows[$i]["changwat_code"]==$changwat_code_samut_sakhon) {
    $changwat_red="Y";
  }
?>
        <div class="form-check" style="margin-bottom:5px">
          <input type="checkbox" class="form-check-input risk_changwat_input" id="risk_changwat_<?php echo $rows[$i]["changwat_code"]; ?>">
          <label class="form-check-label" for="risk_changwat_<?php echo $rows[$i]["changwat_code"]; ?>" style="margin-bottom:5px">
            <?php echo $rows[$i]["changwat_name"]; ?>
          </label>
          <div id="area_list_<?php echo $rows[$i]["changwat_code"]; ?>" class="area_list" style="display: none;">
<?php
$sql2="select * from risk_area where changwat_code='".$rows[$i]["changwat_code"]."' and status_id is not null and status_id=1 ";
$obj2=$connect->prepare($sql2);
$obj2->execute();
$rows2=$obj2->fetchAll(PDO::FETCH_ASSOC);
for ($n=0;$n<count($rows2);$n++) {
?>
            <div class="form-check" style="margin-bottom:5px">
              <input type="checkbox" class="form-check-input risk_area_input" changwat_red="<?php echo $changwat_red; ?>" id="risk_area_<?php echo $rows2[$n]["risk_area_id"]; ?>">
              <label class="form-check-label" for="risk_area_<?php echo $rows2[$n]["risk_area_id"]; ?>">
                <?php echo $rows2[$n]["area_name"]; ?> (ตั้งแต่วันที่ <?php echo thaiDateShort(substr($rows2[$n]["risk_start_datetime"],0,10)); ?>)
              </label>
            </div>
<?php
}
?>
          </div>
        </div>
<?php
}
?>
      </div>
    </div>

    <label for="exampleFormControlInput1">ข้อที่ 2 : ท่านทำงานใน สถานกักกันโรค ( State quanratine หรือ local quanrantine ) <span class="required"></span></label>
    <div class="form-group" style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q2_quarantine_work_place" id="q2_quarantine_work_place0" value="0" checked>
        <label class="form-check-label" for="q2_quarantine_work_place0">ไม่ใช่</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q2_quarantine_work_place" id="q2_quarantine_work_place1" value="1" >
        <label class="form-check-label" for="q2_quarantine_work_place1">ใช่</label>
      </div>
    </div>

    <label for="exampleFormControlInput1">ข้อที่ 3 : มีประวัติสัมผัสกับผู้ป่วยยืนยันโรคติดเชื้อไวรัส COVID-19 <span class="required"></span></label>
    <div class="form-group" style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q3_touch_patient" id="q3_touch_patient0" value="0" checked>
        <label class="form-check-label" for="q3_touch_patient0">ไม่ใช่</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q3_touch_patient" id="q3_touch_patient1" value="1" >
        <label class="form-check-label" for="q3_touch_patient1">ใช่</label>
      </div>
    </div>

    <label for="exampleFormControlInput1">ข้อที่ 4 : เป็นบุคลากรทางการแพทย์หรือสาธารณสุข ทั้งสถานพยาบาล, คลินิค , ทีมสอบสวนโรค หรือ ร้านขายยา <span class="required"></span></label>
    <div class="form-group" style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q4_health_officer" id="q4_health_officer0" value="0" checked>
        <label class="form-check-label" for="q4_health_officer0">ไม่ใช่</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q4_health_officer" id="q4_health_officer1" value="1" >
        <label class="form-check-label" for="q4_health_officer1">ใช่</label>
      </div>
    </div>

    <label for="exampleFormControlInput1">ข้อที่ 5 : มีประวัติไปในสถานที่ประชาชนหนาแน่น ชุมนุมชน หรือที่มีการรวมกลุ่มคน เช่น ตลาดนัด ห้างสรรพสินค้า สถานพยาบาล หรือขนส่งสาธารณะ ที่พบผู้สงสัยหรือยืนยัน COVID-19 ในช่วง 1 เดือนที่ผ่านมา <span class="required"></span></label>
    <div class="form-group" style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q5_enter_patient_area" id="q5_enter_patient_area0" value="0" checked>
        <label class="form-check-label" for="q5_enter_patient_area0">ไม่ใช่</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q5_enter_patient_area" id="q5_enter_patient_area1" value="1" >
        <label class="form-check-label" for="q5_enter_patient_area1">ใช่</label>
      </div>
    </div>

    <label for="exampleFormControlInput1">ข้อที่ 6 : ในสถานที่ท่านที่ไปประจำ คนที่สนิทใกล้ชิดกับท่าน มีอาการ ไข้ ไอ น้ำมูก เสมหะ มากกว่า 5 คน พร้อมๆกัน ในช่วงเวลาภายในสัปดาห์หรือไม่่ <span class="required"></span></label>
    <div class="form-group" style="background-color: #FFFFFF; padding: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q6_sick_closer" id="q6_sick_closer0" value="0" checked>
        <label class="form-check-label" for="q6_sick_closer0">ไม่ใช่</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="q6_sick_closer" id="q6_sick_closer1" value="1" >
        <label class="form-check-label" for="q6_sick_closer1">ใช่</label>
      </div>
    </div>

    <div style="margin-top: 40px; border-bottom: solid 1px black;">
      <h4>ท่านมีอาการดังต่อไปนี้หรือไม่ ในช่วง 14 วันที่ผ่านมา</h4>
    </div>

    <div class="form-group" style="margin-top: 10px; padding: 10px; background-color: #FFFFFF; border: solid 1px #e5e5e5; border-radius: 5px;">

      <div class="form-check" style="margin-bottom:5px">
        <input type="checkbox" class="form-check-input" id="symptom_fever">
        <label class="form-check-label" for="symptom_fever">มีไข้</label>
      </div>

      <div class="form-check" style="margin-bottom:5px">
        <input type="checkbox" class="form-check-input" id="symptom_cough">
        <label class="form-check-label" for="symptom_cough">ไอ</label>
      </div>

      <div class="form-check" style="margin-bottom:5px">
        <input type="checkbox" class="form-check-input" id="symptom_nasal_mucus">
        <label class="form-check-label" for="symptom_nasal_mucus">มีน้ำมูก</label>
      </div>

      <div class="form-check" style="margin-bottom:5px">
        <input type="checkbox" class="form-check-input" id="symptom_sore_throat">
        <label class="form-check-label" for="symptom_sore_throat">เจ็บคอ</label>
      </div>

      <div class="form-check" style="margin-bottom:5px">
        <input type="checkbox" class="form-check-input" id="symptom_dyspnea">
        <label class="form-check-label" for="symptom_dyspnea">หายใจลำบาก หอบเหนื่อย</label>
      </div>

      <div class="form-check" style="margin-bottom:5px">
        <input type="checkbox" class="form-check-input" id="symptom_not_smell">
        <label class="form-check-label" for="symptom_not_smell">ไม่ได้กลิ่น</label>
      </div>

      <div class="form-check" style="margin-bottom:5px">
        <input type="checkbox" class="form-check-input" id="symptom_not_taste">
        <label class="form-check-label" for="symptom_not_taste">ไม่รู้รส</label>
      </div>

    </div>

    <div class="form-group" style="margin-top: 20px;">
    <label for="exampleFormControlInput1">วันที่เริ่มมีอาการ <span class="required"></span></label>
      <input name="datepicker" class="form-control datepicker" id="symptom_date"/>
    </div>

    <div class="form-group d-flex justify-content-between">
      <button type="button" class="btn btn-primary" style="width: 48%" id="btnSave">บันทึก</button>
      <button type="button" class="btn btn-secondary" style="width: 48%" id="btnClose">ปิด</button>
    </div>

    <div style="height: 200"><br></div>

</div>
</div>


<div class="modal fade" id="modal01">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal01_body" style="margin-top:30px; margin-bottom: 30px;">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>


</body>
</html>

<script>
var evaluate_level=0;

$("#btnSave").click(function() {
  var x=$(".risk_area_input");
  var s=[];
  var evaluate_changwat_red="N";
  for (var i=0;i<x.length;i=i+1) {
    if ($(x[i]).prop('checked')==true) {
      s.push($(x[i]).attr('id').replace('risk_area_',''));
    }
    if ($(x[i]).prop('checked')==true && $(x[i]).attr('changwat_red')=="Y") {
      evaluate_changwat_red="Y";
    }
  }

  var data= {
    prename_id : $("#prename_id").val(),
    fname : $("#fname").val(),
    lname : $("#lname").val(),
    cid : $("#cid").val(),
    tel : $("#tel").val(),
    house_out_no : $("#house_out_no").val(),
    moo_out_code : $("#moo_out_code").val(),
    tambon_out_code : $("#tambon_out_code").val(),
    ampur_out_code : $("#ampur_out_code").val(),
    changwat_out_code : $("#changwat_out_code").val(),
    occupation_id : $("#occupation_id").val(),
    occupation_other : $("#occupation_other").val(),
    foreign_worker : typeof $('input[name="foreign_worker"]:checked').val()!='undefined'?$('input[name="foreign_worker"]:checked').val():"",
    foreign_worker_nation_id : $("#foreign_worker_nation_id").val(),
    date_to_sakonnakhon : formatDate($("#date_to_sakonnakhon").val()),
    house_in_no : $("#house_in_no").val(),
    moo_in_code : $("#moo_in_code").val(),
    tambon_in_code : $("#tambon_in_code").val(),
    ampur_in_code : $("#ampur_in_code").val(),
    changwat_in_code : '47',
    q1_enter_risk_area : typeof $('input[name="q1_enter_risk_area"]:checked').val()!='undefined'?$('input[name="q1_enter_risk_area"]:checked').val():"",
    q2_quarantine_work_place : typeof $('input[name="q2_quarantine_work_place"]:checked').val()!='undefined'?$('input[name="q2_quarantine_work_place"]:checked').val():"",
    q3_touch_patient : typeof $('input[name="q3_touch_patient"]:checked').val()!='undefined'?$('input[name="q3_touch_patient"]:checked').val():"",
    q4_health_officer : typeof $('input[name="q4_health_officer"]:checked').val()!='undefined'?$('input[name="q4_health_officer"]:checked').val():"",
    q5_enter_patient_area : typeof $('input[name="q5_enter_patient_area"]:checked').val()!='undefined'?$('input[name="q5_enter_patient_area"]:checked').val():"",
    q6_sick_closer : typeof $('input[name="q6_sick_closer"]:checked').val()!='undefined'?$('input[name="q6_sick_closer"]:checked').val():"",
    symptom_fever : $("#symptom_fever").prop('checked')?"1":"0",
    symptom_cough : $("#symptom_cough").prop('checked')?"1":"0",
    symptom_nasal_mucus : $("#symptom_nasal_mucus").prop('checked')?"1":"0",
    symptom_sore_throat : $("#symptom_sore_throat").prop('checked')?"1":"0",
    symptom_dyspnea : $("#symptom_dyspnea").prop('checked')?"1":"0",
    symptom_not_smell : $("#symptom_not_smell").prop('checked')?"1":"0",
    symptom_not_taste : $("#symptom_not_taste").prop('checked')?"1":"0",
    symptom_date : formatDate($("#symptom_date").val()),
    risk_area : s.length>0?s.join(','):"",
  }

  var occupation_red=[1,2];
  var evaluate_occupation_red="N";
  if (occupation_red.indexOf(parseInt($("#occupation_id").val()))>-1) {
    evaluate_occupation_red="Y";
  }

  var evaluate_symptom="N";
  if (data['symptom_fever']=="1" | data['symptom_cough']=="1" | data['symptom_nasal_mucus']=="1" | data['symptom_sore_throat']=="1" | data['symptom_dyspnea']=="1" | data['symptom_not_smell']=="1" | data['symptom_not_taste']=="1") {
    evaluate_symptom="Y";
  }

  var evaluate_q1=data['q1_enter_risk_area'];
  var evaluate_q2=data['q2_quarantine_work_place'];
  var evaluate_q3=data['q3_touch_patient'];
  var evaluate_q4=data['q4_health_officer'];
  var evaluate_q5=data['q5_enter_patient_area'];
  var evaluate_q6=data['q6_sick_closer'];
  var evaluate_risk_area=data['risk_area'];

  if (evaluate_risk_area=="" | evaluate_q2=="1" | evaluate_q4=="1" | evaluate_q5=="1") {
    evaluate_level=1;
  }
  if (evaluate_occupation_red=="Y" | evaluate_q6=="1" | (evaluate_risk_area!="" & evaluate_changwat_red=="N")) {
    evaluate_level=2;
  }
  if (evaluate_q3=="1" | evaluate_changwat_red=="Y" | data['foreign_worker']=="1") {
    evaluate_level=3;
  }

  if (evaluate_symptom=="Y") {
    evaluate_level=evaluate_level+1;
  }

  if (evaluate_level>3) {
    evaluate_level=3;
  }

  data['evaluate_level']=evaluate_level;
  console.log(data);

  var not_complete=0;
  input_required.forEach(element => {
    if (data[element]=="") {
      not_complete=not_complete+1;
    }
  });

  if (not_complete>0) {
    $("#modal01_body").html('กรุณากรอกข้อมูลที่<font color="red">จำเป็น</font>ให้ครบ');
    $("#modal01").modal('show');
  }
  else {
    $.ajax({method: "POST", url: "ajaxSaveRegister.php",
      data: data
    })
    .done(function(x) {
      var r=jQuery.parseJSON(x).data;
      if (r.status=="success") {
        $("#modal01_body").html('ลงทะเบียนเสร็จเรียบร้อยแล้ว');
        $("#modal01").modal('show');
        $( "#btnInsideModal" ).bind( "click", goPageSuggestion );
      }
    });
  }
});

function formatDate(d) {
  var r="";
  if (typeof d !='indefined') {
    if (d.length>0) {
      var x=d.split("/");
      r=x[2]+"-"+x[1]+"-"+x[0];
    }
  }
  return r;
}

var goPageSuggestion = function(x) {
  // console.log(evaluate_level);
  window.location="suggestion.php?evaluate_level="+evaluate_level;
};

$("#changwat_out_code").change(function() {
  $("#ampur_out_code").find("option").remove();
  $("#ampur_out_code").append("<option value=''>--เลือก--</option>");
  $("#tambon_out_code").find("option").remove();
  $("#tambon_out_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "ampur", 
      query_where: "changwat_code='"+$("#changwat_out_code").val()+"'" , 
      query_order: "if(left(ampur_name,5)='เมือง',1,2) asc , ampur_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#ampur_out_code").append("<option value='"+data[i]["ampur_code"]+"'>"+data[i]["ampur_name"]+"</option>");
    }
  });
});

$("#ampur_out_code").change(function() {
  $("#tambon_out_code").find("option").remove();
  $("#tambon_out_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "tambon", 
      query_where: "ampur_code_full='"+$("#changwat_out_code").val()+$("#ampur_out_code").val()+"'" , 
      query_order: "tambon_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_out_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["tambon_name"]+"</option>");
    }
  });
});

$("#ampur_in_code").change(function() {
  $("#tambon_in_code").find("option").remove();
  $("#tambon_in_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "tambon", 
      query_where: "ampur_code_full='47"+$("#ampur_in_code").val()+"'" , 
      query_order: "tambon_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_in_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["tambon_name"]+"</option>");
    }
  });
});

$("#occupation_id").change(function() {
  if ($("#occupation_id").val()=="99") {
    $("#occupation_other").css({'display':'block'});
  }
  else {
    $("#occupation_other").val('');
    $("#occupation_other").css({'display':'none'});
  }
});

$("input[id^='risk_changwat_']").click(function() {
  var list_div=$(this).parent().find(".area_list");
  if ($(this).prop('checked')==true) {
    list_div.css({'display':'block'});
  }
  else {
    list_div.css({'display':'none'});
    list_div.find("input").prop('checked',false);
  }
});

$('input[name="q1_enter_risk_area"]').click(function() {
  if ($('input[name="q1_enter_risk_area"]:checked').val()==1) {
    $("#risk_area_box").css({'display':'block'});
  }
  else {
    $(".risk_area_input").prop('checked',false);
    $(".risk_changwat_input").prop('checked',false);
    $(".area_list").css({'display':'none'});
    $("#risk_area_box").css({'display':'none'});
  }
});

$('input[name="foreign_worker"]').click(function() {
  if ($('input[name="foreign_worker"]:checked').val()==1) {
    $("#foreign_worker_nation_box").css({'display':'block'});
  }
  else {
    $("#foreign_worker_nation_id").val('');
    $("#foreign_worker_nation_box").css({'display':'none'});
  }
});

</script>