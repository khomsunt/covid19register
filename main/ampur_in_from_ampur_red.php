<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$sql_report_risk="SELECT
    c.changwat_code,
    c.changwat_name,
    a.ampur_code,
    a.ampur_name,
    a.ampur_code_full
    FROM
    ampur a
    left join changwat c on a.changwat_code = c.changwat_code
    where a.risk_status_id=3
    order by c.changwat_name,a.ampur_name ";
$obj=$connect->prepare($sql_report_risk);
$obj->execute();
$rows_report_risk=$obj->fetchAll(PDO::FETCH_ASSOC);

$sql_ampur_in="select 
    c.ampur_in_code,
    a.ampur_name, ";
$a_sql=[];
foreach ($rows_report_risk as $key => $value) {
    array_push($a_sql,"sum(if(c.changwat_in_code='".$value['changwat_code']."' and c.ampur_in_code='".$value['ampur_code']."',1,0)) as sum".$value['ampur_code_full']);
}
// print_r($a_sql);
$sql_ampur_in.=implode(",",$a_sql);
$sql_ampur_in.=" from covid_register c left join ampur a on c.ampur_in_code=a.ampur_code group by c.ampur_in_code";
echo $sql_ampur_in;
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title><?php echo $projectTitle; ?></title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">
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
        <h5>รายชื่ออำเภอเสี่ยงสูง</h5>
    </div>
    <table class="table" id="myTable">
    <thead>
        <tr>
        <th>ลำดับที่</th>
        <th>ชื่อจังหวัด</th>
        <th>ชื่ออำเภอ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total=0;
        foreach ($rows_report_risk as $key => $value) {
            ?>
            <tr>
                <td style="text-align: center";><?php echo $key+1; ?></td>
                <td><?php echo $value['changwat_name']; ?></td>
                <td><?php echo $value['ampur_name']; ?></td>
            </tr>    
        <?php
        } ?>
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
</html>
