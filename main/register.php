<?php 
include('../include/config.php');
// echo "<br>config=";
// print_r($configs);
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
    <!-- <link href="floating-labels.css" rel="stylesheet"> -->
    <!-- <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script> -->
  </head>
  <body>

<script>
$(document).ready(function () {
    // $('.datepicker').datepicker({
    //     format: 'dd/mm/yyyy',
    //     todayBtn: true,
    //     language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
    //     thaiyear: true //Set เป็นปี พ.ศ.
    // }).datepicker("setDate", "0");//กำหนดเป็นวันปัจุบัน
});
</script>


<div class="container" style="background-color: #b9ddff;background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: contain, cover; background-position: top center;">

  <div style="height: 100;"><br></div>
  <div style="display: flex; align-items: flex-start;">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
  </div>

  <h2 style="text-align:center; margin-top: 20px; margin-bottom: 20px;">ลงทะเบียน<br>รายงานตัวล่วงหน้า</h2>

  <div class="form-group">
    <label for="exampleFormControlSelect1">คำนำหน้าชื่อ</label>
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
      <label for="exampleFormControlInput1">ชื่อ</label>
      <input type="email" class="form-control" id="fname" placeholder="ชื่อ">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">นามสกุล</label>
      <input type="email" class="form-control" id="lname" placeholder="นามสกุล">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">เลขบัตรประจำตัวประชาชน</label>
      <input type="email" class="form-control" id="cid" placeholder="เลขบัตรประจำตัวประชาชน">
    </div>
  
    <div class="form-group">
      <label for="exampleFormControlInput1">เบอร์โทรศัพท์</label>
      <input type="email" class="form-control" id="tel" placeholder="เบอร์โทรศัพท์">
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">อาชีพ</label>
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


    <div class="card">
      <div class="card-header">ที่อยู่ปัจจุบัน</div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1">จังหวัด</label>
          <select class="form-control" id="changwat_out_code">
            <option value="">--เลือก--</option>
  <?php
  $sql="select * from `changwat` ";
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
          <label for="exampleFormControlSelect1">อำเภอ</label>
          <select class="form-control" id="ampur_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">ตำบล</label>
          <select class="form-control" id="tambon_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">เลขที่</label>
          <input type="email" class="form-control" id="moo_out" placeholder="ที่อยู่ปัจจุบัน">
        </div>
        
      </div>
    </div>


    <div class="form-group">
    <label for="exampleFormControlInput1">วันที่เดินทางเข้าถึงสกล</label>
      <div class="col-md-10">
        <input name="datepicker" class="datepicker" id="date_to_sakonnakhon"/>
    </div>
    </div>

    <label for="exampleFormControlInput1">ประวัติการเคยสัมผัสผู้ป่วย</label>
    <div class="form-group" style="background-color: #FFFFFF; padding-left: 10px; border: solid 1px #e5e5e5; border-radius: 5px;">

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="touch_history" value="1" >
        <label for="exampleRadios1">
          เคยสัมผัส
        </label>
      </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="touch_history" value="2" >
        <labe for="exampleRadios1">
          ไม่เคยสัมผัส
        </label>
      </div>

    </div>


    <div class="card">
      <div class="card-header">ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก</div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">


        <div class="form-group">
        <label for="exampleFormControlSelect1">อำเภอ</label>
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
        <label for="exampleFormControlSelect1">ตำบล</label>
        <select class="form-control" id="tambon_in_code">
          <option value="">--เลือก--</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">เลขที่</label>
          <input type="email" class="form-control" id="house_in_no" placeholder="เข้าพำนักที่บ้านเลขที่">
        </div>

      </div>
    </div>

    <div style="height: 200"><br></div>

    <div class="form-group d-flex justify-content-between">
      <button type="button" class="btn btn-primary" style="width: 48%" id="btnSave">บันทึก</button>
      <button type="button" class="btn btn-secondary" style="width: 48%" id="btnClose">ปิด</button>
    </div>

    <div style="height: 200"><br></div>

</div>
</div>

</body>
</html>

<script>
$("#btnSave").click(function() {
  var data= {
    prename_id : $("#prename_id").val(),
    fname : $("#fname").val(),
    lname : $("#lname").val(),
    cid : $("#cid").val(),
    tel : $("#tel").val(),
    moo_out : $("#moo_out").val(),
    tambon_out_code : $("#tambon_out_code").val(),
    ampur_out_code : $("#ampur_out_code").val(),
    changwat_out_code : $("#changwat_out_code").val(),
    occupation_id : $("#occupation_id").val(),
    date_to_sakonnakhon : $("#date_to_sakonnakhon").val(),
    touch_history : typeof $('input[name="touch_history"]:checked').val()!='undefined'?$('input[name="touch_history"]:checked').val():"",
    house_in_no : $("#house_in_no").val(),
    tambon_in_code : $("#tambon_in_code").val(),
    ampur_in_code : $("#ampur_in_code").val(),
    changwat_in_code : '47',
  }
  console.log(data);
  $.ajax({method: "POST", url: "ajaxSaveRegister.php",
    data: data
  })
  .done(function(x) {
    console.log(x);
    // var data=jQuery.parseJSON(x).data;
    // for (var i=0;i<data.length;i=i+1) {
    //   $("#ampur_out_code").append("<option value='"+data[i]["ampur_code"]+"'>"+data[i]["ampur_name"]+"</option>");
    // }
  });
});

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

</script>