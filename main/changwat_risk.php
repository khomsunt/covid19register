<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');


// $sql_current_cut=" select c.*, count(a.ampur_code) as ampur_total from changwat c
// LEFT JOIN ampur a on c.changwat_code = a.changwat_code
// GROUP BY a.changwat_code";
$sql_current_cut="select c.*, 
sum(a.ampur_total) as ampur_total,
sum(a.total_risk_ampur0) as total_risk_ampur0,
sum(a.total_risk_ampur1) as total_risk_ampur1,
sum(a.total_risk_ampur2) as total_risk_ampur2,
sum(a.total_risk_ampur3) as total_risk_ampur3,
sum(a.total_risk_ampur4) as total_risk_ampur4,
sum(a.total_risk_ampur5) as total_risk_ampur5,
sum(a.total_risk_ampur6) as total_risk_ampur6
from changwat c
LEFT JOIN 
(SELECT changwat_code,
count(ampur_code) as ampur_total,
sum(if(risk_status_id='0',1,0)) as total_risk_ampur0,
sum(if(risk_status_id='1',1,0)) as total_risk_ampur1,
sum(if(risk_status_id='2',1,0)) as total_risk_ampur2,
sum(if(risk_status_id='3',1,0)) as total_risk_ampur3, 
sum(if(risk_status_id='4',1,0)) as total_risk_ampur4,
sum(if(risk_status_id='5',1,0)) as total_risk_ampur5,
sum(if(risk_status_id='6',1,0)) as total_risk_ampur6  
FROM ampur  GROUP BY changwat_code) a on c.changwat_code = a.changwat_code
GROUP BY c.changwat_code;";
$obj=$connect->prepare($sql_current_cut);
$obj->execute();
$rows_current_cut=$obj->fetchAll(PDO::FETCH_ASSOC);
//print_r($rows_current_cut);
?>

<!doctype html>
<html lang="en">
  <head>
  <?php
    header("Cache-Control: private, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Changwat Risk</title>

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
<br>
<table class="table" id="myTable">
  <thead>
    <tr>
      <th data-card-title style="text-align: center;">ลำดับ</th>
      <th data-card-title style="text-align: left;">จังหวัด</th>
      <th style="text-align: center;">อำเภอทั้งหมด</th>
      <!-- <th style="text-align: center;">เสี่ยงต่ำมาก</th> -->
      <th style="text-align: center;">เสี่ยงต่ำ</th>
      <th style="text-align: center;">เสี่ยงปานกลาง</th>
      <th style="text-align: center;">เสี่ยงสูง</th>
      <th style="text-align: center;">เสี่ยงสูงสุด</th>
      <th style="text-align: center;">เสี่ยงสูงสุดเข้มงวด</th>
      <th style="text-align: center;">เคยเป็นพื้นที่เสี่ยงสูง</th>
      <th style="text-align: center;">รายละเอียด</th>
    </tr>
  </thead>
  <tbody>
      <?php
      $i = 0;
      foreach ($rows_current_cut as $key => $value) {
          ?>
        <tr>
            <td style="text-align: center;"><?php echo ++$i; ?></td>
            <td style="text-align: left;"><?php echo $value['changwat_name']; ?></td>
            <td style="text-align: center;"><?php echo $value['ampur_total']; ?></td>
            <!-- <td style="text-align: center;"><?php echo $value['total_risk_ampur0']; ?></td> -->
            <td style="text-align: center;"><?php echo $value['total_risk_ampur1']; ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_ampur2']; ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_ampur4']; ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_ampur3']; ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_ampur5']; ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_ampur6']; ?></td>
            <td style="text-align: center;">
              <button changwat_code = "<?php echo $value['changwat_code']; ?>" changwat_name = "<?php echo $value['changwat_name']; ?>"  type="button" class="btn btn-info tag-link">รายละเอียด</button>
            </td>
          </tr>
        <?php
    }?>
  </tbody>
    
</table>
</main>
  <!-- FOOTER -->
  <?php
  include("./footer.php");
  ?>
<script src="../js/jquery-3.2.1.min.js" ></script>
      <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/tableToCards.js"></script>
      <script>
        $(function(){
            $(".tag-link").click(function(){
                console.log($(this).attr("changwat_code"));
                var form = $('<form action="./ampur_risk.php" method="post"><input type="hidden" name="changwat_code" value="' + $(this).attr("changwat_code") + '"></input> <input type="hidden" name="changwat_name" value="' + $(this).attr("changwat_name") + '"></input>' + '</form>');
                $('body').append(form);
                $(form).submit(); 
            })
        })
      </script>
</html>
