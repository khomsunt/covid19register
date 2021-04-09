<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// if ($_SESSION['group_id']<=0){
//   header("Location: ./login.php");
// }
// echo "<br><br><br>";
// print_r($_SESSION);
include '../include/config.php';
include '../include/functions.php';

$sql_common = "select
  c.real_risk as risk_level_id,
  r.risk_level_long_name,
  r.risk_level_name,
  count(c.covid_register_id) as count_risk_level
  from
  from_real_risk c
  left join risk_level r on c.real_risk=r.risk_level_id
  left join ampur47 a on c.ampur_in_code=a.ampur_code ";
$sql_e_common = "select
  c.real_risk as evaluate_level,
  r.risk_level_long_name,
  r.risk_level_name,
  count(*) as count_e
  from
  from_real_risk c
  left join risk_level r on c.real_risk=r.risk_level_id
  left join ampur47 a on c.ampur_in_code=a.ampur_code ";

switch ($_SESSION['group_id']) {
    case 1:
    case 2:
    case 4:
    case 5:
        $sql = $sql_common . "
      where
      cut_status_id=0
      group by
      c.real_risk";
        $sql_all = $sql_common . "
      group by
      c.real_risk";
        $sql_e_pending = $sql_e_common . "
      where
      c.cut_status_id=0
      group by
      c.real_risk";
        $sql_e_cutted = $sql_e_common . "
      where
      c.cut_status_id=1
      group by
      c.real_risk";
        $sql_e_all = $sql_e_common . "
      group by
      c.real_risk";
        break;
    case 3:
        $sql = $sql_common . "
      where
      cut_status_id=0
      and a.node_id=:user_node_id
      group by
      c.real_risk";
        $sql_all = $sql_common . "
      where
      a.node_id=:user_node_id
      group by
      c.real_risk";
        $sql_e_pending = $sql_e_common . "
      where
      c.cut_status_id=0
      and a.node_id=:user_node_id
      group by
      c.real_risk";
        $sql_e_cutted = $sql_e_common . "
      where
      c.cut_status_id=1
      and a.node_id=:user_node_id
      group by
      c.real_risk";
        $sql_e_all = $sql_e_common . "
      where
      a.node_id=:user_node_id
      group by
      c.real_risk";
        break;
    case 7:
        $sql = $sql_common . "
      where
      cut_status_id=1
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_all = $sql_common . "
      where
      c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_pending = $sql_e_common . "
      where
      c.cut_status_id=0
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_cutted = $sql_e_common . "
      where
      c.cut_status_id=1
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_all = $sql_e_common . "
      where
      c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $params = ['ampur_code' => $_SESSION['ampur_code']];
        break;
    case 8:
    case 9:
        $sql = $sql_common . "
      where
      cut_status_id=1
      and c.hospcode=:hospcode
      group by
      c.real_risk";
        $sql_all = $sql_common . "
      where
      c.hospcode=:hospcode
      group by
      c.real_risk";
        $sql_e_pending = $sql_e_common . "
      where
      c.cut_status_id=0
      and c.hospcode=:hospcode
      group by
      c.real_risk";
        $sql_e_cutted = $sql_e_common . "
      where
      c.cut_status_id=1
      and c.hospcode=:hospcode
      group by
      c.real_risk";
        $sql_e_all = $sql_e_common . "
      where
      c.hospcode=:hospcode
      group by
      c.real_risk";
        $params = ['hospcode' => $_SESSION['office_code']];
        break;

    case 10:
        $sql = $sql_common . "
      where
      cut_status_id=1
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_all = $sql_common . "
      where
      c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_pending = $sql_e_common . "
      where
      c.cut_status_id=0
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_cutted = $sql_e_common . "
      where
      c.cut_status_id=1
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_all = $sql_e_common . "
      where
      c.ampur_in_code=:ampur_code
      group by
      c.real_risk";

        $params = ['ampur_code' => $_SESSION['ampur_code']];
        break;

    case 11:
        $sql = $sql_common . "
      where
      cut_status_id=1
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_all = $sql_common . "
      where
      c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_pending = $sql_e_common . "
      where
      c.cut_status_id=0
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_cutted = $sql_e_common . "
      where
      c.cut_status_id=1
      and c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $sql_e_all = $sql_e_common . "
      where
      c.ampur_in_code=:ampur_code
      group by
      c.real_risk";
        $params = ['ampur_code' => $_SESSION['ampur_code']];
        break;

    default:
        # code...
        break;
}
$obj = $connect->prepare($sql);
$obj->execute($params);
$rows_risk_level = $obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows_risk_level);
// echo "<br><br>sql_all=".$sql_all;
$obj = $connect->prepare($sql_all);
$obj->execute($params);
$rows_risk_level_all = $obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows_risk_level_all);

// echo "<br>sql_e_pending=".$sql_e_pending;
$obj = $connect->prepare($sql_e_pending);
$obj->execute($params);
$rows_e_pending = $obj->fetchAll(PDO::FETCH_ASSOC);

// echo "<br>sql_e_cutted=".$sql_e_cutted;
$obj = $connect->prepare($sql_e_cutted);
$obj->execute($params);
$rows_e_cutted = $obj->fetchAll(PDO::FETCH_ASSOC);

// echo "<br>sql_e_all=".$sql_e_all;
$obj = $connect->prepare($sql_e_all);
$obj->execute($params);
$rows_e_all = $obj->fetchAll(PDO::FETCH_ASSOC);

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
include "./header.php";
?>
<main role="main" style="margin-top:50px;">
<!--
ด่านตรวจ -->
<?php
if ($_SESSION['group_id'] == 11) {
    ?>
  <center>
  </center>
  <div class="container">
  <div class="row" >

    <div class="col-lg-4">
      <div>
        <center>
        <h5>QR code<br><?php echo $_SESSION['office_name']; ?></h5>
        </center>
      </div>
      <center>
      <?php
$sql_qrcode = "select * from checkpoint_qrcode where office_id=" . $_SESSION['office_id'] . " order by checkpoint_qrcode_id desc limit 1";
    $obj = $connect->prepare($sql_qrcode);
    $obj->execute();
    $rows_qrcode = $obj->fetchAll(PDO::FETCH_ASSOC);
    $url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=http://www.skko.moph.go.th/liff_covid/main/register.php?checkpoint_id=" . $rows_qrcode[0]['token'] . "&choe=UTF-8";
    ?>
      <img src="<?php echo $url; ?>" />
      </center>
    </div><!-- /.col-lg-4 -->

    <div class="col-lg-4 d-none">
      <?php
$count_rows_risk_level_all = 0;
    foreach ($rows_risk_level_all as $key => $value) {
        $count_rows_risk_level_all += $value['count_risk_level'];
    }
    ?>
      <div class="risk-evaluate" style="cursor:pointer;">
        <h5>ข้อมูลสะสม <span class="badge badge-primary"><?php echo $count_rows_risk_level_all; ?></span></h5>
      </div>
      <?php
$sql = "select * from risk_level order by order_id desc";
    $obj = $connect->prepare($sql);
    $obj->execute();
    $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $rows_key => $rows_value) {
        $this_value = 0;
        foreach ($rows_risk_level_all as $key => $value) {
            if ($rows_value['risk_level_id'] == $value['risk_level_id']) {
                $this_value = $value['count_risk_level'];
                break;
            }
        }
        ?>
          <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left btn-risk-level-all-bak risk-evaluate" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
              <?php
if ($rows_value['risk_level_id'] == '39' or $rows_value['risk_level_id'] == '59' or $rows_value['risk_level_id'] == '99') {
            ?>
              <i class="fa fa-home text-success"></i>
                <?php
}?>
              <?php echo $rows_value['risk_level_long_name']; ?>
              <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
          </button>
          <?php
}?>

    </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->
    <div class="row">
      <?php
include "./checkpoint_dashboard_count.php";
    ?>

    </div>
  </div>
  <?php
} else {?>


  <div class="container marketing">
    <center>
      <h5>ข้อมูลการรายงานตัวเข้าสกลนคร <?php echo $_SESSION['office_name']; ?></h5>
    </center>
    <?php
// print_r($_SESSION);
    if (($_SESSION['node_id'] > 0) and ($_SESSION['group_id'] == 3)) {
        ?>
      <center>
      <h5>Node <?php echo decodeCode('node', $_SESSION['node_id'], 'node_id', 'node_name'); ?></h5>
      </center>
      <?php
}?>
    <div class="row">
      <?php
if ($_SESSION['group_id'] > 0) {
        ?>

      <div class="col-lg-4">
        <?php
$count_rows_e_pending = 0;
        foreach ($rows_e_pending as $key => $value) {
            $count_rows_e_pending += $value['count_e'];
        }
        ?>
        <div class="btn-new" style="cursor:pointer;">
          <h5>ข้อมูลใหม่ <span class="badge badge-primary"><?php echo $count_rows_e_pending; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($rows_e_pending as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['evaluate_level']) {
                    $this_value = $value['count_e'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left btn-risk-level" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>
      </div><!-- /.col-lg-4 -->

      <div class="col-lg-4">
        <?php
$count_rows_e_cutted = 0;
        foreach ($rows_e_cutted as $key => $value) {
            $count_rows_e_cutted += $value['count_e'];
        }
        ?>
        <div class="btn-cutted" style="cursor:pointer;">
          <h5>ข้อมูลตัดแล้ว <span class="badge badge-primary"><?php echo $count_rows_e_cutted; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($rows_e_cutted as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['evaluate_level']) {
                    $this_value = $value['count_e'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left btn-risk-level-cutted" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>
      </div><!-- /.col-lg-4 -->

      <div class="col-lg-4">
        <?php
$count_rows_e_all = 0;
        foreach ($rows_e_all as $key => $value) {
            $count_rows_e_all += $value['count_e'];
        }
        ?>
        <div class="btn-all" style="cursor:pointer;">
          <h5>ข้อมูลทั้งหมด <span class="badge badge-primary"><?php echo $count_rows_e_all; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($rows_e_all as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['evaluate_level']) {
                    $this_value = $value['count_e'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left btn-risk-level" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>
      </div><!-- /.col-lg-4 -->

      <?php
}?>
    </div><!-- /.row -->





    <?php
// print_r($_SESSION);
    if (($_SESSION['node_id'] > 0) and ($_SESSION['group_id'] == 3)) {
        ?>
      <center>
      <h5>Node <?php echo decodeCode('node', $_SESSION['node_id'], 'node_id', 'node_name'); ?></h5>
      </center>
      <?php
}?>
    <!-- Three columns of text below the carousel -->
    <div class="row">
      <?php
if ($_SESSION['group_id'] > 0) {
        ?>

      <div class="col-lg-4">
        <center>
          <h5>ข้อมูลการประเมิน (จนท.)</h5>
        </center>
        <?php
$count_rows_risk_level_all = 0;
        foreach ($rows_risk_level_all as $key => $value) {
            $count_rows_risk_level_all += $value['count_risk_level'];
        }
        ?>
        <div class="risk-evaluate" style="cursor:pointer;">
          <h5>ข้อมูลสะสม <span class="badge badge-primary"><?php echo $count_rows_risk_level_all; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($rows_risk_level_all as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['risk_level_id']) {
                    $this_value = $value['count_risk_level'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left btn-risk-level-all-bak risk-evaluate" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php
if ($rows_value['risk_level_id'] == '39' or $rows_value['risk_level_id'] == '59' or $rows_value['risk_level_id'] == '99') {
                ?>
                <i class="fa fa-home text-success"></i>
                  <?php
}?>
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>

      </div><!-- /.col-lg-4 -->
      <?php
}?>
    </div><!-- /.row -->





    <!-- START THE FEATURETTES -->

    <!-- <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It’ll blow your mind.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider"> -->

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->
  <?php
}?>


  <!-- FOOTER -->
  <?php
include "./footer.php";
?>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/tableToCards.js"></script>
      <script>
        $(function(){
          $(".risk-evaluate").click(function(){
            console.log($(this).attr("risk_level_id"));
            window.location = './pcu_register_list.php?risk_level_id='+$(this).attr("risk_level_id");
          })
          $(".btn-new").click(function(){
            window.location = './MyCovid19register.php?type=new&risk_level_id=-1';
          })
          $(".btn-cutted").click(function(){
            window.location = './MyCovid19register.php?type=cutted&risk_level_id=-1';
          })
          $(".btn-all").click(function(){
            window.location = './MyCovid19register.php?type=all&risk_level_id=-1';
          })



            $(".btn-risk-level").click(function(){
                console.log($(this).attr("risk_level_id"));
                window.location = './MyCovid19register.php?type=new&risk_level_id=' + $(this).attr("risk_level_id");
            })
            $(".btn-risk-level-cutted").click(function(){
                console.log($(this).attr("risk_level_id"));
                window.location = './MyCovid19register.php?type=cutted&risk_level_id=' + $(this).attr("risk_level_id");
            })
            $(".btn-risk-level-all").click(function(){
                console.log($(this).attr("risk_level_id"));
                window.location = './MyCovid19register.php?type=all&risk_level_id=' + $(this).attr("risk_level_id");
            })
        })
      </script>

</html>
