<?php 
include('../include/config.php');
// echo "<br>config=";
// print_r($configs);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>area</title>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>

    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/"> -->

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
    <!-- Custom styles for this template -->
    <!-- <link href="../css/floating-labels.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>
  </head>
  <body>

<script>
var input_required=['area_name'];
$(document).ready(function () {
  $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      todayBtn: true,
      language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
      thaiyear: true, //Set เป็นปี พ.ศ.
      autoclose: true
  }).datepicker("setDate", "0");//กำหนดเป็นวันปัจุบัน

  $(".required").css({
    'color':'red',
    'visibility':'hidden'
  });

  input_required.forEach(element => {
    $("#"+element).parent().find(".required").text(" *จำเป็น").css({'visibility':'visible'});
  });
});
</script>
<?php
$sql="select r.risk_area_id, r.changwat_code, r.area_name,
r.risk_start_datetime, r.risk_last_datetime, r.status_id,
s.status_name, c.changwat_name from risk_area r
left JOIN `status` s on r.status_id = s.status_id
left JOIN changwat c on r.changwat_code = c.changwat_code
where r.changwat_code = :changwat_code;
";
$obj=$connect->prepare($sql);
$obj->execute(["changwat_code"=>$_POST['changwat_code']]);
$rows_area=$obj->fetchAll(PDO::FETCH_ASSOC);
//print_r($rows_area);
$changwat = $rows_area[0]['changwat_code'];
//echo $changwat;
?>


<div class="container" style="background-color: #b9ddff;background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: contain, cover; background-position: top center;">

  <div style="height: 100;"><br></div>
  <div style="display: flex; align-items: flex-start;">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
  </div>

  <h2 style="text-align:center; margin-top: 20px; margin-bottom: 20px;">เพิ่มสถานที่เสี่ยง</h2>

  <div class="form-group">
    <label for="changwat_name">จังหวัด</label>
        <input type="changwat_name" class="form-control" id="changwat_name" readonly="readonly" value="<?php echo $rows_area[0]['changwat_name']; ?>">
    
    <label for="area_name">ชื่อสถานที่<span class="required"></span></label>
        <input type="area_name" class="form-control" id="area_name">

    <label for="risk_start_datetime">วันที่เริ่มละบาด</label>
        <input name="risk_start_datetime" class="form-control datepicker" id="risk_start_datetime"/>

    <label for="risk_last_datetime">วันที่ระบาดล่าสุด</label>
        <input name="risk_last_datetime" class="form-control datepicker" id="risk_last_datetime"/>
    
    
    <label for="status_id">สถานะ<span class="required"></span></label>
    <select class="form-control" id="status_id">
    <option value="">--เลือก--</option>
    <?php
        $sql="select * from `status` ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0;$i<count($rows);$i++) {
          echo "<option value='".$rows[$i]["status_id"]."'>".$rows[$i]["status_name"]."</option>";
        }
      ?>
    </select>
  </div>
    <div style="height: 200"><br></div>

    <div class="form-group d-flex justify-content-between">
      <button type="button" class="btn btn-primary" changwat_code = "<?php echo $_POST['changwat_code']; ?>" style="width: 48%" id="btnSave">บันทึก</button>
      <button type="button" class="btn btn-secondary btn-GoTo" changwat_code = "<?php echo $_POST['changwat_code']; ?>" changwat_name = "<?php echo $rows_area[0]['changwat_name']; ?>" style="width: 48%" id="btnClose">ปิด</button>
    </div>

    <div style="height: 200"><br></div>
</div>
<div class="modal fade" id="modal01">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal01_body" style="margin-top:30px; margin-bottom: 30px;">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script>
  $("#btnSave").click(function() {
  var data= {
    risk_area_id : $("#risk_area_id").val(),
    changwat_code : "<?php echo $_POST['changwat_code']; ?>",
    area_name : $("#area_name").val(),
    risk_start_datetime : formatDate($("#risk_start_datetime").val()),
    risk_last_datetime : formatDate($("#risk_last_datetime").val()),
    status_id : $("#status_id").val()
  }
  console.log(data);

  var not_complete=0;
  input_required.forEach(element => {
    if (data[element]=="") {
      not_complete=not_complete+1;
    }
  });
  console.log(not_complete);
  if (not_complete>0) {
    $("#modal01_body").html('กรุณากรอกข้อมูลที่<font color="red">จำเป็น</font>ให้ครบ');
    $("#modal01").modal('show');
    //alert('11111');
  }
  else {
    //console.log('-------------');
    $.ajax({method: "POST", url: "ajaxAddArea.php",
      data: data
    })
    .done(function(x) {
    console.log(jQuery.parseJSON(x));
      var r=jQuery.parseJSON(x).data;
      if (r.status=="success") {
        $("#modal01_body").html('ลงทะเบียนเสร็จเรียบร้อยแล้ว');
        $("#modal01").modal('show');
        //$( "#btnInsideModal" ).bind( "click", btn-GoTo );
        $( "#btnInsideModal" ).bind( "click", GoGo );
      }
    });
  }
});
    $(".btn-GoTo").click(function(){
            console.log($(this).attr("changwat_code"));
            var form = $('<form action="./risk_area_detail.php" method="post"><input type="hidden" name="changwat_code" value="' + $(this).attr("changwat_code") + '"></input><input type="hidden" name="changwat_name" value="' + $(this).attr("changwat_name") + '"></input>' + '</form>');
            $('body').append(form);
            $(form).submit(); 
        })

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
var GoGo = function() {
  window.location="risk_area.php";
};

</script>