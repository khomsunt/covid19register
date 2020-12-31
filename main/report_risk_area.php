<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// if ($_SESSION['group_id']=='1' | $_SESSION['group_id']=='2'){
if (1==1) {
include('../include/config.php');
include('../include/functions.php');


$sql=" select now() x ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
$datetime_now=$rows[0]['x'];
$date_now=substr($datetime_now,0,10);
// echo "<br><br><br><br><br>".date('Y-m-d H:i:s');
// echo "<br>".$datetime_now;
// echo "<br>".$date_now;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>รายงานจำนวนผู้เดินทางเข้าจังหวัดสกลนคร</title>

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
        <h5>รายงานจำนวนผู้เดินทางเข้าจังหวัดสกลนคร ณ วันเวลา <?php echo $datetime_now; ?> แยกตามอำเภอ</h5>
คำอธิบาย: รายใหม่ หมายถึง รายใหม่ในวันที่ประมวลผลรายงาน
    </div>
    <button  type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>
    <table class="table" id="myTable">
    <thead>
        <tr>
        <th style="text-align: center;" rowspan=2>ลำดับที่</th>
        <th rowspan=2>ชื่ออำเภอ</th>
        <th style="text-align: center;" colspan=2>สมุทรสาคร</th>
        <th style="text-align: center;" colspan=2>ระยอง</th>
        <th style="text-align: center;" colspan=2>นครปฐม</th>
        <th style="text-align: center;" colspan=2>ชลบุรี</th>
        <th style="text-align: center;" colspan=2>กทม.</th>
        <th style="text-align: center;" colspan=2>พื้นที่ควบคุม</th>
        <th style="text-align: center;" colspan=2>พื้นที่เฝ้าระวังสูงสุด</th>  
        <th style="text-align: center;" colspan=2>พื้นที่เฝ้าระวัง</th>  
        <th style="text-align: center;" colspan=2>ลงทะเบียนเข้าสกลนคร</th>  
        <th style="text-align: center;" colspan=2>เข้าถึงพื้นที่สกลนครแล้ว</th>
        <th style="text-align: center;" colspan=3>ผลตรวจ</th>
        </tr>

        <tr>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ใหม่</th>
        <th style="text-align: center;">สะสม</th>
        <th style="text-align: center;">ไม่พบเชื้อ</th>
        <th style="text-align: center;">พบเชื้อ</th>
        <th style="text-align: center;">รอผล</th>
        </tr>
    </thead>
    <tbody>
<?php
$sql=" 
select a.ampur_code_full,a.ampur_name
,sum(if ((changwat_out_code='74' or changwat_work_code='74') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw74_newinday' 
,sum(if (changwat_out_code='74' or changwat_work_code='74',1,0)) 'col_cw74_total' 
,sum(if ((changwat_out_code='21' or changwat_work_code='21') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw21_newinday' 
,sum(if (changwat_out_code='21' or changwat_work_code='21',1,0)) 'col_cw21_total' 
,sum(if ((changwat_out_code='73' or changwat_work_code='73') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw73_newinday' 
,sum(if (changwat_out_code='73' or changwat_work_code='73',1,0)) 'col_cw73_total' 

,sum(if ((changwat_out_code='20' or changwat_work_code='20') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw20_newinday' 
,sum(if (changwat_out_code='20' or changwat_work_code='20',1,0)) 'col_cw20_total' 

,sum(if ((changwat_out_code='10' or changwat_work_code='10') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw10_newinday' 
,sum(if (changwat_out_code='10' or changwat_work_code='10',1,0)) 'col_cw10_total' 
,sum(if (co.control_id=3 or cw.control_id=3,1,0)) 'col_control3_newinday' 
,sum(if (co.control_id=3 or cw.control_id=3,1,0)) 'col_control3_total' 

,sum(if (co.control_id=2 or cw.control_id=2,1,0)) 'col_control2_newinday' 
,sum(if (co.control_id=2 or cw.control_id=2,1,0)) 'col_control2_total' 

,sum(if (co.control_id=1 or cw.control_id=1,1,0)) 'col_control1_newinday' 
,sum(if (co.control_id=1 or cw.control_id=1,1,0)) 'col_control1_total' 

,count(distinct c.covid_register_id) 'col_register_all_newinday' 
,count(distinct c.covid_register_id) 'col_register_all_total' 

,sum(if(risk_level_user_id is not null and risk_level_user_id!='' and risk_level_user_id>0 and date_arrived_sakonnakhon is not null and date_arrived_sakonnakhon<='".$date_now."' and left(risk_level_datetime,10)='".$date_now."',1,0)) 'col_arrived_sakonnakhon_newinday'
,sum(if(risk_level_user_id is not null and risk_level_user_id!='' and risk_level_user_id>0 and date_arrived_sakonnakhon is not null and date_arrived_sakonnakhon<='".$date_now."',1,0)) 'col_arrived_sakonnakhon_total'

from covid_register c
left join changwat_control co on co.changwat_code=c.changwat_out_code
left join changwat_control cw on cw.changwat_code=c.changwat_work_code
left join ampur47 a on a.ampur_code_full=concat(c.changwat_in_code,c.ampur_in_code)
where cut_status_id!=2 and register_datetime<='".$datetime_now."' 
and a.ampur_code_full is not null 
group by a.ampur_code_full
order by a.ampur_code_full
";
// echo "<tr><td colspan=50>".$sql."</td></tr>";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

// if ($_SESSION['group_id']>0){
if (1===1) {
  $i = 0;
  $s_col_cw74_newinday=0;
  $s_col_cw74_total=0;
  $s_col_cw21_newinday=0;
  $s_col_cw21_total=0;
  $s_col_cw73_newinday=0;
  $s_col_cw73_total=0;
  $s_col_cw20_newinday=0;
  $s_col_cw20_total=0;
  $s_col_cw10_newinday=0;
  $s_col_cw10_total=0;
  $s_col_control3_newinday=0;
  $s_col_control3_total=0;
  $s_col_control2_newinday=0;
  $s_col_control2_total=0;
  $s_col_control1_newinday=0;
  $s_col_control1_total=0;
  $s_col_register_all_newinday=0;
  $s_col_register_all_total=0;
  $s_col_arrived_sakonnakhon_newinday=0;
  $s_col_arrived_sakonnakhon_total=0;
  foreach ($rows as $key => $value) {
?>
            <tr class="data_tr">
                <td style="text-align: center"; ><?php echo ++$i; ?></td>
                <td><?php echo $value['ampur_name']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw74_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw74_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw21_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw21_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw73_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw73_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw20_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw20_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw10_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_cw10_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control3_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control3_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control2_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control2_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control1_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control1_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_register_all_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_register_all_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_arrived_sakonnakhon_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_arrived_sakonnakhon_total']; ?></td>
            </tr>
<?php
    $s_col_cw74_newinday += $value['col_cw74_newinday'];
    $s_col_cw74_total += $value['col_cw74_total'];
    $s_col_cw21_newinday += $value['col_cw21_newinday'];
    $s_col_cw21_total += $value['col_cw21_total'];
    $s_col_cw73_newinday += $value['col_cw73_newinday'];
    $s_col_cw73_total += $value['col_cw73_total'];
    $s_col_cw20_newinday += $value['col_cw20_newinday'];
    $s_col_cw20_total += $value['col_cw20_total'];
    $s_col_cw10_newinday += $value['col_cw10_newinday'];
    $s_col_cw10_total += $value['col_cw10_total'];
    $s_col_control3_newinday += $value['col_control3_newinday'];
    $s_col_control3_total += $value['col_control3_total'];
    $s_col_control2_newinday += $value['col_control2_newinday'];
    $s_col_control2_total += $value['col_control2_total'];
    $s_col_control1_newinday += $value['col_control1_newinday'];
    $s_col_control1_total += $value['col_control1_total'];
    $s_col_register_all_newinday += $value['col_register_all_newinday'];
    $s_col_register_all_total += $value['col_register_all_total'];
    $s_col_arrived_sakonnakhon_newinday += $value['col_arrived_sakonnakhon_newinday'];
    $s_col_arrived_sakonnakhon_total += $value['col_arrived_sakonnakhon_total'];
  }
?>
<!-- <tr class="data_tr_sum"></tr> -->
      <tr>
      <td><div></div></td>
        <td><div class="data" style="text-align: center;">รวม</div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw74_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw74_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw21_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw21_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw73_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw73_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw20_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw20_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw10_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw10_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control3_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control3_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control2_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control2_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control1_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control1_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_register_all_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_register_all_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_arrived_sakonnakhon_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_arrived_sakonnakhon_total; ?></div></td>

        </tr>
<?php 
} 
?> 
    </tbody>
    </table>
<script>

</script>

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
var file_name="<?php echo thailongdate($datetime_now) ?>";
file_name=file_name.replaceAll('-','');
file_name=file_name.replaceAll(' ','');
file_name=file_name.replaceAll(':','');
$btnDLtoExcel.on('click', function Export() {
  $("#myTable").table2excel({
    filename: 'รายงานจำนวนผู้เดินทางเข้าจังหวัดสกลนคร_'+file_name+'.xls'
  });
});
</script>
     
</html>
<?php 
} 
?>