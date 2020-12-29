<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
include('../include/functions.php');

$sql_report_risk="SELECT
c.date_to_sakonnakhon,
sum(
IF
( c.evaluate_level = 0, 1, 0 )) AS green,
sum(
IF
( c.evaluate_level = 1, 1, 0 )) AS yellow,
sum(
IF
( c.evaluate_level = 2, 1, 0 )) AS orange,
sum(
IF
( c.evaluate_level = 3, 1, 0 )) AS red,
sum(
IF
( c.evaluate_level = 99, 1, 0 )) AS gray,
count(*) AS count_all 
FROM
covid_register c";
if ($_SESSION['group_id']==8 or $_SESSION['group_id']==9){
  $sql_report_risk.=" where c.hospcode='".$_SESSION['office_code']."'"; 
}
$sql_report_risk.=" GROUP BY
date_to_sakonnakhon";
$obj=$connect->prepare($sql_report_risk);
$obj->execute();
$rows_report_risk=$obj->fetchAll(PDO::FETCH_ASSOC);
//print_r($sql_report_risk);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนคร แยกวันตามวันที่</title>

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
        <h5>รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนคร แยกวันตามวันที่</h5>
    </div>
    <table class="table" id="myTable">
    <thead>
        <tr>
        <th style="text-align: center";>ลำดับที่</th>
        <th style="text-align: center";>วันที่เดินทางเข้าถึงสกลนคร</th>
        <th style="text-align: center";>สีเขียว</th>
        <th style="text-align: center";>สีเหลือง</th>
        <th style="text-align: center";>สีส้ม</th>      
        <th style="text-align: center";>สีแดง</th>  
        <th style="text-align: center";>สีเทา</th>  
        <th style="text-align: center";>จำนวนทั้งหมด</th>
        <?php if($_SESSION['group_id']!=8 || $_SESSION['group_id']==9 ) { ?>
        <th style="text-align: center";>รายอำเภอ</th>  
       <?php  } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($rows_report_risk as $key => $value) 
        {
            ?>
            <tr>
                <td style="text-align: center";><?php echo ++$i; ?></td>
                <td  style="text-align: center";>
                  <div class="tag-list"  date_to_sakonnakhon = "<?php echo $value['date_to_sakonnakhon']; ?>" office_code ="<?php echo $_SESSION['office_code']; ?>">
                <?php if($value['date_to_sakonnakhon'] == "0000-00-00") { ?>
                  ไม่ทราบวันที่มาถึง
                <?php  } ?>
                <?php if($value['date_to_sakonnakhon'] != "0000-00-00") { ?>
                  <?php echo thailongdate($value['date_to_sakonnakhon']);?>
                <?php  } ?>
                </div>
                </td>
                <td style="text-align: center";><?php echo $value['green']; ?></td>
                <td style="text-align: center";><?php echo $value['yellow']; ?></td>
                <td style="text-align: center";><?php echo $value['orange']; ?></td>
                <td style="text-align: center";><?php echo $value['red']; ?></td>
                <td style="text-align: center";><?php echo $value['gray']; ?></td>
                <td style="text-align: center";><?php echo $value['count_all']; ?></td>
                <?php if($_SESSION['group_id']!=8 || $_SESSION['group_id']==9 ) { ?>
                <div>
                  <td style="text-align: center;">
                    <button date_to_sakonnakhon = "<?php echo $value['date_to_sakonnakhon']; ?>" type="button" class="btn btn-info tag-link">รายละเอียด</button>
                </td>
                </div>
                <?php } ?>
            </tr>
            <?php
        }?>
    </tbody>
    </table>
</main>

<div id="forExcelExport" style="display: none;"></div>

<!-- FOOTER -->
<?php
include("./footer.php");
?>
<script src="../js/jquery-3.2.1.min.js" ></script>
<script>
  window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')
</script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tableToCards.js"></script>
<script src='../js/table2excel.js'></script>
<script>
$(function(){
  $(".tag-link").click(function(){
      console.log($(this).attr("date_to_sakonnakhon"));
      var form = $('<form action="./report_in_date_ampur.php" method="post"><input type="hidden" name="date_to_sakonnakhon" value="' + $(this).attr("date_to_sakonnakhon") + '"></input>' + '</form>');
      $('body').append(form);
      $(form).submit();                
  });

  $(".tag-list").click(function(){
      console.log($(this).attr("date_to_sakonnakhon"));
      var form = $('<form action="./report_in_date_list.php" method="post"><input type="hidden" name="date_to_sakonnakhon" value="' + $(this).attr("date_to_sakonnakhon") + '"></input><input type="hidden" name="hospcode" value="' + $(this).attr("hospcode") + '"></input>' + '</form>');
      $('body').append(form);
      $(form).submit();                
  });
})
</script>
      
</html>
