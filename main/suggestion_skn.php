<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../include/config.php');

$sql=" select * from covid_register where cid=:cid and tel=:tel ".
" and cut_status_id = 0 ". 
" and (date_arrived_sakonnakhon is null or date_arrived_sakonnakhon='') ".
" and date_to_sakonnakhon > left(now(),10) ";
$obj=$connect->prepare($sql);
$execute_status=$obj->execute([ 'cid' => $_GET['cid'],'tel' => $_GET['tel'] ]);
// $execute_status=$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
$register_count=count($rows);
// echo "<br><br><br>---- ".$register_count;

?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>รายงานตัวเข้าสกลนคร</title>

  <script src="../js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <script type="text/javascript" src="../js/datepickerSkn.js"></script>

  <style>
  .modal {
    overflow-y:auto;
  }
  .dupContentField {
    display: inline; background-color: #b0e8ff; padding-left: 7px; padding-right: 7px; border-radius: 10px;
  }
  .dupContentFieldImportant{
    display: inline; background-color: #0071ea; padding-left: 7px; padding-right: 7px; border-radius: 10px; color: #FFFFFF;
  }
  .dupContentValue {
    display: inline;
  }
  .dupContentRow {
    padding: 7px;
  }
  </style>
</head>

<body style="background-color: #b9ddff;  background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: 500px; background-position: top right;">

<div>

  <div style="width: 100%; padding-left: 20px; padding-top: 30px;">

    <div style="display: flex; align-items: flex-start;">
      <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
      <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
    </div>

  </div>
  <div style="width: 100%;">

    <div style="width:100%; margin-top: 70px; align: center; display: flex; justify-content: center;">
      <div style="width: 10%;"><br></div>
      <div style="width: 80%;">
        <div style="position: absolute; z-index: 10; margin-left: -20px; margin-top: -20px;">
          <img src="../image/cartoon_nurse_04.png" width="120px">
        </div>
        <div id="announce_text" style="width: 80%; position: absolute; z-index: 1; border: solid 10px #4db1ff; border-radius: 30px; padding: 20px; text-align: center; background-color: white; padding-top: 80px; padding-bottom: 80px;">
          <h5>
            <!-- ขอบคุณมากค่ะ<br>
            ท่านได้รายงานตัว<br>
            เข้าสู่จังหวัดสกลนคร<br>
            เรียบร้อยแล้ว<br>
            <br>
            ขอให้เดินทางโดยสวัสดิภาพ<br>
            และขอให้สวมแมสตลอดเวลา<br>
            <br>
            หากท่านเป็นกลุ่มเสี่ยง<br>
            จะมีเจ้าหน้าที่สาธารณสุข<br>
            โทรศัพท์ติดต่อท่าน<br>
            ภายหลังค่ะ<br> -->

            ขอขอบคุณที่รายงานตัว<br>
            ขอให้ท่านกักตัวที่บ้าน<br>
            เป็นเวลา 14 วัน<br>
            <br>
            ยกเว้นท่านมีผลตรวจ<br>
            หาเชื้อโควิด-19<br>
            โดยวิธีป้ายคอและจมูก(swab)<br>
            หรือมีผลการตรวจด้วย<br>
            ชุดทดสอบเบื้องต้น<br>
            (Rapid test antigen)<br>
            ผลตรวจไม่พบเชื้อโควิด-19<br>
            ไม่ต้องกักตัว<br>
            แต่ผลตรวจจะสามารถรับรองผล<br>
            72 ชม.หรือ 3 วัน เท่านั้น<br>
          </h5>
        </div>
      </div>
      <div style="width: 10%;"><br></div>
    </div>

  </div>

</div>


<div class="modal fade" id="modal01" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal01_body" style="margin-top:30px; margin-bottom: 30px;">
        ...
      </div>
      <div class="modal-footer" id="modal01_action" style="text-align: right;">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modal02" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ตรวจพบการลงทะเบียนหลายครั้ง</h5>
      </div>
      <div class="modal-body" id="modal02_body">
        ท่านทำการลงทะเบียน <span id="modal02_dup_count"></span> ครั้ง กรุณาตรวจสอบข้อมูลต่อไปนี้ หากมีข้อมูลที่ซ้ำกัน โปรดลบข้อมูลที่ซ้ำซ้อนออก แล้วกดปุ่มยืนยันค่ะ <br>
        <u>หมายเหตุ</u> หากท่านมีการเดินทางเข้าสู่จังหวัดสกลนครหลายครั้ง ก็ควรลงทะเบียนตามจำนวนการเดินทางค่ะ

        <div id="modal02_dup_list">
        </div>
      </div>
      <div class="modal-footer" id="modal02_action" style="text-align: right;">
        <button type="button" class="btn btn-primary" id="btnConfirmDup">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal03" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal03_body" style="margin-top:30px; margin-bottom: 30px;">
        ขออภัยค่ะ ท่านไม่สามารถลบข้อมูลทั้งหมดได้ กรุณาคงเหลือข้อมูลไว้อย่างน้อย 1 ชุดค่ะ
      </div>
      <div class="modal-footer" id="modal03_action" style="text-align: right;">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>

<div class="dup_item_master" style="display: none; margin-top: 20px; margin-bottom: 20px; border: solid 2px black; border-radius: 5px; padding: 5px; background-color: #eeeeee;">
<div class="v_last_id_data" style="padding-left: 5px; color: red"></div>
  <div style="dupContentRow">
    <div class="dupContentField">วันเวลาลงทะเบียน</div>
    <div class="dupContentValue v_register_datetime"></div>
  </div>
  <div style="dupContentRow">
    <div class="dupContentField">วันที่เดินทางเข้าถึงสกลนคร</div>
    <div class="dupContentValue v_date_to_sakonnakhon"></div>
  </div>
  <div style="dupContentRow" style="width: 100%; padding: 10px;">
    <div style="width: 100%; display:flex; flex-direction: row-reverse;">

      <div style="width: 100px; background-color: #FFFFFF; border: solid 1px #999999; border-radius: 10px;">
        <input class="form-check-input choose_dup_checkbox" id="choose_dup" name="choose_dup" type="checkbox" value="" style="margin-left: 10px;">
        <label class="form-check-label choose_dup_label" for="choose_dup" style="margin-left: 20px;"> &nbsp; ลบข้อมูล</label>
      </div>

    </div>
  </div>
</div>

</body>
</html>
<script>
checkDupReg();

function clearDuplicatedData(dupData) {
  $("#modal02_dup_list").empty();
  for (var i=0;i<dupData.length;i=i+1) {
    var d=dupData[i];
    var dup_item=$(".dup_item_master").clone();
    dup_item.removeClass('dup_item_master').addClass('dup_item').css({'display':'block'});
    if (parseInt(registerLastInsertId)==parseInt(d.covid_register_id)) {
      dup_item.find(".v_last_id_data").text("ข้อมูลล่าสุด");
    }
    dup_item.find(".v_register_datetime").text(thaiDateTimeShort(dupData[i].register_datetime));
    dup_item.find(".v_date_to_sakonnakhon").text(thaiDateShort(dupData[i].date_to_sakonnakhon));
    dup_item.find(".choose_dup_checkbox").attr({'id':'choose_dup_'+i, 'name':'choose_dup_'+i, 'covid_register_id':d.covid_register_id});
    dup_item.find(".choose_dup_checkbox").val(i);
    dup_item.find(".choose_dup_label").attr({'for':'choose_dup_'+i});
    $("#modal02_dup_list").append(dup_item);
  }

  setTimeout(() => {
    $("#modal01").modal('hide');
    $("#modal02_dup_count").text(dupData.length);
    $("#modal02").modal('show');            
  }, 1000);

}

function checkDupReg() {
  registerLastInsertId='<?php echo $_GET["registerLastInsertId"]?>';
  var data_check= { 
    cid : cleanNumber('<?php echo $_GET["cid"]?>'),
    tel : cleanNumber('<?php echo $_GET["tel"]?>'),
  };
  $.ajax({method: "POST", url: "ajaxCheckRegisterSkn.php",
    data: data_check
  })
  .done(function(x) {
    // console.log(jQuery.parseJSON(x));
    var r=jQuery.parseJSON(x).data;
    if (r.status=="success") {
      if (r.register_data.length>1) {
        clearDuplicatedData(r.register_data);  
      }
    }
  });
}

function cleanNumber(x) {
  var r=x.trim();
  r=r.replaceAll(' ','');
  r=r.replaceAll('-','');
  r=r.replaceAll(',','');
  r=r.replaceAll('/','');
  r=r.replaceAll(':','');
  return r;
}

function thaiDateShort(d) {
  var r=d;
  if (r.length==10) {
    x=r.split('-');
    r=parseInt(x[2])+""+thaiMonthShort(x[1])+""+(parseInt(x[0])+543);
  }
  return r;
}

function thaiDateTimeShort(d) {
  var r=d;
  if (d.length==19) {
    var s=d.split(' ');
    var x=s[0].split('-');
    r=parseInt(x[2])+""+thaiMonthShort(x[1])+""+(parseInt(x[0])+543)+"  "+s[1].substr(0,5).replace(':','.')+"น.";
  }
  return r;
}

function thaiMonthShort(x) {
  r=x;
  switch (parseInt(x)) {
    case 1:r="ม.ค."; break;
    case 2:r="ก.พ."; break;
    case 3:r="มี.ค."; break;
    case 4:r="เม.ย."; break;
    case 5:r="พ.ค."; break;
    case 6:r="มิ.ย."; break;
    case 7:r="ก.ค."; break;
    case 8:r="ส.ค."; break;
    case 9:r="ก.ย."; break;
    case 10:r="ต.ค."; break;
    case 11:r="พ.ย."; break;
    case 12:r="ธ.ค."; break;
  }
  return r;
}

function formatDate(d) {
  var r="";
  if (typeof d !='undefined') {
    if (d.length>0) {
      var x=d.split("/");
      r=x[2]+"-"+x[1]+"-"+x[0];
    }
  }
  return r;
}

$('#modal03').on('hidden.bs.modal', function () {
  $("#modal02").modal('show');
});

$("#btnConfirmDup").click(function() {
  var dup_checkbox=$('input[name^="choose_dup_"]');
  var covid_register_id_list=[];
  var count_delete=0;
  for (var i=0;i<dup_checkbox.length;i=i+1) {
    if ($(dup_checkbox[i]).prop('checked')==true) {
      covid_register_id_list.push($(dup_checkbox[i]).attr('covid_register_id'));
      count_delete=count_delete+1;
    }
  }

  // ไม่ลบเลยซักอัน
  if (count_delete==0) {
    // --- ไม่ต้องทำอะไร
    $("#modal02").modal('hide');
  }
  else if (count_delete==dup_checkbox.length) {
    $("#modal02").modal('hide');
    $("#modal03").modal('show');
  }
  else {
    $("#modal02").modal('hide');
    $("#modal01_body").html('กำลังบันทึก .. กรุณารอซักครู่นะคะ #2');
    $("#modal01_action").css({'display':'none'});
    $("#modal01").modal('show');

    if (covid_register_id_list.length>0) {
      var covid_register_id_list_string=covid_register_id_list.join(',');
      $.ajax({method: "POST", url: "ajaxRegisterMarkAsDelete.php",
        data: { 
          covid_register_id_list_string: covid_register_id_list_string,
        }
      })
      .done(function(x) {
        setTimeout(function() {
          $("#modal01").modal('hide');
        }, 1000);
        var r=jQuery.parseJSON(x).data;
        if (r.status=="success") {
          // console.log('success');
        }
        else {
          // console.log('not success'); 
        }
      });
    }
  }
});

</script>