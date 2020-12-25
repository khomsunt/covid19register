<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Floating labels example · Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script>
        function loginCheck(){
            $.ajax({
                method: "POST",
                url: "./loginCheck.php",
                data: { user_login: $("#user_login").val(), user_password: $("#user_password").val() }
            })
            .done(function( msg ) {
              console.log(msg);
                let userData = JSON.parse(msg);
                if (userData.length>0) {
                    localStorage.setItem("user_id", userData[0]['user_id']);
                    localStorage.setItem("user_login", userData[0]['user_login']);
                    localStorage.setItem("fname", userData[0]['fname']);
                    localStorage.setItem("lname", userData[0]['lname']);
                    localStorage.setItem("office_id", userData[0]['office_id']);
                    localStorage.setItem("office_code", userData[0]['office_code']);
                    localStorage.setItem("office_name", userData[0]['office_name']);
                    localStorage.setItem("node_id", userData[0]['node_id']);
                    window.location.replace("./index.php");

                }else{
                    alert("ป้อนชื่อหรือรหัสผ่านผิด");
                }
            });
        }
        $(function(){
            $("#submit").click(function(){
                loginCheck();
            })

        })
    </script>

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
    <link href="../css/floating-labels.css" rel="stylesheet">
  </head>
  <body>
    <form class="form-signin">
  <div class="text-center mb-4">
    <img src="../image/logo_skn.png" width="70" style="margin-right: 10px;">
    <img src="../image/logo_ssj.png" width="70" style="margin-right: 10px;">
    <h3 class="h4 mb-3 font-weight-normal" style="margin-top:20px;">ทะเบียนแจ้งเข้าจังหวัดสกลนคร</h1>
    <br>
  </div>

  <div class="form-label-group">
    <input type="text" id="user_login" class="form-control" placeholder="Username" required autofocus>
    <label for="user_login">ชื่อผู้ใช้งาน</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="user_password" class="form-control" placeholder="Password" required>
    <label for="user_password">รหัสผ่าน</label>
  </div>

  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> จำไว้ใช้ครั้งต่อไป
    </label>
  </div>
  <button id="submit" class="btn btn-lg btn-primary btn-block" type="button">เข้าสู่โปรแกรม</button>
  <p class="mt-5 mb-3 text-muted text-center">covid-19 register @2020</p>
</form>
</body>
</html>
