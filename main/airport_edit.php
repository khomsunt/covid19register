<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
include_once('../include/config.php');
include_once('../include/functions.php');
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
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>
    .row_data:hover {
      background-color: #E2E2E2 !important;
    }
    .btn-orange, .btn-orange:hover, .btn-orange:active, .btn-orange:visited {
        background-color: #FF8800 !important;
    }    
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
  <link href="../css/carousel.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
include("./header.php");

$where="";
if ($_GET['search_text']!='') {
  $where.=" and concat(cid,' ',fname,' ',lname) like '%".$_GET['search_text']."%' ";
}

$sql="select now() datetime_query,c.*,of.office_code flight
,CONCAT('อ.',if(a.ampur_name<>'',a.ampur_name,''),' ','จ.',if(cw.changwat_name<>'',cw.changwat_name,'')) addr_home
,CONCAT('อ.',if(a2.ampur_name<>'',a2.ampur_name,''),' ','จ.',if(cw2.changwat_name<>'',cw2.changwat_name,'')) addr_work
from covid_register c 
left join changwat cw on c.changwat_out_code=cw.changwat_code 
left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code
left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code
left join changwat cw2 on c.changwat_work_code=cw2.changwat_code 
left join ampur a2 on c.changwat_work_code=a2.changwat_code and c.ampur_work_code=a2.ampur_code
left join tambon t2 on c.changwat_work_code=t2.changwat_code and c.ampur_work_code=t2.ampur_code and c.tambon_work_code=t2.tambon_code
left join ampur47 a47 on c.ampur_in_code=a47.ampur_code
left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code
left join coccupation o on c.occupation_id=o.occupation_id
left join cut_status r on c.cut_status_id=r.cut_status_id
left join office of on c.checkpoint_id = of.office_id 
where c.cut_status_id not in (2,3) 
and date_to_sakonnakhon = left(now(),10) and airport_screen_A1_datetime is null and airport_screen_B1_datetime is null
".$where."
order by date_to_sakonnakhon,of.office_code,CONVERT(fname USING tis620),CONVERT(lname USING tis620)
";
// echo "<br><br><br><br>".$sql;
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

$sql_now=" select left(now(),10) dn ";
$obj_now=$connect->prepare($sql_now);
$obj_now->execute();
$rows_now=$obj_now->fetchAll(PDO::FETCH_ASSOC);

?>

<br>

<div style="padding: 10px;">

<table style="width: 100%;">
  <tr>
    <td><h3>แก้ไข Flight</h3></td>
    <td style="text-align: right;font-size: 24px;">
      วันที่ <?php echo thailongdate($rows_now[0]['dn']); ?>
    </td>
  <tr>
</table>
<table>
  <tr>
    <td><input type="text" id="search_text" style="width: 400px;"></td>
    <td><input type="button" value="ค้นหา" id="search_button"></td>
  </tr>
</table>

<table style="border: solid 1px #000000;  padding: 5px; width: 100%;" id="tdata">
<tr>
  <td style="border: solid 1px #000000;  padding: 5px;">ลำดับ</td>
  <td style="border: solid 1px #000000;  padding: 5px;">FLIGHT</td>
  <td style="border: solid 1px #000000;  padding: 5px;">ชื่อ-สกุล</td>
  <td style="border: solid 1px #000000;  padding: 5px;">เลขบัตรประชาชน</td>
  <td style="border: solid 1px #000000;  padding: 5px;">ที่อยู่ก่อนเข้าสกลนคร</td>
  <td style="border: solid 1px #000000;  padding: 5px;">ที่ทำงาน</td>
  <td style="border: solid 1px #000000;  padding: 5px;"><br></td>
</tr>
<?php
for ($i=0;$i<count($rows);$i++) {
  $last_id="";
  if ($i+1==count($rows)) {
    $last_id="last_id";
  }
  $display_unpassB1_button="hidden";
  if ($rows[$i]['airport_screen_result_id']!='') {
    $display_unpassB1_button="visible";
  }
?>
<tr class="row_data">
  <td style="border: solid 1px #000000;  padding: 5px;" class="no"><?php echo ($i+1);?></td>
  <td style="border: solid 1px #000000;  padding: 5px;" class="flight"><?php echo $rows[$i]['flight'];?></td>
  <td style="border: solid 1px #000000;  padding: 5px;" class="flname"><?php echo $rows[$i]['fname'];?> <?php echo $rows[$i]['lname'];?></td>
  <td style="border: solid 1px #000000;  padding: 5px;" class="cid"><?php echo $rows[$i]['cid'];?></td>
  <td style="border: solid 1px #000000;  padding: 5px;" class="addr_home"><?php echo $rows[$i]['addr_home'];?></td>
  <td style="border: solid 1px #000000;  padding: 5px;" class="addr_work"><?php echo $rows[$i]['addr_work'];?></td>
  <td style="border: solid 1px #000000;  padding: 5px; white-space: nowrap;">
<?php
$f407="";
$f408="";
$f409="";
$f410="";
if ($rows[$i]['checkpoint_id']=='407') { $f407="selected"; }
if ($rows[$i]['checkpoint_id']=='408') { $f408="selected"; }
if ($rows[$i]['checkpoint_id']=='409') { $f409="selected"; }
if ($rows[$i]['checkpoint_id']=='410') { $f410="selected"; }
// echo $f407."|".$f408."|".$f409."|".$f410;
?>
    <select class="flight" style="margin-right: 10px;">
      <option value="">--เลือก--</options>
      <option value="407" <?php echo $f407;?> >NOKAIR DD360</options>
      <option value="408" <?php echo $f408;?> >NOKAIR DD364</options>
      <option value="409" <?php echo $f409;?> >NOKAIR DD368</options>
      <option value="410" <?php echo $f410;?> >AIRASIA FD3510</options>
    </select>
    <input type="button" value="บันทึก" class="change_flight" covid_register_id="<?php echo $rows[$i]['covid_register_id'];?>" >
  </td>
</tr>
<?php
}
?>
</table>


<?php
include("./footer.php");
?>
</div>

<div class="modal fade" id="modal01" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal01_body" style="margin-top:30px; margin-bottom: 30px;">
        กำลังประมวลผล ...
      </div>
      <div class="modal-footer" id="modal01_action" style="text-align: right; display: none;">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal02" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal02_body" style="margin-top:30px; margin-bottom: 30px;">
        กรุณากรอกข้อมูลให้ครบ
      </div>
      <div class="modal-footer" id="modal02_action" style="text-align: right; ">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>

<script>
  window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')
</script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script>
$(function(){

$(".change_flight").click(function() {
  $("#modal01").modal('show');
  let covid_register_id = $(this).attr("covid_register_id");
  let checkpoint_id = $(this).parent().find('.flight').val();
  let data={ covid_register_id : covid_register_id, checkpoint_id : checkpoint_id };
    // console.log(data);
  $.ajax({method: "POST", url: "airport_ajax_edit_flight.php",
    data: data
  })
  .done(function(msg) {
    window.location="airport_edit.php";
  });
});

$("#search_button").click(function() {
  let search_text = $("#search_text").val();
  window.location="airport_edit.php?search_text="+search_text;
});

});
</script>
