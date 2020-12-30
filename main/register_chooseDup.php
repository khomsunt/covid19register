<?php 
include('../include/config.php');

$changwat_code_samut_sakhon='74';

function thaiDateShort($d) {
  $r=$d;
  if (strlen($r)==10) {
    $x=explode("-",$r);
    $r=$x[2]." ".thaiMonthShort($x[1])." ".($x[0]+543);
  }
  return $r;
}

function thaiMonthShort($x) {
  $r=$x;
  switch ($x+0) {
    case 1:$r="ม.ค."; break;
    case 2:$r="ก.พ."; break;
    case 3:$r="มี.ค."; break;
    case 4:$r="เม.ย."; break;
    case 5:$r="พ.ค."; break;
    case 6:$r="มิ.ย."; break;
    case 7:$r="ก.ค."; break;
    case 8:$r="ส.ค."; break;
    case 9:$r="ก.ย."; break;
    case 10:$r="ต.ค."; break;
    case 11:$r="พ.ย."; break;
    case 12:$r="ธ.ค."; break;
  }
  return $r;
}
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

  <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>

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

<script>
// var input_required=['fname','lname','cid','tel','changwat_out_code','ampur_out_code','ampur_in_code','tambon_in_code','moo_in_code','date_to_sakonnakhon'];
var input_required=['cid'];
$(document).ready(function () {
  $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: true,
      language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
      thaiyear: true, //Set เป็นปี พ.ศ.
      autoclose: true
  });
  // }).datepicker("setDate", "0");//กำหนดเป็นวันปัจุบัน

  $(".required").css({
    'color':'red',
    'visibility':'hidden'
  });

  input_required.forEach(element => {
    $("#"+element).parent().find(".required").text(" *จำเป็น").css({'visibility':'visible'});
  });

});

</script>

<div style="width: 100%; padding-left: 20px; padding-top: 30px;">

  <div style="display: flex; align-items: flex-start;">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
  </div>

</div>

<div style="width: 100%; padding: 20px;">
  <div style="padding-top: 10px; padding-bottom: 10px; border-radius: 5px; background-color:rgba(250, 255, 255, 0.5);">
    <h4 style="text-align:center; color: black;">รายงานตัวเข้าสกลนคร</h4>
  </div>
</div>

<!-- <div style="width: 100%; padding: 20px; padding-top: 0px; display: flex; justify-content: space-between;">
  <div style="width: 100%; border: solid 4px #4db1ff; border-radius: 10px; padding: 15px; text-align: center; background-color: white; margin-right: 0px;">
    ท่านสามารถรายงานตัวออนไลน์ล่วงหน้า ก่อนที่จะเข้าสู่พื้นที่จังหวัดสกลนคร ผ่านเว็บไซต์นี้ <br>
    หรือ รายงานตัวกับ อสม./ผู้ใหญ่บ้าน/ผู้นำชุมชน ทันทีที่เดินทางถึงพื้นที่ปลายทางค่ะ <br> 
    มาช่วยกัน เพื่อจำกัดการแพร่กระจาย เชื้อโควิด-19 กันนะคะ
  </div>
  <div style="margin-left: -20px;">
    <img src="../image/cartoon_nurse_03.png" width="70px">
  </div>
</div> -->

<div style="width: 100%; padding: 5px; display: flex; flex-flow: row wrap;">

  <div class="col-lg-4 col-md-6 col-sm-12">

    <div class="form-group">
      <label for="exampleFormControlInput1">ชื่อ <span class="required"></span></label>
      <input type="text" class="form-control" id="fname" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">นามสกุล <span class="required"></span></label>
      <input type="text" class="form-control" id="lname" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1">เลขบัตรประจำตัวประชาชน <span class="required"></span></label>
      <input type="text" class="form-control" id="cid" placeholder="">
    </div>
  
    <div class="form-group">
      <label for="exampleFormControlInput1">เบอร์โทรศัพท์ <span class="required"></span></label>
      <input type="text" class="form-control" id="tel" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1">อาชีพ <span class="required"></span></label>
      <select class="form-control" id="occupation_id">
        <option value="">--เลือก--</option>
<?php
$sql="select * from `coccupation` ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["occupation_id"]."'>".$rows[$i]["occupation_name"]."</option>";
}
?>
      </select>
    </div>

  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card" style="margin-bottom: 20px;">
      <div class="card-header">ที่พักอาศัยก่อนเดินทางเข้าสกลนคร</div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1">จังหวัด <span class="required"></span></label>
          <select class="form-control" id="changwat_out_code">
            <option value="">--เลือก--</option>
  <?php
  $sql="select * from `changwat` order by changwat_name asc ";
  $obj=$connect->prepare($sql);
  $obj->execute();
  $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
  for ($i=0;$i<count($rows);$i++) {
    echo "<option value='".$rows[$i]["changwat_code"]."'>".$rows[$i]["changwat_name"]."</option>";
  }
  ?>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">อำเภอ/เขต <span class="required"></span></label>
          <select class="form-control" id="ampur_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">ตำบล/แขวง <span class="required"></span></label>
          <select class="form-control" id="tambon_out_code">
            <option value="">--เลือก--</option>
          </select>
        </div>
        
      </div>
    </div>

    <div class="card"  style="margin-bottom: 20px;">
      <div class="card-header">
        ที่ทำงาน
        <div class="form-check">
          <input type="checkbox" class="form-check-input risk_area_input" id="address_work">
          <label class="form-check-label" for="address_work">
            เป็นที่อยู่เดียวกันกับที่พักอาศัย
          </label>
        </div>
      </div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1">จังหวัด <span class="required"></span></label>
          <select class="form-control" id="changwat_work_code">
            <option value="">--เลือก--</option>
  <?php
  $sql="select * from `changwat` order by changwat_name asc ";
  $obj=$connect->prepare($sql);
  $obj->execute();
  $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
  for ($i=0;$i<count($rows);$i++) {
    echo "<option value='".$rows[$i]["changwat_code"]."'>".$rows[$i]["changwat_name"]."</option>";
  }
  ?>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">อำเภอ/เขต <span class="required"></span></label>
          <select class="form-control" id="ampur_work_code">
            <option value="">--เลือก--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1">ตำบล/แขวง <span class="required"></span></label>
          <select class="form-control" id="tambon_work_code">
            <option value="">--เลือก--</option>
          </select>
        </div>
        
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
    <label for="exampleFormControlInput1">วันที่เดินทางเข้าถึงสกลนคร <span class="required"></span></label>
      <input name="datepicker" class="form-control datepicker" id="date_to_sakonnakhon"/>
    </div>

    <div class="card">
      <div class="card-header">ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก</div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">


        <div class="form-group">
        <label for="exampleFormControlSelect1">อำเภอ/เขต <span class="required"></span></label>
        <select class="form-control" id="ampur_in_code">
          <option value="">--เลือก--</option>
<?php
$sql="select * from `ampur` where changwat_code='47' ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["ampur_code"]."'>".$rows[$i]["ampur_name"]."</option>";
}
?>
        </select>
        </div>

        <div class="form-group">
        <label for="exampleFormControlSelect1">ตำบล/แขวง <span class="required"></span></label>
        <select class="form-control" id="tambon_in_code">
          <option value="">--เลือก--</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">หมู่ <span class="required"></span></label>
          <input type="text" class="form-control" id="moo_in_code">
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">เลขที่/ชื่อสถานที่ <span class="required"></span></label>
          <input type="text" class="form-control" id="house_in_no">
        </div>

      </div>
    </div>
  </div>

</div>

<div style="width: 100%; padding: 20px;">
  <div class="form-group d-flex justify-content-between" style="margin-top: 20px;">
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSave">บันทึก</button>
    <!-- <button type="button" class="btn btn-secondary" style="width: 48%" id="btnClose">ปิด</button> -->
  </div>
</div>

<div style="height: 200"><br></div>


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

        <!-- <div style="dupContentRow">
          <div class="dupContentFieldImportant">เลขบัตรประจำตัวประชาชน</div>
          <div class="dupContentValue v_cid"></div>
        </div>
        <div style="dupContentRow">
          <div class="dupContentFieldImportant">เบอร์โทรศัพท์</div>
          <div class="dupContentValue v_tel"></div>
        </div> -->

        <div id="modal02_dup_list">
        </div>
      </div>
      <div class="modal-footer" id="modal02_action" style="text-align: right;">
        <button type="button" class="btn btn-primary" id="btnConfirmDup">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>


<div class="dup_item_master" style="display: none; margin-top: 20px; margin-bottom: 20px; border: solid 2px black; border-radius: 5px; padding: 5px; background-color: #eeeeee;">
  <div style="dupContentRow">
    <div class="dupContentField">วันเวลาลงทะเบียน</div>
    <div class="dupContentValue v_register_datetime"></div>
  </div>
  <!-- <div style="dupContentRow">
    <div class="dupContentField">ชื่อสกุล</div>
    <div class="dupContentValue v_fname_lname"></div>
  </div> -->
  <!-- <div style="dupContentRow">
    <div class="dupContentField">เลขบัตรประจำตัวประชาชน</div>
    <div class="dupContentValue v_cid"></div>
  </div>
  <div style="dupContentRow">
    <div class="dupContentField">เบอร์โทรศัพท์</div>
    <div class="dupContentValue v_tel"></div>
  </div> -->
  <!-- <div style="dupContentRow">
    <div class="dupContentField">อาชีพ</div>
    <div class="dupContentValue v_occupation"></div>
  </div>
  <div style="dupContentRow">
    <div class="dupContentField">ที่พักอาศัยก่อนเดินทางเข้าสกลนคร</div>
    <div class="dupContentValue v_address_home"></div>
  </div>
  <div style="dupContentRow">
    <div class="dupContentField">ที่ทำงาน</div>
    <div class="dupContentValue v_address_work"></div>
  </div> -->
  <div style="dupContentRow">
    <div class="dupContentField">วันที่เดินทางเข้าถึงสกลนคร</div>
    <div class="dupContentValue v_date_to_sakonnakhon"></div>
  </div>
  <!-- <div style="dupContentRow">
    <div class="dupContentField">ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก</div>
    <div class="dupContentValue v_address_sakonnakhon"></div>
  </div> -->
  <div style="dupContentRow" style="width: 100%; padding: 10px;">
    <div style="width: 100%; display:flex; flex-direction: row-reverse;">

      <div style="width: 100px; background-color: #FFFFFF; border: solid 1px #999999; border-radius: 10px;">
        <input class="form-check-input choose_dup_checkbox" id="choose_dup" name="choose_dup" type="checkbox" value="" style="margin-left: 10px;">
        <label class="form-check-label choose_dup_label" for="choose_dup" style="margin-left: 30px;">ลบข้อมูล</label>
      </div>

      <!-- <div style="width: 150px; background-color: #FFFFFF; border: solid 1px #999999; border-radius: 10px;">
        <input class="form-check-input choose_dup_radio" type="radio" name="choose_dup" id="choose_dup" value="" style="margin-left: 10px;">
        <label class="form-check-label choose_dup_label" for="choose_dup" style="margin-left: 30px;">เลือกข้อมูลชุดนี้</label>
      </div> -->

    </div>
  </div>
</div>


</body>
</html>

<script>
var evaluate_level=0;
var dupData=[];

function getInputData () {
  var data= {
    fname : $("#fname").val(),
    lname : $("#lname").val(),
    cid : $("#cid").val(),
    tel : $("#tel").val(),
    occupation_id : $("#occupation_id").val(),
    tambon_out_code : $("#tambon_out_code").val(),
    ampur_out_code : $("#ampur_out_code").val(),
    changwat_out_code : $("#changwat_out_code").val(),
    tambon_work_code : $("#tambon_work_code").val(),
    ampur_work_code : $("#ampur_work_code").val(),
    changwat_work_code : $("#changwat_work_code").val(),
    date_to_sakonnakhon : formatDate($("#date_to_sakonnakhon").val()),
    date_to_sakonnakhon_text : $("#date_to_sakonnakhon").val(),
    house_in_no : $("#house_in_no").val(),
    moo_in_code : $("#moo_in_code").val(),
    tambon_in_code : $("#tambon_in_code").val(),
    ampur_in_code : $("#ampur_in_code").val(),
    note : '',
  }
  return data;
}

function ajaxInsert(data,goSuggestion) {
  $.ajax({method: "POST", url: "ajaxSaveRegisterSkn.php",
    data: data
  })
  .done(function(x) {
    // console.log(jQuery.parseJSON(x));
    var r=jQuery.parseJSON(x).data;
    if (r.status=="success") {
      if (goSuggestion=='Y') {
        setTimeout(() => {
          goPageSuggestion();
        }, 1000);
      }
    }
  });
}

$("#btnSave").click(function() {
  var data=getInputData();
  // console.log(data);
 
  var not_complete=0;
  input_required.forEach(element => {
    if (data[element].trim()=="" | data[element]==null | typeof data[element] =="undefined") {
      not_complete=not_complete+1;
    }
  });

  if (not_complete>0) {
    $("#modal01_body").html('กรุณากรอกข้อมูลที่<font color="red"> *จำเป็น </font>ให้ครบด้วยค่ะ');
    $("#modal01_action").css({'display':'block'});
    $("#modal01").modal('show');
  }
  else {
    $("#modal01_body").html('กำลังบันทึก .. กรุณารอซักครู่นะคะ');
    $("#modal01_action").css({'display':'none'});
    $("#modal01").modal('show');

    var data_check= { 
      cid : cleanNumber(data['cid']),
      tel : cleanNumber(data['tel']),
    };
    $.ajax({method: "POST", url: "ajaxCheckRegisterSkn.php",
      data: data_check
    })
    .done(function(x) {
      console.log(jQuery.parseJSON(x));
      var r=jQuery.parseJSON(x).data;
      if (r.status=="success") {
        if (r.register_data.length==0) {
          // ไม่มีข้อมูลซ้ำ
          ajaxInsert(data,'Y');
        }
        else {
          $("#modal02_dup_list").empty();
          dupData=[];
          var newData=data;
          newData['data_entry']='NEW';
          var s=$("select");
          for (var sI=0;sI<s.length;sI=sI+1) {
            var item=$(s[sI]);
            var key=item.attr('id');
            var opt=item.find("option:selected");
            var value=opt.val()==""?" - ":opt.text();
            newData[key]=value;
          }
          dupData=r.register_data;
          dupData.push(newData);
          console.log(dupData);
          for (var i=0;i<dupData.length;i=i+1) {
            var d=dupData[i];
            var dup_item=$(".dup_item_master").clone();
            dup_item.removeClass('dup_item_master').addClass('dup_item').css({'display':'block'});
            console.log(d.data_entry);
            if (typeof d.data_entry == 'undefined') {
              dup_item.find(".v_register_datetime").text(d.register_datetime);
            }
            else {
              dup_item.find(".v_register_datetime").text('เวลาปัจจุบัน(ลงทะเบียนครั้งนี้)');
            }
            // dup_item.find(".v_fname_lname").text(d.fname+" "+d.lname);
            dup_item.find(".v_cid").text(d.cid);
            dup_item.find(".v_tel").text(d.tel);
            // dup_item.find(".v_occupation").text(d.occupation_id);
            // dup_item.find(".v_address_home").text('ต.'+d.tambon_out_code+' อ.'+d.ampur_out_code+' จ.'+d.changwat_out_code);
            // dup_item.find(".v_address_work").text('ต.'+d.tambon_work_code+' อ.'+d.ampur_work_code+'จ.'+d.changwat_work_code);
            dup_item.find(".v_date_to_sakonnakhon").text(dupData[i].date_to_sakonnakhon);
            // dup_item.find(".v_address_sakonnakhon").text(d.house_in_no+' ม.'+d.moo_in_code+' ต.'+d.tambon_in_code+' อ.'+d.ampur_in_code+' จ.สกลนคร');
            dup_item.find(".choose_dup_checkbox").attr({'id':'choose_dup_'+i, 'name':'choose_dup_'+i});
            dup_item.find(".choose_dup_checkbox").val(i);
            dup_item.find(".choose_dup_label").attr({'for':'choose_dup_'+i});
            // dup_item.find(".choose_dup_radio").bind('change',function() {
            //   var dup_value=$('input[name="choose_dup"]:checked').val();
            //   // console.log(dup_value);
            //   if (dup_value!="" & dup_value!= null & typeof dup_value != "undefined") {
            //     $("#btnConfirmDup").prop({'disabled':false});
            //   }
            // });
            $("#modal02_dup_list").append(dup_item);
          }

          setTimeout(() => {
            $("#modal01").modal('hide');
            $("#modal02_dup_count").text(dupData.length);
            // $(".v-fname-lname").text(dupData[0].fname+" "+dupData[0].lname);
            // $(".v-cid").text(dupData[0].cid);
            // $("#modal02_dup_list").text(JSON.stringify(dupData));
            $("#modal02").modal('show');            
          }, 1000);
        }
      }
    });

  }
});

function cleanNumber(x) {
  var r=x.trim();
  r=r.replaceAll(' ','');
  r=r.replaceAll('-','');
  r=r.replaceAll(',','');
  r=r.replaceAll('/','');
  r=r.replaceAll(':','');
  return r;
}

$("#btnConfirmDup").click(function() {
  // var dup_value=$('input[name^="choose_dup_"]:checked').val();
  var dup_value=$('input[name^="choose_dup_"]:checked').val();
  // console.log(dup_value);
  // console.log(dupData[dup_value]);
  var selected_data=dupData[dup_value];
  // console.log(selected_data.data_entry);
  if (typeof selected_data.data_entry != "undefined") {
    $("#modal02").modal('hide');
    $("#modal01_body").html('กำลังบันทึก .. กรุณารอซักครู่นะคะ');
    $("#modal01_action").css({'display':'none'});
    $("#modal01").modal('show');
    // ajaxInsert(selected_data,'N');
    for (var i=0;i<dupData.length;i=i+1) {
      if (i!=dup_value) {
        console.log(dupData[i]);
      }
    }
  }
});

function formatDate(d) {
  var r="";
  if (typeof d !='indefined') {
    if (d.length>0) {
      var x=d.split("/");
      r=x[2]+"-"+x[1]+"-"+x[0];
    }
  }
  return r;
}

var goPageSuggestion = function() {
  window.location="suggestion_skn.php";
};

$("#changwat_out_code").change(function() {
  $("#ampur_out_code").find("option").remove();
  $("#ampur_out_code").append("<option value=''>--เลือก--</option>");
  $("#tambon_out_code").find("option").remove();
  $("#tambon_out_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "ampur", 
      query_where: "changwat_code='"+$("#changwat_out_code").val()+"'" , 
      query_order: "if(left(ampur_name,5)='เมือง',1,2) asc , ampur_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#ampur_out_code").append("<option value='"+data[i]["ampur_code"]+"'>"+data[i]["ampur_name"]+"</option>");
    }
  });
});

$("#ampur_out_code").change(function() {
  $("#tambon_out_code").find("option").remove();
  $("#tambon_out_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "tambon", 
      query_where: "ampur_code_full='"+$("#changwat_out_code").val()+$("#ampur_out_code").val()+"'" , 
      query_order: "tambon_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_out_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["tambon_name"]+"</option>");
    }
  });
});

$("#changwat_work_code").change(function() {
  $("#ampur_work_code").find("option").remove();
  $("#ampur_work_code").append("<option value=''>--เลือก--</option>");
  $("#tambon_work_code").find("option").remove();
  $("#tambon_work_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "ampur", 
      query_where: "changwat_code='"+$("#changwat_work_code").val()+"'" , 
      query_order: "if(left(ampur_name,5)='เมือง',1,2) asc , ampur_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#ampur_work_code").append("<option value='"+data[i]["ampur_code"]+"'>"+data[i]["ampur_name"]+"</option>");
    }
  });
});

$("#ampur_work_code").change(function() {
  $("#tambon_work_code").find("option").remove();
  $("#tambon_work_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "tambon", 
      query_where: "ampur_code_full='"+$("#changwat_work_code").val()+$("#ampur_work_code").val()+"'" , 
      query_order: "tambon_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_work_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["tambon_name"]+"</option>");
    }
  });
});

$("#ampur_in_code").change(function() {
  $("#tambon_in_code").find("option").remove();
  $("#tambon_in_code").append("<option value=''>--เลือก--</option>");

  $.ajax({method: "POST", url: "ajaxTest.php",
    data: { 
      query_table: "tambon", 
      query_where: "ampur_code_full='47"+$("#ampur_in_code").val()+"'" , 
      query_order: "tambon_name asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_in_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["tambon_name"]+"</option>");
    }
  });
});

$("#address_work").click(function() {
  if ($(this).prop('checked')==true) {
    $("#ampur_work_code").find("option").remove();
    $("#ampur_work_code").append($("#ampur_out_code").children().clone());
    $("#tambon_work_code").find("option").remove();
    $("#tambon_work_code").append($("#tambon_out_code").children().clone());

    $("#changwat_work_code").val($("#changwat_out_code").val());
    $("#ampur_work_code").val($("#ampur_out_code").val());
    $("#tambon_work_code").val($("#tambon_out_code").val());
  }
  else {
    $("#ampur_work_code").find("option").remove();
    $("#ampur_work_code").append("<option value=''>--เลือก--</option>");
    $("#tambon_work_code").find("option").remove();
    $("#tambon_work_code").append("<option value=''>--เลือก--</option>");
    $("#changwat_work_code").val('');
    $("#ampur_work_code").val('');
    $("#tambon_work_code").val('');
  }
});

</script>