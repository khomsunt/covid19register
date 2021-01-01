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
    .checkbox_topic_changwat:hover {
      cursor: pointer;
      color: lime;
    }
    #filter_status {
      color: red;
    }
    #filter_status:hover {
      cursor: pointer;
      color: black;
    }
  </style>
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  
</head>
<body>
<?php
include("./header.php");
?>
  <main role="main" style="margin-top:90px;">

    <div class="container">
      <h5>รายงานจำนวนผู้เดินทางเข้าจังหวัดสกลนคร ณ วันเวลา <?php echo $datetime_now; ?> แยกตามอำเภอ</h5>
      คำอธิบาย: รายใหม่ หมายถึง รายใหม่ในวันที่ประมวลผลรายงาน
    </div>
    <div style='margin: 20px;'>
      <div><b>ตัวกรอง : </b>จังหวัดเสี่ยง(ตามประกาศจังหวัดสกลนคร) [ <span id="filter_status">แสดง</span> ]</div>
      <div id="div_filter" style="display: none;">
<?php
$sql=" select * from (
select c.changwat_code,c.changwat_name,max(a.risk_status_id) changwat_risk_status,group_concat(concat(a.ampur_code_full,'|',a.ampur_name,'|',a.risk_status_id)) ampur_info
from changwat c 
inner join ampur a on a.changwat_code=c.changwat_code 
group by c.changwat_code
) x
where x.changwat_risk_status in (3,2)
";
$obj=$connect->prepare($sql);
$obj->execute();
$ampurRisk=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($ampurRisk);
?>
      <div>
        สีแดง
        <div>
<?php
for ($i=0;$i<count($ampurRisk);$i=$i+1) {
  if ($ampurRisk[$i]['changwat_risk_status']==3) {
    // echo "- ".$ampurRisk[$i]['changwat_name']."|".$ampurRisk[$i]['changwat_risk_status']."----".$ampurRisk[$i]['ampur_info']."<br>";
?>
          <div style="margin-bottom:5px">
            <div class="checkbox_topic_changwat" expanded="N" id="changwat_<?php echo $ampurRisk[$i]['changwat_code']; ?>" changwat_code="<?php echo $ampurRisk[$i]['changwat_code']; ?>">
              [<span class="icon_expand">+</span>] <?php echo $ampurRisk[$i]['changwat_name']; ?> 
            </div>
            <div id="ampur_list_<?php echo $ampurRisk[$i]['changwat_code']; ?>" style="margin-left: 25px; display: none;">
<?php
    if ($ampurRisk[$i]['ampur_info']!='') {
?>
              <div class="form-check" style="margin-bottom:5px">
                <input type="checkbox" class="form-check-input checkbox_all" id="ampur_all_<?php echo $ampurRisk[$i]['changwat_code']; ?>" changwat_code_all="<?php echo $ampurRisk[$i]['changwat_code']; ?>">
                <label class="form-check-label" for="ampur_all_<?php echo $ampurRisk[$i]['changwat_code']; ?>">
                  เลือกทั้งหมด
                </label>
              </div>
<?php
      $x=explode(",",$ampurRisk[$i]['ampur_info']);
      for ($n=0;$n<count($x);$n=$n+1) {
        $a=explode("|",$x[$n]);
        if ($a[2]==3) {
?>
              <div class="form-check" style="margin-bottom:5px">
                <input type="checkbox" class="form-check-input checkbox_ampur" id="ampur_<?php echo $a[0]; ?>" ampur_code="<?php echo $a[0]; ?>" changwat_code="<?php echo $ampurRisk[$i]['changwat_code']; ?>">
                <label class="form-check-label" for="ampur_<?php echo $a[0]; ?>">
                  <?php echo $a[1]; ?> 
                </label>
              </div>
<?php
        }
      }
    }
?>
            </div>
          </div>
<?php
  }
}
?>
        </div>
      </div>
    </div>
    </div>

<script>
$(".checkbox_all").click(function() {
  var changwat_code=$(this).attr('changwat_code_all');
  if ($(this).prop('checked')==true) {
    $('input[changwat_code="'+changwat_code+'"]').prop('checked',true);
  }
  else {
    $('input[changwat_code="'+changwat_code+'"]').prop('checked',false);
  }
});

$(".checkbox_topic_changwat").click(function() {
  if ($(this).attr('expanded')=='N') {
    $("#ampur_list_"+$(this).attr('changwat_code')).css({'display':'block'});
    $(this).attr('expanded','Y');
  }
  else {
    $("#ampur_list_"+$(this).attr('changwat_code')).css({'display':'none'});
    $(this).attr('expanded','N');
  }
});

$("#filter_status").click(function() {
  if ($(this).text()=="แสดง") {
    $("#div_filter").css('display','block');
    $(this).text('ซ่อน');
  }
  else {
    $("#div_filter").css('display','none');
    $(this).text('แสดง');
  }
});
</script>
<?php
$sql=" 
select a.ampur_code_full,a.ampur_name

,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='74' or changwat_work_code='74') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw74_newinday' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='74' or changwat_work_code='74'),1,0)) 'col_cw74_total' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='21' or changwat_work_code='21') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw21_newinday' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='21' or changwat_work_code='21'),1,0)) 'col_cw21_total' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='73' or changwat_work_code='73') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw73_newinday' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='73' or changwat_work_code='73'),1,0)) 'col_cw73_total' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='20' or changwat_work_code='20') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw20_newinday' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='20' or changwat_work_code='20'),1,0)) 'col_cw20_total' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='10' or changwat_work_code='10') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw10_newinday' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='10' or changwat_work_code='10'),1,0)) 'col_cw10_total' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='12' or changwat_work_code='12') and left(register_datetime,10)='".$date_now."',1,0)) 'col_cw12_newinday' 
,sum(if ((ao.risk_status_id=3 or aw.risk_status_id=3 or zo.risk_status_id=3 or zw.risk_status_id=3) and (changwat_out_code='12' or changwat_work_code='12'),1,0)) 'col_cw12_total' 

,sum(if ((co.control_id=3 or cw.control_id=3) and left(register_datetime,10)='".$date_now."',1,0)) 'col_control3_newinday' 
,sum(if (co.control_id=3 or cw.control_id=3,1,0)) 'col_control3_total' 
,sum(if ((co.control_id=2 or cw.control_id=2) and left(register_datetime,10)='".$date_now."',1,0)) 'col_control2_newinday' 
,sum(if (co.control_id=2 or cw.control_id=2,1,0)) 'col_control2_total' 
,sum(if ((co.control_id=1 or cw.control_id=1) and left(register_datetime,10)='".$date_now."',1,0)) 'col_control1_newinday' 
,sum(if (co.control_id=1 or cw.control_id=1,1,0)) 'col_control1_total' 

,count(distinct c.covid_register_id and left(register_datetime,10)='".$date_now."') 'col_register_all_newinday' 
,count(distinct c.covid_register_id) 'col_register_all_total' 
,sum(if(risk_level_user_id is not null and risk_level_user_id!='' and risk_level_user_id>0 and date_arrived_sakonnakhon is not null and date_arrived_sakonnakhon<='".$date_now."' and left(risk_level_datetime,10)='".$date_now."',1,0)) 'col_arrived_sakonnakhon_newinday'
,sum(if(risk_level_user_id is not null and risk_level_user_id!='' and risk_level_user_id>0 and date_arrived_sakonnakhon is not null,1,0)) 'col_arrived_sakonnakhon_total'

from covid_register c
inner join ampur47 a on a.ampur_code_full=concat(c.changwat_in_code,c.ampur_in_code)
left join ampur ao on ao.ampur_code_full=concat(c.changwat_out_code,c.ampur_out_code)
left join ampur aw on aw.ampur_code_full=concat(c.changwat_work_code,c.ampur_work_code)
left join (select * from tambon where risk_status_id=3) zo on zo.tambon_code_full=concat(c.changwat_out_code,c.ampur_out_code,c.tambon_out_code)
left join (select * from tambon where risk_status_id=3) zw on zw.tambon_code_full=concat(c.changwat_work_code,c.ampur_work_code,c.tambon_work_code)
left join changwat_control co on co.changwat_code=c.changwat_out_code
left join changwat_control cw on cw.changwat_code=c.changwat_work_code
where c.cut_status_id!=2 and c.register_datetime<='".$datetime_now."' 
group by a.ampur_code_full
order by a.ampur_code_full
";
// echo $sql;
?>
    <button  type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>
    <table class="table" id="myTable">
    <thead>
      <tr>
      <th style="text-align: center;" rowspan=3>ลำดับที่</th>
      <th rowspan=3>ชื่ออำเภอ</th>
      <th style="text-align: center;" colspan=2 rowspan=2>ลงทะเบียนเข้าสกลนคร</th>  
      <th style="text-align: center;" colspan=2 rowspan=2>เข้าถึงพื้นที่สกลนครแล้ว</th>
      <th style="text-align: center; background-color: #e9e9e9;" colspan=12>แบ่งพื้นที่เสี่ยงตามประกาศ จังหวัดสกลนคร<br>(พื้นที่<span style="color: red;">สีแดง</span>)</th>
      <th style="text-align: center;" colspan=6>แบ่งพื้นที่เสี่ยงตามประกาศ ศบค.<br>(พื้นที่ <span style="color: #EB921B;">สีส้ม</span>, <span style="background: yellow; color: black;">สีเหลือง</span>, <span style="color: #20BD04;">สีเขียว</span>)</th>
      </tr>

      <tr>
      <th style="text-align: center; background-color: #e9e9e9;" colspan=2>สมุทรสาคร</th>
      <th style="text-align: center; background-color: #e9e9e9;" colspan=2>ระยอง</th>
      <th style="text-align: center; background-color: #e9e9e9;" colspan=2>นครปฐม</th>
      <th style="text-align: center; background-color: #e9e9e9;" colspan=2>ชลบุรี</th>
      <th style="text-align: center; background-color: #e9e9e9;" colspan=2>กทม.</th>
      <th style="text-align: center; background-color: #e9e9e9;" colspan=2>นนทบุรี</th>
      <th style="text-align: center;" colspan=2>พื้นที่ควบคุม</th>
      <th style="text-align: center;" colspan=2>พื้นที่เฝ้าระวังสูงสุด</th>  
      <th style="text-align: center;" colspan=2>พื้นที่เฝ้าระวัง</th>  
      <!-- <th style="text-align: center;" colspan=3>ผลตรวจ</th> -->
      </tr>

      <tr>
      <th style="text-align: center;">ใหม่</th>
      <th style="text-align: center;">สะสม</th>
      <th style="text-align: center;">ใหม่</th>
      <th style="text-align: center;">สะสม</th>
      <th style="text-align: center; background-color: #e9e9e9;">ใหม่</th>
      <th style="text-align: center; background-color: #e9e9e9;">สะสม</th>
      <th style="text-align: center; background-color: #e9e9e9;">ใหม่</th>
      <th style="text-align: center; background-color: #e9e9e9;">สะสม</th>
      <th style="text-align: center; background-color: #e9e9e9;">ใหม่</th>
      <th style="text-align: center; background-color: #e9e9e9;">สะสม</th>
      <th style="text-align: center; background-color: #e9e9e9;">ใหม่</th>
      <th style="text-align: center; background-color: #e9e9e9;">สะสม</th>
      <th style="text-align: center; background-color: #e9e9e9;">ใหม่</th>
      <th style="text-align: center; background-color: #e9e9e9;">สะสม</th>
      <th style="text-align: center; background-color: #e9e9e9;">ใหม่</th>
      <th style="text-align: center; background-color: #e9e9e9;">สะสม</th>
      <th style="text-align: center;">ใหม่</th>
      <th style="text-align: center;">สะสม</th>
      <th style="text-align: center;">ใหม่</th>
      <th style="text-align: center;">สะสม</th>
      <th style="text-align: center;">ใหม่</th>
      <th style="text-align: center;">สะสม</th>
      <!-- <th style="text-align: center;">ไม่พบเชื้อ</th>
      <th style="text-align: center;">พบเชื้อ</th>
      <th style="text-align: center;">รอผล</th> -->
      </tr>
    </thead>
    <tbody>
<?php
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
if ($_SESSION['group_id']>0){
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
  $s_col_cw12_newinday=0;
  $s_col_cw12_total=0;
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
                <td class="data_td" style="text-align: center;"><?php echo $value['col_register_all_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_register_all_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_arrived_sakonnakhon_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_arrived_sakonnakhon_total']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw74_newinday']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw74_total']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw21_newinday']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw21_total']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw73_newinday']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw73_total']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw20_newinday']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw20_total']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw10_newinday']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw10_total']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw12_newinday']; ?></td>
                <td class="data_td" style="text-align: center; background-color: #e9e9e9;"><?php echo $value['col_cw12_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control3_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control3_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control2_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control2_total']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control1_newinday']; ?></td>
                <td class="data_td" style="text-align: center;"><?php echo $value['col_control1_total']; ?></td>
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
    $s_col_cw12_newinday += $value['col_cw12_newinday'];
    $s_col_cw12_total += $value['col_cw12_total'];
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
        <td><div class="data" style="text-align: center;"><?php echo $s_col_register_all_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_register_all_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_arrived_sakonnakhon_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_arrived_sakonnakhon_total; ?></div></td>
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
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw12_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_cw12_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control3_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control3_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control2_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control2_total; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control1_newinday; ?></div></td>
        <td><div class="data" style="text-align: center;"><?php echo $s_col_control1_total; ?></div></td>
      </tr>
<?php 
}
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