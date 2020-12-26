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
  <title>รายงานตัวเข้าสกลนคร</title>

  <script src="../js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>
</head>

<body style="background-color: #b9ddff;  background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: 500px; background-position: top right;">

<script>
var input_required=['fname','lname','cid','tel','changwat_out_code','ampur_out_code','ampur_in_code','tambon_in_code','date_to_sakonnakhon'];
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

<div style="width: 100%; padding-left: 20px; padding-top: 30px;">

  <div style="display: flex; align-items: flex-start;">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
  </div>

</div>

<div style="width: 100%; padding: 20px;">
  <div style="padding-top: 10px; padding-bottom: 10px; border-radius: 5px; background-color:rgba(250, 255, 255, 0.5);">
    <h4 style="text-align:center; color: black;">Recal Evalute Level</h4>
  </div>
</div>

<div style="width: 100%; padding: 20px;">
  <div class="form-group d-flex justify-content-between" style="margin-top: 20px;">
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnRecal">ประมวลผล</button>
  </div>
</div>

<div style="height: 200"><br></div>

<div class="modal fade" id="modal01" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal01_body" style="margin-top:30px; margin-bottom: 30px;">
        ...
      </div>
      <div class="modal-footer" id="modal01_action" style="text-align: right;">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>


</body>
</html>

<script>
$("#btnRecal").click(function() {
  var data= {}
  // console.log(data);
  $("#modal01_body").html('กำลังประมวลผล ..');
  $("#modal01_action").css({'display':'none'});
  $("#modal01").modal('show');
console.log('ajaxRecalEvaluateLevel');
  $.ajax({method: "POST", url: "ajaxRecalEvaluateLevel.php",
    data: data
  })
  .done(function(x) {
    console.log(jQuery.parseJSON(x));
    var r=jQuery.parseJSON(x).data;
    if (r.status=="success") {
      $("#modal01").modal('hide');
      setTimeout(() => {
        $("#modal01_body").html('ประมวลผลเสร็จแล้ว');
        $("#modal01_action").css({'display':'block'});
        $("#modal01").modal('show');
      }, 500);
    }
  });
});
</script>