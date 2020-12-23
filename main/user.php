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
    <title>Floating labels example ? Bootstrap</title>

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
  </head>
  <body>
<?php
$sql="select * from `user` ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// echo json_encode($row_oapp, JSON_UNESCAPED_UNICODE);
for ($i=0;$i<count($rows);$i++) {
  echo "<br>- ".$rows[$i]["user_login"]."|".$rows[$i]["user_password"];
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
<div class="container">
<form>
  <div class="form-group">
    <label for="user_login">Username</label>
    <input type="user_login" class="form-control" id="user_login">
    <label for="user_password">Password</label>
    <input type="user_password" class="form-control" id="user_password">

    <label for="prename_id">คำนำหน้าชื่อ</label>
    <select class="form-control" id="prename_id">
    </select>

    <label for="fname">ชื่อ</label>
    <input type="fname" class="form-control" id="fname">
    <label for="lname">สกุล</label>
    <input type="lname" class="form-control" id="lname">
    <label for="phone">เบอร์โทร</label>
    <input type="phone" class="form-control" id="phone">

    <label for="office_id">หน่วยงาน</label>
    <select class="form-control" id="office_id">
      <option>สสอ.เมืองสกลนคร</option>
      <option>สสอ.กุสุมาลย์</option>
    </select>



    <label for="status_id">สถานะ</label>
    <select class="form-control" id="status_id">
      <option>ใช้งาน</option>
      <option>ไม่ใช้งาน</option>
    </select>
    <label for="date_register">วันที่ลงทะเบียน</label>
    <input type="date_register" class="form-control" id="date_register">
    
  </div>
  <div>
  <button type="button" >555</button>
  </div>

</form>
</div>

</body>
</html>
