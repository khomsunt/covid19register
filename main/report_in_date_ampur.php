<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']=='1' or $_SESSION['group_id']=='2'){
include('../include/config.php');
include('../include/functions.php');

$sql_report_risk="SELECT
c.date_to_sakonnakhon,
 a.ampur_code,
a.ampur_name,
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
( c.evaluate_level = 4, 1, 0 )) AS weak_red,
count(*) AS count_all 
FROM
covid_register c
left join ampur47 a on c.ampur_in_code = a.ampur_code";
$sql_report_risk.=" where date_to_sakonnakhon = '".$_POST['date_to_sakonnakhon']."'"; 

$sql_report_risk.=" GROUP BY
ampur_code";
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
    <title>รายงานข้อมูลกลุ่มเสี่ยงแยกตามอำเภอ</title>

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
<main role="main" style="margin-top:90px;">
<!-- <?php print_r($sql_report_risk);?> -->
    <div class="container">
        <h5>รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนคร ประจำวันที่ <?php echo thailongdate($_POST[('date_to_sakonnakhon')]) ?> แยกตามอำเภอ</h5>
    </div>
    <button  type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>
    <table class="table" id="myTable">
    <thead>
        <tr>
        <th style="text-align: center";>ลำดับที่</th>
        <th>ชื่ออำเภอ</th>
        <th style="text-align: center";>เสี่ยงต่ำมาก</th>
        <th style="text-align: center";>เสี่ยงต่ำ</th>
        <th style="text-align: center";>เสี่ยงปานกลาง</th>      
        <th style="text-align: center";>เสี่ยงสูง</th>  
        <th style="text-align: center";>เสี่ยงสูงมาก</th>    
        <th style="text-align: center";>จำนวนทั้งหมด</th>  
       
        </tr>
    </thead>
    <tbody>
        <?php
        if ($_SESSION['group_id']>0){
        $i = 0;
        $rowTotal1 = 0;
        $rowTotal2 = 0;
        $rowTotal3 = 0;
        $rowTotal4 = 0;
        $rowTotal5 = 0;
        $rowTotal6 = 0;
        foreach ($rows_report_risk as $key => $value) 
        {
            ?>
            <tr>
                <td style="text-align: center"; ><?php echo ++$i; ?></td>
                <td><?php echo $value['ampur_name']; ?></td>
                <td style="text-align: center";><?php echo $value['green']; $rowTotal1 += $value['green']; ?></td>
                <td style="text-align: center";><?php echo $value['yellow']; $rowTotal2 += $value['yellow']; ?></td>
                <td style="text-align: center";><?php echo $value['orange']; $rowTotal3 += $value['orange']; ?></td>
                <td style="text-align: center";><?php echo $value['weak_red']; $rowTotal4 += $value['weak_red']; ?></td>
                <td style="text-align: center";><?php echo $value['red']; $rowTotal5 += $value['red']; ?></td>
                <td style="text-align: center";><?php echo $value['count_all']; $rowTotal6 += $value['count_all']; ?></td>
            </tr>
            <?php
        }
      ?>
      <td><div></div></td>
        <td><div class="data" style="text-align: center";>รวม</div></td>
        <td><div class="data" style="text-align: center";><?php echo $rowTotal1; ?></div></td>
        <td><div class="data" style="text-align: center";><?php echo $rowTotal2; ?></div></td>
        <td><div class="data" style="text-align: center";><?php echo $rowTotal3; ?></div></td>
        <td><div class="data" style="text-align: center";><?php echo $rowTotal4; ?></div></td>
        <td><div class="data" style="text-align: center";><?php echo $rowTotal5; ?></div></td>
        <td><div class="data" style="text-align: center";><?php echo $rowTotal6; ?></div></td>

      <?php } ?> 
    </tbody>
    </table>
    
    <button  type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>
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

</script>
<script type="text/javascript">
            var $btnDLtoExcel = $('.btn_cut_print');
                    var file_name="<?php echo thailongdate($_POST[('date_to_sakonnakhon')]) ?>";
            file_name=file_name.replaceAll('-','');
            file_name=file_name.replaceAll(' ','');
            file_name=file_name.replaceAll(':','');
            $btnDLtoExcel.on('click', function Export() {
            $("#myTable").table2excel({
                filename: 'รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนครประจำวันที่'+file_name+'.xls'
            });
            });



        </script>
     
</html>
<?php } ?>