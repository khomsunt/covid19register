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
<h5>รายชื่อกลุ่มเสี่ยงประจำวันที่ <?php echo $_POST['cut_datetime']; ?></h5>
<button type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>
<table class="table" id="myTable">
  <thead>
    <tr>
      <th data-card-title>ชื่อ นามสกุล</th>
      <th data-card-action-links>วันที่บันทึก</th>
      <th>อาชีพ</th>
      <th>มาจาก</th>
      <th>มาที่</th>
      <th>วันที่</th>      
      <th data-card-footer>มาจาก</th>
    </tr>
  </thead>
  <tbody>
      <?php

      $sql="select * from risk_level order by risk_level_id";
      $obj=$connect->prepare($sql);
      $obj->execute();
      $rows_risk_level=$obj->fetchAll(PDO::FETCH_ASSOC);
      
      foreach ($rows as $key => $value) {
        ?>
        <tr>
            <td>
            <?php echo $value['fname']." ".$value['lname']; ?>
            </td>
            <td><?php echo $value['register_datetime']; ?></td>
            <td><?php echo $value['occupation_name']; ?></td>
            <td>
                ม. <?php echo $value['moo_out_code']; ?>
                ต. <?php echo $value['tambon_name_out']; ?>
                อ. <?php echo $value['ampur_name_out']; ?>
                จ. <?php echo $value['changwat_name_out']; ?>
            </td>
            <td>
                ที่อยู่ <?php echo $value['house_in_no']; ?>
                ม. <?php echo $value['moo_in_code']; ?>
                ต. <?php echo $value['tambon_name_in']; ?>
                อ. <?php echo $value['ampur_name_in']; ?>
            </td>
            <td>
                <?php echo $value['date_to_sakonnakhon']; ?>
            </td>
            <td>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-telephone-fill" viewBox="0 0 16 16" stroke="blue" fill="yellow"
       fill-opacity="0.5" stroke-opacity="0.8">
  <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
</svg>
<?php echo $value['tel']; ?></td>
        </tr>
      <?php
      } ?>
  </tbody>
</table>




</main>
<button type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>

  <!-- FOOTER -->
  <?php
  include("./footer.php");
  ?>
<script src="../js/jquery-3.2.1.min.js" ></script>
      <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/tableToCards.js"></script>
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
</html>
