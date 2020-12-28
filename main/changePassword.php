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
    <title>เปลี่ยนรหัสผ่าน</title>

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

  <h2 style="text-align:center; margin-top: 20px; margin-bottom: 20px;">เปลี่ยนรหัสผ่าน</h2>

  <div class="form-group">
  <label for="user_login">ชื่อผู้ใช้งาน <span class="required"></span></label>
    <input type="user_login" class="form-control" id="user_login" value="<?php echo $rows[0]['user_login']; ?>">

    <label for="user_password">รหัสผ่านปัจจบุัน <span class="required"></span></label>
    <!-- <input type="Password" class="form-control" id="user_password" value="<?php echo $rows[0]['user_password']; ?>"> -->
    <input type="Password" class="form-control" id="user_password" value="">

    <label for="new_password">รหัสผ่านใหม่ <span class="required"></span></label>
    <!-- <input type="Password" class="form-control" id="user_password" value="<?php echo $rows[0]['user_password']; ?>"> -->
    <input type="Password" class="form-control" id="new_password" value="">

    <label for="confirm_password">ยืนยันรหัสผ่าน <span class="required"></span></label>
    <!-- <input type="Password" class="form-control" id="user_password" value="<?php echo $rows[0]['user_password']; ?>"> -->
    <input type="Password" class="form-control" id="confirm_password" value="">

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
    new_password : $("#new_password").val(),
    confirm_password : $("#confirm_password").val(),
  }
  //   console.log(data);

  function valid() {
    if(new_password !== confirm_password) {
      alert("รหัสผ่านใหม่กับรหัสผ่านยืนยันไม่ตรงกับ !!!");
    }
  }

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
    $.ajax({method: "POST", url: "ajaxChangePassword.php",
      data: data
    })
    .done(function(x) {
      var r=jQuery.parseJSON(x).data;
      console.log(jQuery.parseJSON(x));
      if (r.status=="success") {
        $("#modal01_body").html('เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
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