<?php 
include('../include/config.php');
// echo "<br>config=";
// print_r($configs);
?>

<?php
// $_GET["user_id"]
    $sql="select * from `user` WHERE user_id=".$_GET['user_id'];
    $obj=$connect->prepare($sql);
    $obj->execute();
    $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    // print_r($rows);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>User</title>

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
var input_required=['fname','lname','cid'];
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


<div class="container" style="background-color: #b9ddff;background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: contain, cover; background-position: top center;">

  <div style="height: 100;"><br></div>
  <div style="display: flex; align-items: flex-start;">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
  </div>

  <h2 style="text-align:center; margin-top: 20px; margin-bottom: 20px;">แก้ไขข้อมูล</h2>

  <div class="form-group">
  <label for="user_login">Username <span class="required"></span></label>
    <input type="user_login" class="form-control" id="user_login" value="<?php echo $rows[0]['user_login']; ?>">
    <label for="user_password">Password <span class="required"></span></label>
    <input type="Password" class="form-control" id="user_password" value="<?php echo $rows[0]['user_password']; ?>">

    <label for="prename_id">คำนำหน้าชื่อ <span class="required"></span></label>
    <select class="form-control" id="prename_id" >
    <option value="">--เลือก--</option>
      <?php
        $sql="select * from `prename` ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rowsPrename=$obj->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0;$i<count($rowsPrename);$i++) {
            if($rows[0]['prename_id'] == $rowsPrename[$i]["prename_id"]) {
                echo "<option selected value='".$rowsPrename[$i]["prename_id"]."'>".$rowsPrename[$i]["prename_name"]."</option>";
            } else {
                echo "<option value='".$rowsPrename[$i]["prename_id"]."'>".$rowsPrename[$i]["prename_name"]."</option>";
            }
        }
      ?>
    </select>
    
    <label for="fname">ชื่อ <span class="required"></span></label>
    <input type="fname" class="form-control" id="fname" value="<?php echo $rows[0]['fname']; ?>">
    
    <label for="lname">สกุล <span class="required"></span></label>
    <input type="lname" class="form-control" id="lname" value="<?php echo $rows[0]['lname']; ?>">
    
    <label for="phone">เบอร์โทร <span class="required"></span></label>
    <input type="phone" class="form-control" id="phone" value="<?php echo $rows[0]['phone']; ?>">

    <label for="office_id">หน่วยงาน <span class="required"></span></label>
    <select class="form-control" id="office_id">
    <option value="">--เลือก--</option>
    <?php
        $sql="select * from `office` ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rowsOffice=$obj->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0;$i<count($rowsOffice);$i++) {
            if($rows[0]['office_id'] == $rowsOffice[$i]["office_id"]) {
                
          echo "<option selected value='".$rowsOffice[$i]["office_id"]."'>".$rowsOffice[$i]["office_name"]."</option>";
            } else {
                echo "<option value='".$rowsOffice[$i]["office_id"]."'>".$rowsOffice[$i]["office_name"]."</option>";
            }
        }
      ?>
    </select>

    <label for="line_token">Line_Token <span class="required"></span></label>
    <input type="line_token" class="form-control" id="line_token" value="<?php echo $rows[0]['line_token']; ?>">

    <label for="group_id">สิทธิ์การใช้งาน</label>
    <select class="form-control" id="group_id">
    <option value="">--เลือก--</option>
    <?php
        $sql="select * from `group` ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rowsGroup=$obj->fetchAll(PDO::FETCH_ASSOC);
        for ($i=0;$i<count($rowsGroup);$i++) {
            if($rows[0]['office_id'] == $rowsGroup[$i]["group_id"]) {
                echo "<option selected value='".$rowsGroup[$i]["group_id"]."'>".$rowsGroup[$i]["group_name"]."</option>";
            } else {
                echo "<option value='".$rowsGroup[$i]["group_id"]."'>".$rowsGroup[$i]["group_name"]."</option>";
            }
        }
      ?>
    </select>


    <label for="status_id">สถานะ</label>
    <select class="form-control" id="status_id">
    <option value="">--เลือก--</option>
    <?php
        $sql="select * from `status` ";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rowsStatus=$obj->fetchAll(PDO::FETCH_ASSOC);
        // for ($i=0;$i<count($rowsStatus);$i++) {
        //   echo "<option value='".$rowsStatus[$i]["status_id"]."'>".$rowsStatus[$i]["status_name"]."</option>";
        // }
        for ($i=0;$i<count($rowsStatus);$i++) {
            if($rows[0]['status_id'] == $rowsStatus[$i]["status_id"]) {
                echo "<option selected value='".$rowsStatus[$i]["group_id"]."'>".$rowsStatus[$i]["status_name"]."</option>";
            } else {
                echo "<option value='".$rowsStatus[$i]["status_id"]."'>".$rowsStatus[$i]["status_name"]."</option>";
            }
        }
      ?>
    </select>
    <label for="date_register">วันที่ลงทะเบียน</label>
    <!-- <input type="date_register" class="form-control" id="date_register"> -->
    <input name="datepicker" class="form-control datepicker" id="date_to_sakonnakhon"/>
    
  </div>
    <div style="height: 200"><br></div>

    <div class="form-group d-flex justify-content-between">
      <button type="button" class="btn btn-primary" style="width: 48%" id="btnSave">บันทึก</button>
      <button type="button" class="btn btn-secondary" style="width: 48%" id="btnClose">ปิด</button>
    </div>

    <div style="height: 200"><br></div>
</div>

<div class="modal fade" id="modal01">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
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
    user_id : "<?php echo $_GET['user_id']; ?>",
    user_login : $("#user_login").val(),
    user_password : $("#user_password").val(),
    prename_id : $("#prename_id").val(),
    fname : $("#fname").val(),
    lname : $("#lname").val(),
    phone : $("#phone").val(),
    office_id : $("#office_id").val(),
    line_token : $("#line_token").val(),
    group_id : $("#group_id").val(),
    status_id : $("#status_id").val(),
    date_register : $("#date_register").val()
  }
//   console.log(data);

  var not_complete=0;
  input_required.forEach(element => {
    if (data[element]=="") {
      not_complete=not_complete+1;
    }
  });

  if (not_complete>0) {
    $("#modal01_body").html('กรุณากรอกข้อมูลที่<font color="red">จำเป็น</font>ให้ครบ');
    $("#modal01").modal('show');
  }
  else {
    $.ajax({method: "POST", url: "ajaxSaveUserEdit.php",
      data: data
    })
    .done(function(x) {
      var r=jQuery.parseJSON(x).data;
      console.log(jQuery.parseJSON(x));
      if (r.status=="success") {
        $("#modal01_body").html('แก้ไขข้อมูลเรียบร้อยแล้ว');
        $("#modal01").modal('show');
        $( "#btnInsideModal" ).bind( "click", goPageSuggestion );
      }
    });
  }
});

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

var goPageSuggestion = function() {
  window.location="suggestion.php";
};

</script>