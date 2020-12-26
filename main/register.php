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
    <h4 style="text-align:center; color: black;">รายงานตัวเข้าสกลนคร</h4>
  </div>
</div>

<!-- <div style="width: 100%; padding: 20px; padding-top: 0px; display: flex; justify-content: space-between;">
  <div style="width: 100%; border: solid 4px #4db1ff; border-radius: 10px; padding: 15px; text-align: center; background-color: white; margin-right: 0px;">
    ท่านสามารถรายงานตัวออนไลน์ล่วงหน้า ก่อนที่จะเข้าสู่พื้นที่จังหวัดสกลนคร ผ่านเว็บไซต์นี้ <br>
    หรือ รายงานตัวกับ อสม./ผู้ใหญ่บ้าน/ผู้นำชุมชน ทันทีที่เดินทางถึงพื้นที่ปลายทางค่ะ <br> 
    มาช่วยกัน เพื่อจำกัดการแพร่กระจาย เชื้อโควิด-19 กันนะคะ
  </div>
  <div style="margin-left: -20px;">
    <img src="../image/cartoon_nurse_03.png" width="70px">
  </div>
</div> -->

<div style="width: 100%; padding: 5px; display: flex; flex-flow: row wrap;">

  <div class="col-lg-4 col-md-6 col-sm-12">

    <div class="form-group">
      <label for="exampleFormControlInput1">ชื่อ <span class="required"></span></label>
      <input type="text" class="form-control" id="fname" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">นามสกุล <span class="required"></span></label>
      <input type="text" class="form-control" id="lname" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">เลขบัตรประจำตัวประชาชน <span class="required"></span></label>
      <input type="text" class="form-control" id="cid" placeholder="">
    </div>
  
    <div class="form-group">
      <label for="exampleFormControlInput1">เบอร์โทรศัพท์ <span class="required"></span></label>
      <input type="text" class="form-control" id="tel" placeholder="">
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
    </div>

  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card" style="margin-bottom: 20px;">
      <div class="card-header">ที่พักอาศัยก่อนเดินทางเข้าสกลนคร</div>
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
          <label for="exampleFormControlSelect1">อำเภอ/เขต <span class="required"></span></label>
          <select class="form-control" id="ampur_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">ตำบล/แขวง <span class="required"></span></label>
          <select class="form-control" id="tambon_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>
        
      </div>
    </div>

    <div class="card"  style="margin-bottom: 20px;">
      <div class="card-header">
        ที่ทำงาน
        <div class="form-check">
          <input type="checkbox" class="form-check-input risk_area_input" id="address_work">
          <label class="form-check-label" for="address_work">
            เป็นที่อยู่เดียวกันกับที่พักอาศัย
          </label>
        </div>
      </div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1">จังหวัด <span class="required"></span></label>
          <select class="form-control" id="changwat_work_code">
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
          <label for="exampleFormControlSelect1">อำเภอ/เขต <span class="required"></span></label>
          <select class="form-control" id="ampur_work_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">ตำบล/แขวง <span class="required"></span></label>
          <select class="form-control" id="tambon_work_code">
            <option value="">--เลือก--</option>
          </select>
        </div>
        
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
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
  </div>

</div>

<div style="width: 100%; padding: 20px;">
  <div class="form-group d-flex justify-content-between" style="margin-top: 20px;">
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSave">บันทึก</button>
    <!-- <button type="button" class="btn btn-secondary" style="width: 48%" id="btnClose">ปิด</button> -->
  </div>
</div>

<div style="height: 200"><br></div>


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
  var data= {
    fname : $("#fname").val(),
    lname : $("#lname").val(),
    cid : $("#cid").val(),
    tel : $("#tel").val(),
    occupation_id : $("#occupation_id").val(),
    tambon_out_code : $("#tambon_out_code").val(),
    ampur_out_code : $("#ampur_out_code").val(),
    changwat_out_code : $("#changwat_out_code").val(),
    tambon_work_code : $("#tambon_work_code").val(),
    ampur_work_code : $("#ampur_work_code").val(),
    changwat_work_code : $("#changwat_work_code").val(),
    date_to_sakonnakhon : formatDate($("#date_to_sakonnakhon").val()),
    house_in_no : $("#house_in_no").val(),
    moo_in_code : $("#moo_in_code").val(),
    tambon_in_code : $("#tambon_in_code").val(),
    ampur_in_code : $("#ampur_in_code").val(),
  }
  // console.log(data);

  var not_complete=0;
  input_required.forEach(element => {
    if (data[element]=="") {
      not_complete=not_complete+1;
    }
  });

  if (not_complete>0) {
    $("#modal01_body").html('กรุณากรอกข้อมูลที่<font color="red"> *จำเป็น </font>ให้ครบด้วยค่ะ');
    $("#modal01").modal('show');
  }
  else {
    $.ajax({method: "POST", url: "ajaxSaveRegisterSkn.php",
      data: data
    })
    .done(function(x) {
      // console.log(jQuery.parseJSON(x));
      var r=jQuery.parseJSON(x).data;
      if (r.status=="success") {
        // $("#modal01_body").html('ลงทะเบียนเสร็จเรียบร้อยแล้วค่ะ');
        // $("#modal01").modal('show');
        // $( "#btnInsideModal" ).bind( "click", goPageSuggestion );

        goPageSuggestion();
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

var goPageSuggestion = function() {
  window.location="suggestion_skn.php";
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

$("#changwat_work_code").change(function() {
  $("#ampur_work_code").find("option").remove();
  $("#ampur_work_code").append("<option value=''>--เลือก--</option>");
  $("#tambon_work_code").find("option").remove();
  $("#tambon_work_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "ampur", 
      query_where: "changwat_code='"+$("#changwat_work_code").val()+"'" , 
      query_order: "if(left(ampur_name,5)='เมือง',1,2) asc , ampur_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#ampur_work_code").append("<option value='"+data[i]["ampur_code"]+"'>"+data[i]["ampur_name"]+"</option>");
    }
  });
});

$("#ampur_work_code").change(function() {
  $("#tambon_work_code").find("option").remove();
  $("#tambon_work_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "tambon", 
      query_where: "ampur_code_full='"+$("#changwat_work_code").val()+$("#ampur_work_code").val()+"'" , 
      query_order: "tambon_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_work_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["tambon_name"]+"</option>");
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

$("#address_work").click(function() {
  if ($(this).prop('checked')==true) {
    $("#ampur_work_code").find("option").remove();
    $("#ampur_work_code").append($("#ampur_out_code").children().clone());
    $("#tambon_work_code").find("option").remove();
    $("#tambon_work_code").append($("#tambon_out_code").children().clone());

    $("#changwat_work_code").val($("#changwat_out_code").val());
    $("#ampur_work_code").val($("#ampur_out_code").val());
    $("#tambon_work_code").val($("#tambon_out_code").val());
  }
  else {
    $("#ampur_work_code").find("option").remove();
    $("#ampur_work_code").append("<option value=''>--เลือก--</option>");
    $("#tambon_work_code").find("option").remove();
    $("#tambon_work_code").append("<option value=''>--เลือก--</option>");
    $("#changwat_work_code").val('');
    $("#ampur_work_code").val('');
    $("#tambon_work_code").val('');
  }
});

</script>