<?php 
   include_once '../include/config.php';
?>

<!DOCTYPE html>
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

<script>
    let input_required = ['user_password','new_password','confirm_password'];
    $('.required').css({
        'color': 'red',
        'visibility': 'hidden'
    });

    input_required.forEach(element => {
        $('#'+element).parent().find(".required").text(" *จำเป็น").css({'visibility': 'visible'});
    });
</script>

<div class="container" style="background-color: #b9ddff; background-image: url(../image/header03.png); background-repeat: no-repeat; background-size: contain, cover; background-position: top center;">
   <div style="height: 100;"><br></div>
   <div style="display: flex; align-items: flex-start;">
      <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
      <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
   </div>
   <h2 style="text-align: center; margin-top: 20px; margin-bottom: 20px;">เปลี่ยนรหัสผ่าน</h2>
   <form name="resetform" action="listUser.php" id="resetform" class="passform" method="post" role="form">
      <br/>
      <input type="hidden" name="user_login" value="<?php echo $user_login; ?>" ></input>

      <label for="user_password">รหัสผ่านปัจจุบัน <span class="required"></span></label>
      <input type="password" class="form-control" name="old_password" id="old_password" placeholder="รหัสผ่านปัจจุบัน"><br>

      <label for="new_password">รหัสผ่านใหม่ <span class="required"></span></label>
      <input type="password" class="form-control" name="new_password" id="new_password" placeholder="รหัสผ่านใหม่"><br>
      <label for="confirm_password">ยืนยันรหัสผ่าน <span class="required"></span></label>
      <input type="password" class="form-control"  name="confirm_password"  id="confirm_password" placeholder="ยืนยันรหัสผ่าน">
      <br>
      <input type="submit" class="btn btn-warning" name="password_change" id="submit_btn" value="เปลี่ยนรหัสผ่าน" />
   </form>

<!--display success/error message-->
<div id="message"></div>
</div>
    
</body>
</html>

<script>
   $(document).ready(function() {
    var frm = $('#resetform');
    frm.submit(function(e){
        e.preventDefault();

        var formData = frm.serialize();
        formData += '&' + $('#submit_btn').attr('name') + '=' + $('#submit_btn').attr('value');
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: formData,
            success: function(data){
                $('#message').html(data).delay(2000).fadeOut(2000);
                window.location = "listUser.php";
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#message').html(textStatus).delay(1000).fadeOut(1000);
            }

        });
    });
});
</script>


<?php

   if (isset($_POST['password_change'])) {

       $user_login = strip_tags($_POST['user_login']);
       $user_password = strip_tags($_POST['user_password']);
       $new_password = strip_tags($_POST['new_password']);
       $confirm_password = strip_tags($_POST['confirm_password']);

       // match username with the username in the database
       $sql = "SELECT * FROM `user` WHERE `user_login` = ? LIMIT 1";

       $query = $dbh->prepare($sql);
       $query->bindParam(1, $user_login, PDO::PARAM_STR);

       if($query->execute() && $query->rowCount()){
           $hash = $query->fetch();
           if ($user_password == $hash['user_password']){
               if($new_password == $confirm_password) {
                   $sql = "UPDATE `user` SET `user_password` = ? WHERE `user_login` = ?";

                   $query = $dbh->prepare($sql);
                   $query->bindParam(1, $new_password, PDO::PARAM_STR);
                   $query->bindParam(2, $user_login, PDO::PARAM_STR);
                   if($query->execute()){
                       echo "เปลี่ยนรหัสผ่านสำเร็จ";
                   }else{
                       echo "การเปลี่ยนรหัสผ่านไม่สำเร็จ";
                   }
               } else {
                   echo "รหัสผ่านของคุณไม่ตรงกัน";
               }
           }else{
               echo "กรุณาใส่รหัสผ่านปัจจุบันของคุณให้ถูกต้อง";
           }
       }else{
           echo "ชื่อผู้ใช้งาน (Username) ของคุณไม่ถูกต้อง";
       }
   }

?>