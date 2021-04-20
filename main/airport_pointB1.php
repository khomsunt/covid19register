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
if ($_GET['office_id']!='') {
  $where.=" and c.checkpoint_id =".$_GET['office_id']." ";
}
else {
  $where.=" and c.checkpoint_id in (407,408,409,410) ";
}

if ($_GET['include_passed']=='true') {
  // --
}
else {
  $where.=" and airport_screen_B1_datetime is null ";
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
and date_to_sakonnakhon = left(now(),10) and airport_screen_A1_datetime is not null
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
    <td><h3>คัดกรองสนามบิน จุดที่ 2</h3></td>
    <td style="text-align: right;font-size: 24px;">วันที่ <?php echo thailongdate($rows_now[0]['dn']); ?> | FLIGHT : 
    <?php
$f407="";
$f408="";
$f409="";
$f410="";
if ($_GET['office_id']=='407') { $f407="selected"; }
if ($_GET['office_id']=='408') { $f408="selected"; }
if ($_GET['office_id']=='409') { $f409="selected"; }
if ($_GET['office_id']=='410') { $f410="selected"; }
// echo $f407."|".$f408."|".$f409."|".$f410;

$include_passed_checked="";
if ($_GET['include_passed']=='true') {
  $include_passed_checked=" checked ";
}
?>
      <select id="flight" style="font-size: 24px; margin-right: 10px;">
        <option value="">--ทั้งหมด--</options>
        <option value="407" <?php echo $f407;?> >NOKAIR DD360</options>
        <option value="408" <?php echo $f408;?> >NOKAIR DD364</options>
        <option value="409" <?php echo $f409;?> >NOKAIR DD368</options>
        <option value="410" <?php echo $f410;?> >AIRASIA FD3510</options>
      </select>
      <input type="checkbox" id="include_passed" <?php echo $include_passed_checked; ?>> 
      <label for="include_passed">แสดงทั้งหมด</label>
    </td>
  <tr>
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
    <input type="radio" class="radio_1" name="radio_<?php echo $rows[$i]['covid_register_id'];?>" value="1" id="neg72_<?php echo $rows[$i]['covid_register_id'];?>" <?php if ($rows[$i]['airport_screen_result_id']==1) { echo "checked"; } ?> > 
    <label class="radio_1" for="neg72_<?php echo $rows[$i]['covid_register_id'];?>">Neg72ชม.</label>

    <input type="radio" class="radio_2" name="radio_<?php echo $rows[$i]['covid_register_id'];?>" value="2" id="exam_<?php echo $rows[$i]['covid_register_id'];?>" <?php if ($rows[$i]['airport_screen_result_id']==2) { echo "checked"; } ?> > 
    <label class="radio_2" for="exam_<?php echo $rows[$i]['covid_register_id'];?>">ตรวจวันนี้</label>

    <input type="radio" class="radio_3" name="radio_<?php echo $rows[$i]['covid_register_id'];?>" value="3" id="notexam_<?php echo $rows[$i]['covid_register_id'];?>" <?php if ($rows[$i]['airport_screen_result_id']==3) { echo "checked"; } ?> > 
    <label class="radio_3" for="notexam_<?php echo $rows[$i]['covid_register_id'];?>">ไม่ตรวจ</label>

    <input type="button" value="บันทึก" class="passB1_button" covid_register_id="<?php echo $rows[$i]['covid_register_id'];?>" >
    <input type="button" value="ยกเลิก" class="unpassB1_button" covid_register_id="<?php echo $rows[$i]['covid_register_id'];?>" style="visibility: <?php echo $display_unpassB1_button;?>;">
  </td>
</tr>
<?php
}
?>
  <tr class="row_data master_row" style="display: none;">
    <td style="border: solid 1px #000000;  padding: 5px;" class="no"></td>
    <td style="border: solid 1px #000000;  padding: 5px;" class="flight"></td>
    <td style="border: solid 1px #000000;  padding: 5px;" class="flname"></td>
    <td style="border: solid 1px #000000;  padding: 5px;" class="cid"></td>
    <td style="border: solid 1px #000000;  padding: 5px;" class="addr_home"></td>
    <td style="border: solid 1px #000000;  padding: 5px;" class="addr_work"></td>
    <td style="border: solid 1px #000000;  padding: 5px; white-space: nowrap;">
      <input type="radio" class="radio_1" name="radio_0" value="1" id="neg72_0"> 
      <label class="radio_1" for="neg72_0">Neg72ชม.</label>
  
      <input type="radio" class="radio_2" name="radio_0" value="2" id="exam_0"> 
      <label class="radio_2" for="exam_0">ตรวจวันนี้</label>
  
      <input type="radio" class="radio_3" name="radio_0" value="3" id="notexam_0"> 
      <label class="radio_3" for="notexam_0">ไม่ตรวจ</label>
  
      <input type="button" value="บันทึก" class="passB1_button" covid_register_id="0" >
      <input type="button" value="ยกเลิก" class="unpassB1_button" covid_register_id="0" style="visibility: hidden;">
    </td>
  </tr>
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

let busy = false;
let all_rows=parseInt("<?php echo count($rows); ?>");
let datetime_query="<?php echo $rows[0]['datetime_query']; ?>";

findNewPassenger();

function findNewPassenger() {
  if (busy==true) {
    // console.log('busy-----#');
  }
  else {
    let data={ 
      office_id : $("#flight").val(),
      datetime_query : datetime_query,
    };
    $.ajax({method: "POST", url: "airport_ajax_passenger_listB1.php",
      data: data
    })
    .done(function(msg) {
      // console.log(msg);
      let x = JSON.parse(msg);
      console.log(datetime_query, x);
      if (x.length>0) {
        for (let i=0;i<x.length;++i) {
          all_rows=all_rows+1;
          let lastRow=$(".master_row").clone();
          lastRow.removeClass('master_row');
          lastRow.css('display','table-row');
          lastRow.find(".no").text(all_rows);
          lastRow.find(".flight").text(x[i]['flight']);
          lastRow.find(".flname").text(x[i]['fname']+' '+x[i]['lname']);
          lastRow.find(".cid").text(x[i]['cid']);
          lastRow.find(".addr_home").text(x[i]['addr_home']);
          lastRow.find(".addr_work").text(x[i]['addr_work']);

          lastRow.find("input.radio_1").attr('name','radio_'+x[i]['covid_register_id']);
          lastRow.find("input.radio_1").attr('id','neg72_'+x[i]['covid_register_id']);
          lastRow.find("label.radio_1").attr('for','neg72_'+x[i]['covid_register_id']);

          lastRow.find("input.radio_2").attr('name','radio_'+x[i]['covid_register_id']);
          lastRow.find("input.radio_2").attr('id','exam_'+x[i]['covid_register_id']);
          lastRow.find("label.radio_2").attr('for','exam_'+x[i]['covid_register_id']);

          lastRow.find("input.radio_3").attr('name','radio_'+x[i]['covid_register_id']);
          lastRow.find("input.radio_3").attr('id','notexam_'+x[i]['covid_register_id']);
          lastRow.find("label.radio_3").attr('for','notexam_'+x[i]['covid_register_id']);

          lastRow.find(".passB1_button").attr('covid_register_id',x[i]['covid_register_id']);
          lastRow.find(".passB1_button").bind( "click", function() {
            passB1($(this));
          });

          lastRow.find(".unpassB1_button").attr('covid_register_id',x[i]['covid_register_id']);
          lastRow.find(".unpassB1_button").css('visibility','hidden');
          lastRow.find(".unpassB1_button").bind( "click", function() {
            unpassB1($(this));
          });

          lastRow.appendTo($("#tdata"));
        }
        datetime_query=x[x.length-1]['datetime_query'];
      }
    })
    setTimeout(() => {
      findNewPassenger();
    }, 5000);
  }
}

function passB1(this_button) {
  // let this_tr=$(this).parent().parent();
  let covid_register_id=this_button.attr('covid_register_id');
  let airport_screen_result_id =$('input[name="radio_'+covid_register_id+'"]:checked').val();
  if (typeof airport_screen_result_id=='undefined') {
    $("#modal02").modal('show');
  }
  else {
    $("#modal01").modal('show');
    let action = 'pass';
    let data={ covid_register_id : covid_register_id, airport_screen_result_id : airport_screen_result_id ,action : action };
    // console.log(data);
    $.ajax({method: "POST", url: "airport_ajax_passenger_passB1.php",
      data: data
    })
    .done(function(msg) {
      this_button.parent().find('.unpassB1_button').css('visibility','visible');
    //   // บางจังหวะ SAVE กับ ดึงข้อมูลชนกัน แล้ว modal ไม่ hide สั่ง reload เลยดีกว่า
      location.reload();
    });
  }
}

function unpassB1(this_button) {
  // let this_tr=$(this).parent().parent();
  $("#modal01").modal('show');
  let action = 'unpass';
  let covid_register_id=this_button.attr('covid_register_id');
  $('input[name="radio_'+covid_register_id+'"]:checked').prop('checked',false);
  let data={ covid_register_id : covid_register_id ,action : action };
  // console.log(data);
  $.ajax({method: "POST", url: "airport_ajax_passenger_passB1.php",
    data: data
  })
  .done(function(msg) {
    this_button.parent().find('.unpassB1_button').css('visibility','hidden');
  //   // บางจังหวะ SAVE กับ ดึงข้อมูลชนกัน แล้ว modal ไม่ hide สั่ง reload เลยดีกว่า
    location.reload();
  });
}

$(".passB1_button").click(function() {
  passB1($(this));
});

$(".unpassB1_button").click(function() {
  unpassB1($(this));
});

$("#flight").change(function() {
  $("#modal01").modal('show');
  let include_passed = $("#include_passed").prop('checked');
  let office_id = $("#flight").val();
  window.location="airport_pointB1.php?office_id="+office_id+"&include_passed="+include_passed.toString();
});

$("#include_passed").change(function() {
  $("#modal01").modal('show');
  let include_passed = $("#include_passed").prop('checked');
  let office_id = $("#flight").val();
  window.location="airport_pointB1.php?office_id="+office_id+"&include_passed="+include_passed.toString();
});

});
</script>
