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

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/">

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
    <link href="floating-labels.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>
  </head>
  <body>
<?php
$sql="select * from `user` ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode($row_oapp, JSON_UNESCAPED_UNICODE);
for ($i=0;$i<count($rows);$i++) {
  //echo "<br>- ".$rows[$i]["user_login"]."|".$rows[$i]["user_password"];
}
?>
<script>
$.ajax({
  method: "POST",
  url: "ajaxTest.php",
  data:""
}).done(function(x){
  console.log(x);
  var xdata=jQuery.parseJSON(x);
  console.log(xdata);
});
</script>

<script>
  $(document).ready(function () {
      $('.datepicker').datepicker({
          format: 'dd/mm/yyyy',
          todayBtn: true,
          language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
          thaiyear: true //Set เป็นปี พ.ศ.
      }).datepicker("setDate", "0");//กำหนดเป็นวันปัจุบัน
  });
</script>


<div class="container">
<h2 style="text-align:center">ลงทะเบียนรายงานตัวล่วงหน้า</h2>
<form>
  <div class="form-group">
    <label for="exampleFormControlSelect1">คำนำหน้าชื่อ</label>
    <select class="form-control" id="pname">
      <option>นาย</option>
      <option>นาง</option>
      <option>นางสาว</option>
      <option>ด.ช.</option>
      <option>ด.ญ.</option>
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
      <label for="exampleFormControlInput1">ที่อยู่ปัจจุบัน</label>
      <input type="email" class="form-control" id="moo_out" placeholder="ที่อยู่ปัจจุบัน">
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">จังหวัด</label>
    <select class="form-control" id="changwat_out_code">
      <option>สกลนคร</option>
      <option>กาฬสินธุ์</option>
      <option>นครพนม</option>
      <option>บึงกาฬ</option>
    </select>
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">อำเภอ</label>
    <select class="form-control" id="amphur_out_code">
      <option>เมืองสกลนคร</option>
      <option>กุสุมาลย์</option>
      <option>กุดบาก</option>
    </select>
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">ตำบล</label>
    <select class="form-control" id="district_out_code">
      <option>ธาตุเชิงชุม</option>
      <option>ธาตุนาเวง</option>
      <option>เชียงเครือ</option>
      <option>ธาตุดุม</option>
    </select>
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">อาชีพ</label>
    <select class="form-control" id="occupation_id">
      <option>ขายอาหารทะเล</option>
      <option>คนขับรถ</option>
      <option>ร่ำรวย</option>
    </select>
    </div>

    <div class="form-group">
    <label for="exampleFormControlInput1">วันที่เดินทางเข้าถึงสกล</label>
      <div class="col-md-10">
        <input name="datepicker" class="datepicker" id="date_to_sakonnakhon"/>
    </div>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">ประวัติการเคยสัมผัสผู้ป่วย</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="exampleRadios" id="touch_history" value="1" >
      <label for="exampleRadios1">
        เคยสัมผัส
      </label>
    </div>

    <div class="form-check">
      <input class="form-check-input" type="radio" name="exampleRadios" id="touch_history" value="2" >
      <labe for="exampleRadios1">
        ไม่เคยสัมผัส
      </label>
    </div>
    </div>

<div class="form-group">
      <label for="exampleFormControlInput1">เข้าพำนักที่บ้านเลขที่</label>
      <input type="email" class="form-control" id="house_in_no" placeholder="เข้าพำนักที่บ้านเลขที่">
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">เข้าพำนักที่อำเภอ</label>
    <select class="form-control" id="amphur_in_code">
      <option>เมืองสกลนคร</option>
      <option>กุสุมาลย์</option>
      <option>กุดบาก</option>
    </select>
    </div>

    <div class="form-group">
    <label for="exampleFormControlSelect1">เข้าพำนักที่ตำบล</label>
    <select class="form-control" id="district_in_code">
      <option>ธาตุเชิงชุม</option>
      <option>ธาตุนาเวง</option>
      <option>เชียงเครือ</option>
      <option>ธาตุดุม</option>
    </select>
    </div>
 
    
</form>
</div>
</div>

</body>
</html>
