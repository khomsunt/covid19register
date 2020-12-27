<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$sql="select c.*,
cw.changwat_name as changwat_name_out,
a.ampur_name as ampur_name_out,
t.tambon_name as tambon_name_out,
a47.ampur_name as ampur_name_in,
t47.tambon_name as tambon_name_in,
o.occupation_name,
r.risk_level_long_name
from covid_register_cut c 
left join changwat cw on c.changwat_out_code=cw.changwat_code 
left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code
left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code
left join ampur47 a47 on c.ampur_in_code=a47.ampur_code
left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code
left join coccupation o on c.occupation_id=o.occupation_id
left join risk_level r on c.risk_level_id=r.risk_level_id
where c.cut_datetime=:cut_datetime";
$obj=$connect->prepare($sql);
$obj->execute([ 'cut_datetime' => $_POST['cut_datetime'] ]);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    
    <title>Carousel Template · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">

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
    
  </head>
  <body>
<?php
include("./header.php");
?>
<main role="main" style="margin-top:60px;">
<div class="container">
    <!-- <h5>รายชื่อกลุ่มเสี่ยงประจำวันที่ <?php echo $_POST['cut_datetime']; ?></h5> -->
    <!-- <h5>ทะเบียนรายงานตัวของผู้เดินทาง วันเวลาที่ตัดข้อมูล<?php echo $_POST['cut_datetime']; ?></h5> -->
</div>
<div><button type="button" class="btn btn-primary btn_cut_print">ส่งออก</button></div>
<div class="table-responsive">
<table class='table table-condensed  table-bordered table-hover' width="100%" id="myTable">
  <thead>
  <tr>
  <th colspan="39"><h5>ทะเบียนรายงานตัวของผู้เดินทาง วันเวลาที่ตัดข้อมูล<?php echo $_POST['cut_datetime']; ?></h5></th>
  <th colspan="39"><h3>ทะเบียนรายงานตัวของผู้เดินทาง วันเวลาที่ตัดข้อมูล<?php echo $_POST['cut_datetime']; ?></h3></th>
  </tr>
  <tr class="text-center">
    <th rowspan="2">วันที่ตัดข้อมูล</th>
    <th rowspan="2">วันที่บันทึก</th>
    <th rowspan="2">ลำดับ</th>
    <th rowspan="2" data-card-title>ชื่อ</th>
    <th rowspan="2" data-card-title>นามสกุล</th>
    <th rowspan="2">เพศ</th>
    <th rowspan="2">อายุ</th>
    <th rowspan="2">อาชีพ</th>
    <th colspan="6">ที่อยู่จริง</th>
    <th rowspan="2">เบอร์โทร</th>
    <th rowspan="2">วดป.ที่เดินทางมา</th>
    <th rowspan="2">วันที่เดินทาง</th>
    <th rowspan="2">สิ้นสุดเฝ้าระวัง</th>
    <th colspan="6">ที่อยู่ในสกลนคร</th>
    <th rowspan="2">สาเหตุที่เดินทางไป</th>
    <th rowspan="2">พาหนะที่ใช้เดินทาง</th>
    <th colspan="2">อาการ</th>
    <th colspan="6">ประเภท</th>
    <th colspan="2">lab</th>
    <th colspan="2">ผล</th>
    <th rowspan="2">หน่วยบริการรับผิดชอบ</th>
    </tr>
    <tr>
      <th>เลขที่</th>
      <th>หมู่</th>
      <th>บ้าน</th>
      <th>ตำบล</th>
      <th>อำเภอ</th>
      <th>จังหวัด</th>
      <th>เลขที่</th>
      <th>หมู่</th>
      <th>บ้าน</th>
      <th>ตำบล</th>
      <th>อำเภอ</th>
      <th>จังหวัด</th>
      <th>ไม่ป่วย</th>
      <th>อื่น(ระบุ)</th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <th>6</th>
      <th>วันที่เก็บ</th>
      <th>วันที่ส่ง</th>
      <th>neg</th>
      <th>รอผล</th>
    </tr>

  </thead>
  <tbody>
      <?php

      $sql="select * from risk_level order by risk_level_id";
      $obj=$connect->prepare($sql);
      $obj->execute();
      $rows_risk_level=$obj->fetchAll(PDO::FETCH_ASSOC);
      $i = 1;
      foreach ($rows as $key => $value) {
        ?>
        <tr>
            <td><?php echo $value['cut_datetime']; ?></td>
            <td><?php echo $value['register_datetime']; ?></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['fname']; ?></td>
            <td><?php echo $value['lname']; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $value['moo_out_code']; ?></td>
            <td><?php echo $value['tambon_name_out']; ?></td>
            <td><?php echo $value['ampur_name_out']; ?></td>
            <td><?php echo $value['changwat_name_out']; ?></td>
            <td>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-telephone-fill" viewBox="0 0 16 16" stroke="blue" fill="yellow"
       fill-opacity="0.5" stroke-opacity="0.8">
  <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
</svg>
<?php echo $value['tel']; ?></td>
            <td><?php echo $value['date_to_sakonnakhon']; ?></td> 
            <td></td>
            <td></td>
            <td><?php echo $value['house_in_no']; ?></td>
            <td><?php echo $value['moo_in_code']; ?></td>
            <td><?php echo $value['tambon_name_in']; ?></td>
            <td><?php echo $value['ampur_name_in']; ?></td> 
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

            <td>
              <?php  
                switch ($value['risk_level_id']) {
														case "1":
														echo "/";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['risk_level_id']) {
														case "2":
														echo "/";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['risk_level_id']) {
														case "3":
														echo "/";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['risk_level_id']) {
														case "4":
														echo "/";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['risk_level_id']) {
														case "5":
														echo "/";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['risk_level_id']) {
														case "6":
														echo "/";
                            break;} 
              ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
           
        </tr>
      <?php
      $i++;
      } ?>
  </tbody>
</table>
</div>



</main>
<button  type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>

  <!-- FOOTER -->
  <?php
  include("./footer.php");
  ?>
<script src="../js/jquery-3.2.1.min.js" ></script>
      <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/tableToCards.js"></script>
      <script src='../js/table2excel.js'></script>
      <script>
        $(function(){
            $(".btn-change-risk-level").click(function(){
                console.log($(this).attr("covid_register_id"));
                $.ajax({
                    method: "POST",
                    url: "./changeRiskLevel.php",
                    data: { covid_register_id: $(this).attr("covid_register_id"), risk_level_id: $(this).attr("risk_level_id") }
                })
                .done(function( msg ) {
                  console.log(msg)
                  location.reload();

                  // $(this).parent().parent().children().first().html($(this).html())
                })
            })
        })
      </script>
      <script type="text/javascript">
            var $btnDLtoExcel = $('.btn_cut_print');
            $btnDLtoExcel.on('click', function Export() {
            $("#myTable").table2excel({
                filename: "aummmmmmmmm.xls"
            });
            });
            

        </script>

        
</html>
