<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include('../include/config.php');

$checkpoint_token=isset($_GET['checkpoint_id'])?$_GET['checkpoint_id']:null;

$sql="select * from checkpoint_qrcode where token=:checkpoint_token limit 1 ";
$obj=$connect->prepare($sql);
$obj->execute([ 'checkpoint_token' => $checkpoint_token ]);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
$rows_count=$obj->rowCount();
if ($rows_count>0) {
  $checkpoint_office_id=$rows[0]['office_id'];
}
else {
  $checkpoint_office_id='';
}

// echo "<br>".$sql;
// echo "<br>checkpoint_token-".$checkpoint_token;
// echo "<br>checkpoint_office_id-".$checkpoint_office_id;

$LL=array();

$LL_TH=array();
$LL_TH['web_title']='รายงานตัวเข้าสกลนคร';
$LL_TH['required']=' *จำเป็น ';
$LL_TH['language_desc']='LANGUAGE';
$LL_TH['language_th']='TH';
$LL_TH['language_en']='EN';
$LL_TH['th_bg']='#FFFFFF';
$LL_TH['th_cl']='#000000';
$LL_TH['en_bg']='#999999';
$LL_TH['en_cl']='#cbcbcb';
$LL_TH['select_choose']='เลือก';
$LL_TH['alert_saving']='กำลังบันทึก .. กรุณารอซักครู่นะคะ';
$LL_TH['alert_data_required']='กรุณากรอกข้อมูลที่<font color="red"> *จำเป็น </font>ให้ครบด้วยค่ะ';

$LL_TH['fname']='ชื่อ';
$LL_TH['lname']='นามสกุล';
$LL_TH['cid']='เลขบัตรประจำตัวประชาชน';
$LL_TH['age']='ช่วงอายุ';
$LL_TH['age_field_name']='age_range_name';
$LL_TH['tel']='เบอร์โทรศัพท์';
$LL_TH['occupation']='อาชีพ';
$LL_TH['occupation_field_name']='occupation_name';
$LL_TH['addr_out_desc']='ที่พักอาศัยก่อนเดินทางเข้าสกลนคร';
$LL_TH['addr_out_province']='จังหวัด';
$LL_TH['addr_out_province_field_name']='changwat_name';
$LL_TH['addr_out_district']='อำเภอ/เขต';
$LL_TH['addr_out_district_field_name']='ampur_name';
$LL_TH['addr_out_subdistrict']='ตำบล/แขวง';
$LL_TH['addr_out_subdistrict_field_name']='tambon_name';
$LL_TH['addr_work_desc_a']='ที่ทำงาน';
$LL_TH['addr_work_desc_b']='เป็นที่อยู่เดียวกันกับที่พักอาศัย';
$LL_TH['addr_work_province']='จังหวัด';
$LL_TH['addr_work_province_field_name']='changwat_name';
$LL_TH['addr_work_district']='อำเภอ/เขต';
$LL_TH['addr_work_district_field_name']='ampur_name';
$LL_TH['addr_work_subdistrict']='ตำบล/แขวง';
$LL_TH['date_to_skn']='วันที่เดินทางเข้าถึงสกลนคร';
$LL_TH['date_out_skn']='วันที่จะเดินทางออกจากสกลนคร';
$LL_TH['travel_desc']='เดินทางไปเช้า-เย็นกลับ หรือสกลนครเป็นทางผ่าน';
$LL_TH['travel_place']='สถานที่ที่จะไป';
$LL_TH['addr_in_desc']='ที่อยู่ในจังหวัดสกลนครที่จะเข้าพำนัก';
$LL_TH['addr_in_district']='อำเภอ';
$LL_TH['addr_in_district_field_name']='ampur_name';
$LL_TH['addr_in_subdistrict']='ตำบล';
$LL_TH['addr_in_subdistrict_field_name']='ampur_name';
$LL_TH['addr_in_moo']='หมู่';
$LL_TH['addr_in_moo_field_name']='villname';
$LL_TH['addr_in_road_soi']='ถนน/ซอย';
$LL_TH['addr_in_house']='เลขที่/ชื่อสถานที่';
$LL_TH['addr_in_note']='หมายเหตุ';
$LL_TH['button_save']='บันทึก';

$LL_EN=array();
$LL_EN['web_title']='From for passenger to notify of arrival in Sakon Nakhon';
$LL_EN['required']=' *Please fill in ';
$LL_EN['language_desc']='ภาษา';
$LL_EN['language_th']='ไทย';
$LL_EN['language_en']='อังกฤษ';
$LL_EN['th_bg']='#999999';
$LL_EN['th_cl']='#cbcbcb';
$LL_EN['en_bg']='#FFFFFF';
$LL_EN['en_cl']='#000000';
$LL_EN['select_choose']='Choose';
$LL_EN['alert_saving']='Saving data, please wait.';
$LL_EN['alert_data_required']='<font color="red"> Please fill in </font>data completely.';

$LL_EN['fname']='Name';
$LL_EN['lname']='Last Name';
$LL_EN['cid']='Identification card/Passport Number ';
$LL_EN['age']='Age';
$LL_EN['age_field_name']='age_range_name_en';
$LL_EN['tel']='Telephone number';
$LL_EN['occupation']='Occupation';
$LL_EN['occupation_field_name']='occupation_name_en';
$LL_EN['addr_out_desc']='Address before come to Sakon Nakhon Province';
$LL_EN['addr_out_province']='Province';
$LL_EN['addr_out_province_field_name']='changwat_name_en';
$LL_EN['addr_out_district']='District/Area';
$LL_EN['addr_out_district_field_name']='ampur_name_en';
$LL_EN['addr_out_subdistrict']='Sub-district/Sub-area';
$LL_EN['addr_out_subdistrict_field_name']='tambon_name_en';
$LL_EN['addr_work_desc_a']='Work Place';
$LL_EN['addr_work_desc_b']='The workplace is same address as the residence.';
$LL_EN['addr_work_province']='Province';
$LL_EN['addr_work_province_field_name']='changwat_name_en';
$LL_EN['addr_work_district']='District/Area';
$LL_EN['addr_work_district_field_name']='ampur_name_en';
$LL_EN['addr_work_subdistrict']='Sub-district/Sub-area';
$LL_EN['date_to_skn']='Date of arrival in Sakon Nakhon Province';
$LL_EN['date_out_skn']='Date of arrival in Sakon Nakhon Province';
$LL_EN['travel_desc']='Travel pass Sakon Nakhon Province';
$LL_EN['travel_place']='Destination';
$LL_EN['addr_in_desc']='Residencein Sakon Nakhon Province';
$LL_EN['addr_in_district']='District/Area';
$LL_EN['addr_in_district_field_name']='ampur_name_en';
$LL_EN['addr_in_subdistrict']='Sub-district/Sub-area';
$LL_EN['addr_in_subdistrict_field_name']='ampur_name_en';
$LL_EN['addr_in_moo']='Village Name/No.';
$LL_EN['addr_in_moo_field_name']='villname_en';
$LL_EN['addr_in_road_soi']='Road';
$LL_EN['addr_in_house']='House No./Name Place';
$LL_EN['addr_in_note']='Notation';
$LL_EN['button_save']='Save';

$current_language='th';
if ($_GET['language']=='en' | $_GET['language']=='EN') {
  $LL=$LL_EN;
  $current_language='en';
}
else {
  $LL=$LL_TH;
  $current_language='th';
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
  <title><?php echo $LL['web_title']; ?></title>

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

<script>
var input_required_init=['fname','lname','cid','tel','occupation_id','changwat_out_code','ampur_out_code','ampur_in_code','tambon_in_code','moo_in_code','date_to_sakonnakhon'];

var input_required_not_rest=['fname','lname','cid','tel','occupation_id','changwat_out_code','ampur_out_code','date_to_sakonnakhon','travel_place'];

var input_required=input_required_init;

function makeRequired() {
  $(".required").text("");
  input_required.forEach(element => {
    $("#"+element).parent().find(".required").text(" <?php echo $LL['required'];?> ").css({'visibility':'visible'});
  });
}

$(document).ready(function () {
  if ('<?php echo $checkpoint_office_id; ?>'!='') {
    $("#date_to_sakonnakhon").datepickerSkn('<?php echo date('Y-m-d'); ?>','<?php echo date('Y-m-d'); ?>','lock','<?php echo $current_language; ?>');
  }
  else {
    $("#date_to_sakonnakhon").datepickerSkn('<?php echo date('Y-m-d'); ?>',null,null,'<?php echo $current_language; ?>');
  }
  $("#date_out_sakonnakhon").datepickerSkn('<?php echo date('Y-m-d'); ?>',null,null,'<?php echo $current_language; ?>');

  $(".required").css({
    'color':'red',
    'visibility':'hidden'
  });

  makeRequired();
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
    <h4 style="text-align:center; color: black;"><?php echo $LL['web_title']; ?></h4>
  </div>

  <div style="display: flex; justify-content: center;width: 100%; padding: 5px;">
    <div class="div_language" style="align: center; text-align: right;background-color: #fff000; width: 185px; border-radius: 5px;padding: 1px; border: solid 1px #000000; cursor: pointer;">
      <?php echo $LL['language_desc']; ?>
      <div style="display: inline; border: solid 1px #000000; margin-right: 1px;">
        <div style="display: inline; background-color: <?php echo $LL['th_bg'] ?>; color: <?php echo $LL['th_cl'] ?>;">
          <b> &nbsp; <?php echo $LL['language_th']; ?> &nbsp; </b>
        </div>
        <div style="display: inline; background-color: <?php echo $LL['en_bg'] ?>; color: <?php echo $LL['en_cl'] ?>;">
          <b> &nbsp; <?php echo $LL['language_en']; ?> &nbsp; </b>
        </div>
      </div>
    </div>
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

<form id="F1" action="register_submit.php" method="POST">

<div style="width: 100%; padding: 5px; display: flex; flex-flow: row wrap;">

  <div class="col-lg-4 col-md-6 col-sm-12">

    <div class="form-group">
      <label for="exampleFormControlInput1"><?php echo $LL['fname']; ?> <span class="required"></span></label>
      <input type="text" class="form-control" id="fname" name="fname" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><?php echo $LL['lname'] ?> <span class="required"></span></label>
      <input type="text" class="form-control" id="lname" name="lname" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><?php echo $LL['cid'] ?> <span class="required"></span></label>
      <input type="text" class="form-control" id="cid" name="cid" placeholder="">
    </div>
  
    <div class="form-group">
      <label for="exampleFormControlInput1"><?php echo $LL['age'] ?> <span class="required"></span></label>
      <select class="form-control" id="age_range_id" name="age_range_id">
        <option value="">--<?php echo $LL['select_choose']; ?>--</option>
<?php
$sql="select * from `age_range` ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["age_range_id"]."'>".$rows[$i][$LL['age_field_name']]."</option>";
}
?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><?php echo $LL['tel']; ?> <span class="required"></span></label>
      <input type="text" class="form-control" id="tel" name="tel" placeholder="">
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1"><?php echo $LL['occupation']; ?> <span class="required"></span></label>
      <select class="form-control" id="occupation_id" name="occupation_id">
        <option value="">--<?php echo $LL['select_choose']; ?>--</option>
<?php
$sql="select * from `coccupation` ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["occupation_id"]."'>".$rows[$i][$LL['occupation_field_name']]."</option>";
}
?>
      </select>
    </div>

  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card" style="margin-bottom: 20px;">
      <div class="card-header"><?php echo $LL['addr_out_desc']; ?></div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1"><?php echo $LL['addr_out_province']; ?> <span class="required"></span></label>
          <select class="form-control" id="changwat_out_code" name="changwat_out_code">
            <option value="">--<?php echo $LL['select_choose']; ?>--</option>
  <?php
  $sql="select * from `changwat` order by ".$LL['addr_out_province_field_name']." asc ";
  $obj=$connect->prepare($sql);
  $obj->execute();
  $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
  for ($i=0;$i<count($rows);$i++) {
    echo "<option value='".$rows[$i]["changwat_code"]."'>".$rows[$i][$LL['addr_out_province_field_name']]."</option>";
  }
  ?>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1"><?php echo $LL['addr_out_district']; ?> <span class="required"></span></label>
          <select class="form-control" id="ampur_out_code" name="ampur_out_code">
            <option value="">--<?php echo $LL['select_choose']; ?>--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1"><?php echo $LL['addr_out_subdistrict']; ?> <span class="required"></span></label>
          <select class="form-control" id="tambon_out_code" name="tambon_out_code">
            <option value="">--<?php echo $LL['select_choose']; ?>--</option>
          </select>
        </div>
        
      </div>
    </div>

    <div class="card"  style="margin-bottom: 20px;">
      <div class="card-header">
        <?php echo $LL['addr_work_desc_a']; ?>
        <div class="form-check">
          <input type="checkbox" class="form-check-input risk_area_input" id="address_work">
          <label class="form-check-label" for="address_work">
            <?php echo $LL['addr_work_desc_b']; ?>
          </label>
        </div>
      </div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1"><?php echo $LL['addr_work_province']; ?> <span class="required"></span></label>
          <select class="form-control" id="changwat_work_code" name="changwat_work_code">
            <option value="">--<?php echo $LL['select_choose']; ?>--</option>
  <?php
  $sql="select * from `changwat` order by ".$LL['addr_work_province_field_name']." asc ";
  $obj=$connect->prepare($sql);
  $obj->execute();
  $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
  for ($i=0;$i<count($rows);$i++) {
    echo "<option value='".$rows[$i]["changwat_code"]."'>".$rows[$i][$LL['addr_work_province_field_name']]."</option>";
  }
  ?>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1"><?php echo $LL['addr_work_district']; ?> <span class="required"></span></label>
          <select class="form-control" id="ampur_work_code" name="ampur_work_code">
            <option value="">--<?php echo $LL['select_choose']; ?>--</option>
          </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlSelect1"><?php echo $LL['addr_work_subdistrict']; ?> <span class="required"></span></label>
          <select class="form-control" id="tambon_work_code" name="tambon_work_code">
            <option value="">--<?php echo $LL['select_choose']; ?>--</option>
          </select>
        </div>
        
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
      <label for="exampleFormControlInput1"><?php echo $LL['date_to_skn']; ?> <span class="required"></span></label>
      <input name="date_to_sakonnakhon" class="form-control datepicker_skn" id="date_to_sakonnakhon" date_value="" />
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><?php echo $LL['date_out_skn']; ?> <span class="required"></span></label>
      <input name="date_out_sakonnakhon" class="form-control datepicker_skn" id="date_out_sakonnakhon" date_value="" />
    </div>

    <div class="card"  style="margin-bottom: 20px;">
      <div class="card-header">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="travel_not_rest" name="travel_not_rest" value="Y">
          <label class="form-check-label" for="travel_not_rest">
            <?php echo $LL['travel_desc']; ?>
          </label>
        </div>
      </div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">
        <div class="form-group">
          <label for="exampleFormControlInput1"><?php echo $LL['travel_place']; ?> <span class="required"></span></label>
          <input type="text" class="form-control" id="travel_place" name="travel_place" placeholder="">
        </div>
      </div>
    </div>


    <div class="card">
      <div class="card-header"><?php echo $LL['addr_in_desc']; ?></div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">


        <div class="form-group">
        <label for="exampleFormControlSelect1"><?php echo $LL['addr_in_district']; ?> <span class="required"></span></label>
        <select class="form-control" id="ampur_in_code" name="ampur_in_code">
          <option value="">--<?php echo $LL['select_choose']; ?>--</option>
<?php
$sql="select * from `ampur` where ampur_name not like '%*%' and ampur_name not like '%สาขา%' and ampur_name not like '%เทศบาล%' and changwat_code='47' ";
$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
for ($i=0;$i<count($rows);$i++) {
  echo "<option value='".$rows[$i]["ampur_code"]."'>".$rows[$i][$LL['addr_in_district_field_name']]."</option>";
}
?>
        </select>
        </div>

        <div class="form-group">
        <label for="exampleFormControlSelect1"><?php echo $LL['addr_in_subdistrict']; ?> <span class="required"></span></label>
        <select class="form-control" id="tambon_in_code" name="tambon_in_code">
          <option value="">--<?php echo $LL['select_choose']; ?>--</option>
        </select>
        </div>

        <div class="form-group">
        <label for="exampleFormControlSelect1"><?php echo $LL['addr_in_moo']; ?> <span class="required"></span></label>
        <select class="form-control" id="moo_in_code" name="moo_in_code">
          <option value="">--<?php echo $LL['select_choose']; ?>--</option>
        </select>
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1"><?php echo $LL['addr_in_road_soi']; ?> <span class="required"></span></label>
          <input type="text" class="form-control" id="road_soi_in" name="road_soi_in">
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1"><?php echo $LL['addr_in_house']; ?> <span class="required"></span></label>
          <input type="text" class="form-control" id="house_in_no" name="house_in_no">
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1"><?php echo $LL['addr_in_note']; ?> <span class="required"></span></label>
          <textarea class="form-control" id="note" name="note"></textarea>
        </div>

      </div>
    </div>
  </div>

  <input type="hidden" name="checkpoint_id" value='<?php echo $checkpoint_office_id; ?>'>
  <input type="hidden" name="date_to_sakonnakhon_db" id="date_to_sakonnakhon_db" value=''>
  <input type="hidden" name="date_out_sakonnakhon_db" id="date_out_sakonnakhon_db" value=''>
  <input type="hidden" name="language" id="language" value='<?php echo $current_language; ?>'>

</div>

</form>


<div style="width: 100%; padding: 20px;">
  <div class="form-group d-flex justify-content-between" style="margin-top: 20px;">
    <button type="button" class="btn btn-primary" style="width: 100%" id="btnSave"><?php echo $LL['button_save']; ?></button>
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
var registerLastInsertId;

$("#travel_not_rest").click(function() {
  let x = $(this).prop('checked');
  if (x===true) {
    input_required=input_required_not_rest;
    $("#road_soi_in").val('');
    $("#house_in_no").val('');
    $("#moo_in_code").val('');
    $("#tambon_in_code").val('');
    $("#ampur_in_code").val('');
  }
  else {
    input_required=input_required_init;
    $("#travel_place").val('');
  }
  makeRequired();
});

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
    date_to_sakonnakhon : $("#date_to_sakonnakhon").attr('date_value'),
    date_to_sakonnakhon_text : $("#date_to_sakonnakhon").val(),
    date_out_sakonnakhon : $("#date_out_sakonnakhon").attr('date_value'),
    road_soi_in : $("#road_soi_in").val(),
    house_in_no : $("#house_in_no").val(),
    moo_in_code : $("#moo_in_code").val(),
    tambon_in_code : $("#tambon_in_code").val(),
    ampur_in_code : $("#ampur_in_code").val(),
    note : $("#note").val(),
    checkpoint_id : '<?php echo $checkpoint_office_id; ?>',
    travel_not_rest : ($("#travel_not_rest").prop('checked')==true?'Y':'N'),
    // travel_not_rest : ($("#travel_not_rest").prop('checked')==true?'Y':'N'),
    travel_place : $("#travel_place").val()
    // once_confirm_case_api : $("#ampur_in_code").val(),
  }
  return data;
}

$("#btnSave").click(function() {
  var data=getInputData();
  var not_complete=0;
  input_required.forEach(element => {
    if (data[element].trim()=="" | data[element]==null | typeof data[element] =="undefined") {
      not_complete=not_complete+1;
    }
  });

  if (not_complete>0) {
    $("#modal01_body").html('<?php echo $LL['alert_data_required']; ?>');
    $("#modal01_action").css({'display':'block'});
    $("#modal01").modal('show');
  }
  else {
    $("#modal01_body").html('<?php echo $LL['alert_saving']; ?>');
    $("#modal01_action").css({'display':'none'});
    $("#modal01").modal('show');

    setTimeout(() => { 
      $("#date_to_sakonnakhon_db").val($("#date_to_sakonnakhon").attr('date_value'));
      $("#date_out_sakonnakhon_db").val($("#date_out_sakonnakhon").attr('date_value'));
      $("#F1").submit();
    }, 1000);

  }
});

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

function cleanNumber(x) {
  var r=x.trim();
  r=r.replaceAll(' ','');
  r=r.replaceAll('-','');
  r=r.replaceAll(',','');
  r=r.replaceAll('/','');
  r=r.replaceAll(':','');
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

  if (count_delete==dup_checkbox.length) {
    $("#modal02").modal('hide');
    $("#modal03").modal('show');
  }
  else {
    $("#modal02").modal('hide');
    $("#modal01_body").html('<?php echo $LL['alert_saving']; ?>');
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
        var r=jQuery.parseJSON(x).data;
        if (r.status=="success") {
          setTimeout(() => { goPageSuggestion(); }, 1000);
        }
        else {
          setTimeout(() => { goPageSuggestion(); }, 1000);
        }
      });
    }
    else {
      setTimeout(() => { goPageSuggestion(); }, 1000);
    }
  }
});

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

function goPageSuggestion() {
  window.location="suggestion_skn.php";
};

$("#changwat_out_code").change(function() {
  $("#ampur_out_code").find("option").remove();
  $("#ampur_out_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");
  $("#tambon_out_code").find("option").remove();
  $("#tambon_out_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");

  $.ajax({method: "POST", url: "ajaxQuery.php",
    data: { 
      query_table: "ampur", 
      query_where: " ampur_name not like '%*%' and ampur_name not like '%สาขา%' and ampur_name not like '%เทศบาล%' and changwat_code='"+$("#changwat_out_code").val()+"'" , 
      query_order: "if(left(<?php echo $LL['addr_out_district_field_name']; ?>,5)='เมือง',1,2) asc , <?php echo $LL['addr_out_district_field_name']; ?> asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#ampur_out_code").append("<option value='"+data[i]["ampur_code"]+"'>"+data[i]["<?php echo $LL['addr_out_district_field_name']; ?>"]+"</option>");
    }
  });
});

$("#ampur_out_code").change(function() {
  $("#tambon_out_code").find("option").remove();
  $("#tambon_out_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");

  $.ajax({method: "POST", url: "ajaxQuery.php",
    data: { 
      query_table: "tambon", 
      query_where: " tambon_name not like '%*%' and ampur_code_full='"+$("#changwat_out_code").val()+$("#ampur_out_code").val()+"'" , 
      query_order: " <?php echo $LL['addr_out_subdistrict_field_name']; ?> asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_out_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["<?php echo $LL['addr_out_subdistrict_field_name']; ?>"]+"</option>");
    }
  });
});

$("#changwat_work_code").change(function() {
  $("#ampur_work_code").find("option").remove();
  $("#ampur_work_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");
  $("#tambon_work_code").find("option").remove();
  $("#tambon_work_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");

  $.ajax({method: "POST", url: "ajaxQuery.php",
    data: { 
      query_table: "ampur", 
      query_where: " ampur_name not like '%*%' and ampur_name not like '%สาขา%' and ampur_name not like '%เทศบาล%' and changwat_code='"+$("#changwat_work_code").val()+"'" , 
      query_order: "if(left(<?php echo $LL['addr_out_district_field_name']; ?>,5)='เมือง',1,2) asc , <?php echo $LL['addr_out_district_field_name']; ?> asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#ampur_work_code").append("<option value='"+data[i]["ampur_code"]+"'>"+data[i]["<?php echo $LL['addr_out_district_field_name']; ?>"]+"</option>");
    }
  });
});

$("#ampur_work_code").change(function() {
  $("#tambon_work_code").find("option").remove();
  $("#tambon_work_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");

  $.ajax({method: "POST", url: "ajaxQuery.php",
    data: { 
      query_table: "tambon", 
      query_where: " tambon_name not like '%*%' and ampur_code_full='"+$("#changwat_work_code").val()+$("#ampur_work_code").val()+"'" , 
      query_order: "<?php echo $LL['addr_out_subdistrict_field_name']; ?> asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_work_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["<?php echo $LL['addr_out_subdistrict_field_name']; ?>"]+"</option>");
    }
  });
});

function ampurInCodeChange(ampur_code_full,default_tambon) {
  // default_tambon รหัสตำบล สองหลัก
  $("#tambon_in_code").find("option").remove();
  $("#tambon_in_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");
  $("#moo_in_code").find("option").remove();
  $("#moo_in_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");

  $.ajax({method: "POST", url: "ajaxQuery.php",
    data: { 
      query_table: "tambon", 
      query_where: " tambon_name not like '%*%' and ampur_code_full='"+ampur_code_full+"'" , 
      query_order: "<?php echo $LL['addr_out_subdistrict_field_name']; ?> asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#tambon_in_code").append("<option value='"+data[i]["tambon_code"]+"'>"+data[i]["<?php echo $LL['addr_out_subdistrict_field_name']; ?>"]+"</option>");
    }
    if (typeof default_tambon != 'undefined' & default_tambon != null) {
      $("#tambon_in_code").val(default_tambon);
    }
  });
}

$("#ampur_in_code").change(function() {
  ampurInCodeChange('47'+$("#ampur_in_code").val(),null);
});

function tambonInCodeChange(tambon_code_full,default_village) {
  // default_village รหัสหมู่ สองหลัก
  $("#moo_in_code").find("option").remove();
  $("#moo_in_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");

  $.ajax({method: "POST", url: "ajaxQuery.php",
    data: {
      query_table: "village", 
      query_where: "tambon_code_full='"+tambon_code_full+"'" , 
      query_order: "villno+0 asc"
    }
  })
  .done(function(x) {
    var data=jQuery.parseJSON(x).data;
    for (var i=0;i<data.length;i=i+1) {
      $("#moo_in_code").append("<option value='"+data[i]["villno"]+"'>"+data[i]["<?php echo $LL['addr_in_moo_field_name'];?>"]+"</option>");
    }
    $("#moo_in_code").append("<option value='XX'>ไม่ทราบ(กรุณากรอกข้อมูลถนน/ซอย)</option>");
    if (typeof default_village != 'undefined' & default_village != null) {
      $("#moo_in_code").val(default_village);
    }
  });
}

$("#tambon_in_code").change(function() {
  tambonInCodeChange('47'+$("#ampur_in_code").val()+$("#tambon_in_code").val(),null);
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
    $("#ampur_work_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");
    $("#tambon_work_code").find("option").remove();
    $("#tambon_work_code").append("<option value=''>--<?php echo $LL['select_choose']; ?>--</option>");
    $("#changwat_work_code").val('');
    $("#ampur_work_code").val('');
    $("#tambon_work_code").val('');
  }
});

$(".div_language").click(function() {
  let l='';
  if ('<?php echo $_GET['language']; ?>'=='en') {
    l='th';
  }
  else {
    l='en';
  }
  window.location='register.php?language='+l;
});

// $("#confirm_case_api").click(function() {
//   if ($(this).prop('checked')==true) {
//     $("#changwat_work_code").val(1);
//   }
//   else {

//   }
// });

</script>