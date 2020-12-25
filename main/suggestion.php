<?php 
include('../include/config.php');
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
  </head>

<body style="background-color: #b9ddff;">

<div class="container" style="width: 100%; background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: contain, cover; background-position: top center;">

  <div style="height: 100;"><br></div>
  <div style="display: flex; align-items: flex-start;">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
  </div>

  <h2 style="text-align:center; margin-top: 20px; margin-bottom: 5px;">คำแนะนำ</h2>

  <div style="width:100%; padding: 20px; display: none;" id="level_red">
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; background-color: white;">
      <h4>ระดับความเสี่ยงของท่านคือ</h4>
      <h3 style="color: red;">สีแดง</h3>
    </div>
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; margin-top: 5px; background-color: white;">
      <img src="../image/level_red.png" style="width: 50%">
      <div style="width: 300px; text-align: left;">
        <h5>
          - ต้องเข้ารับการกักกันโรค<br>
          - พิจารณาตรวจหาเชื้อทางห้องปฏิบัติการ<br>
        </h5>
      </div>
    </div>
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: left; margin-top: 5px; background-color: white;">
      <h5>
        เจ้าหน้าที่จะติดต่อท่าน เพื่อประเมินความเสี่ยง
      </h5>
    </div>
  </div>

  <div style="width:100%; padding: 20px; display: none;" id="level_orange">
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; background-color: white;">
      <h4>ระดับความเสี่ยงของท่านคือ</h4>
      <h3 style="color: orange;">สีส้ม</h3>
    </div>
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; margin-top: 5px; background-color: white;">
      <img src="../image/level_orange.png" style="width: 50%">
      <div style="width: 300px; text-align: left;">
        <h5>
          - สังเกตุอาการ 14 วัน<br>
          - หลีกเลี่ยงไปในที่ชุมชน<br>
          - เว้นระยะห่าง<br>
          - ส่วนหน้ากากอนามัย<br>
          - หมั่นล้างมือ<br>
          - แยกรับประทานอาหาร(แยกสำรับ)<br>
        </h5>
      </div>
    </div>
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: left; margin-top: 5px; background-color: white;">
      <h5>
        เจ้าหน้าที่จะติดต่อท่าน เพื่อประเมินความเสี่ยง
      </h5>
    </div>
  </div>


  <div style="width:100%; padding: 20px; display: none;" id="level_yellow">
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; background-color: white;">
      <h4>ระดับความเสี่ยงของท่านคือ</h4>
      <h3 style="color: yellow;">สีเหลือง</h3>
    </div>
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; margin-top: 5px; background-color: white;">
      <img src="../image/level_yellow.png" style="width: 50%">
      <div style="width: 300px; text-align: left;">
        <h5>
          - ไม่ต้องกักตัว<br>
          - ไม่ต้องตรวจหาเชื้อ<br>
          - หากมีอาการ อย่างใดอย่างหนึ่ง ได้แก่ มีไข้, ไอ, มีน้ำมูก, เจ็บคอ, หายใจลำบาก/หอบเหนื่อย, จมูกไม่ได้กลิ่น, ลิ้นไม่รู้รส ให้ประสานเจ้าหน้าที่สาธารณสุขในพื้นที่ เพื่อเข้ารับการตรวจวินิจฉัยเชื้อโควิด-19
        </h5>
      </div>
    </div>
  </div>


  <div style="width:100%; padding: 20px; display: none;" id="level_green">
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; background-color: white;">
      <h4>ระดับความเสี่ยงของท่านคือ</h4>
      <h3 style="color: green;">สีเขียว</h3>
    </div>
    <div style="border: solid 4px; border-radius: 10px; padding: 5px; text-align: center; margin-top: 5px; background-color: white;">
      <img src="../image/level_green.png" style="width: 50%">
      <div style="width: 300px; text-align: left;">
        <h5>
          - ไม่ต้องกักตัว<br>
          - ไม่ต้องตรวจหาเชื้อ<br>
          - หากมีอาการ อย่างใดอย่างหนึ่ง ได้แก่ มีไข้, ไอ, มีน้ำมูก, เจ็บคอ, หายใจลำบาก/หอบเหนื่อย, จมูกไม่ได้กลิ่น, ลิ้นไม่รู้รส ให้เข้ารับการรักษาที่โรงพยาบาล
        </h5>
      </div>
    </div>
  </div>

</div>


</body>
</html>

<script>
$(document).ready(function () {

  if ("<?php echo $_GET['evaluate_level']; ?>"=="0") {
    $("#level_green").css({'display':'block'});
  }
  if ("<?php echo $_GET['evaluate_level']; ?>"=="1") {
    $("#level_yellow").css({'display':'block'});
  }
  if ("<?php echo $_GET['evaluate_level']; ?>"=="2") {
    $("#level_orange").css({'display':'block'});
  }
  if ("<?php echo $_GET['evaluate_level']; ?>"=="3") {
    $("#level_red").css({'display':'block'});
  }

});
</script>