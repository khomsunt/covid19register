<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id'] <= 0) {
    header("Location: ./login.php");
}
// if ($_SESSION['group_id']<=0){
//   header("Location: ./login.php");
// }
// echo "<br><br><br>";
// print_r($_SESSION);
include '../include/config.php';
include '../include/functions.php';

//// ---------------- songkran64_V2
$sk64_v2_sql_A = "select c.real_risk as risk_level_id,r.risk_level_long_name,r.risk_level_name,count(c.covid_register_id) as count_risk_level
  from from_real_risk_songkran64_v2 c
  left join risk_level_songkran64_v2 r on c.real_risk=r.risk_level_id
  left join ampur47 a on c.ampur_in_code=a.ampur_code
  where c.cut_status_id not in (2,3) ";

$sk64_v2_sql_B = "select c.real_risk as evaluate_level,r.risk_level_long_name,r.risk_level_name,count(*) as count_e
  from from_real_risk_songkran64_v2 c
  left join risk_level_songkran64_v2 r on c.real_risk=r.risk_level_id
  left join ampur47 a on c.ampur_in_code=a.ampur_code
  where c.cut_status_id not in (2,3) ";

switch ($_SESSION['group_id']) {
    case 1:
    case 2:
    case 4:
    case 5:
        $sk64_v2_sql_all = $sk64_v2_sql_B . "
      group by c.real_risk";
        $sk64_v2_sql_not_eval = $sk64_v2_sql_A . "
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        break;
    case 3:
        $sk64_v2_sql_all = $sk64_v2_sql_B . "
      and a.node_id=:user_node_id
      group by c.real_risk";
        $sk64_v2_sql_not_eval = $sk64_v2_sql_A . "
      and a.node_id=:user_node_id
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        break;
    case 7:
        $sk64_v2_sql_all = $sk64_v2_sql_B . "
      and c.ampur_in_code=:ampur_code
      group by c.real_risk";
        $sk64_sql_not_eval = $sk64_v2_sql_A . "
      and c.ampur_in_code=:ampur_code
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_v2_params = ['ampur_code' => $_SESSION['ampur_code']];
        break;
    case 8:
    case 9:
        $sk64_v2_sql_all = $sk64_v2_sql_B . "
      and c.hospcode=:hospcode
      group by c.real_risk";
        $sk64_v2_sql_not_eval = $sk64_v2_sql_A . "
      and c.hospcode=:hospcode
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_v2_params = ['hospcode' => $_SESSION['office_code']];
        break;

    case 10:
        $sk64_v2_sql_all = $sk64_v2_sql_B . "
      and c.ampur_in_code=:ampur_code
      group by c.real_risk";
        $sk64_v2_sql_not_eval = $sk64_v2_sql_A . "
      and c.ampur_in_code=:ampur_code
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_v2_params = ['ampur_code' => $_SESSION['ampur_code']];
        break;

    case 11:
        $sk64_v2_sql_all = $sk64_v2_sql_B . "
      and c.ampur_in_code=:ampur_code
      group by c.real_risk";
        $sk64_v2_sql_not_eval = $sk64_v2_sql_A . "
      and c.ampur_in_code=:ampur_code
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_v2_params = ['ampur_code' => $_SESSION['ampur_code']];
        break;

    default:
        # code...
        break;
}

$obj = $connect->prepare($sk64_v2_sql_all);
$obj->execute($sk64_v2_params);
$sk64_v2_rows_e_all = $obj->fetchAll(PDO::FETCH_ASSOC);

$obj = $connect->prepare($sk64_v2_sql_not_eval);
$obj->execute($sk64_v2_params);
$sk64_v2_rows_all_not_eval = $obj->fetchAll(PDO::FETCH_ASSOC);

//// ---------------- songkran64
$sk64_sql_A = "select c.real_risk as risk_level_id,r.risk_level_long_name,r.risk_level_name,count(c.covid_register_id) as count_risk_level
  from from_real_risk_songkran64 c
  left join risk_level_songkran64 r on c.real_risk=r.risk_level_id
  left join ampur47 a on c.ampur_in_code=a.ampur_code
  where c.cut_status_id not in (2,3) ";

$sk64_sql_B = "select c.real_risk as evaluate_level,r.risk_level_long_name,r.risk_level_name,count(*) as count_e
  from from_real_risk_songkran64 c
  left join risk_level_songkran64 r on c.real_risk=r.risk_level_id
  left join ampur47 a on c.ampur_in_code=a.ampur_code
  where c.cut_status_id not in (2,3) ";

switch ($_SESSION['group_id']) {
    case 1:
    case 2:
    case 4:
    case 5:
        $sk64_sql_all = $sk64_sql_B . "
      group by c.real_risk";
        $sk64_sql_not_eval = $sk64_sql_A . "
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        break;
    case 3:
        $sk64_sql_all = $sk64_sql_B . "
      and a.node_id=:user_node_id
      group by c.real_risk";
        $sk64_sql_not_eval = $sk64_sql_A . "
      and a.node_id=:user_node_id
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        break;
    case 7:
        $sk64_sql_all = $sk64_sql_B . "
      and c.ampur_in_code=:ampur_code
      group by c.real_risk";
        $sk64_sql_not_eval = $sk64_sql_A . "
      and c.ampur_in_code=:ampur_code
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_params = ['ampur_code' => $_SESSION['ampur_code']];
        break;
    case 8:
    case 9:
        $sk64_sql_all = $sk64_sql_B . "
      and c.hospcode=:hospcode
      group by c.real_risk";
        $sk64_sql_not_eval = $sk64_sql_A . "
      and c.hospcode=:hospcode
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_params = ['hospcode' => $_SESSION['office_code']];
        break;

    case 10:
        $sk64_sql_all = $sk64_sql_B . "
      and c.ampur_in_code=:ampur_code
      group by c.real_risk";
        $sk64_sql_not_eval = $sk64_sql_A . "
      and c.ampur_in_code=:ampur_code
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_params = ['ampur_code' => $_SESSION['ampur_code']];
        break;

    case 11:
        $sk64_sql_all = $sk64_sql_B . "
      and c.ampur_in_code=:ampur_code
      group by c.real_risk";
        $sk64_sql_not_eval = $sk64_sql_A . "
      and c.ampur_in_code=:ampur_code
      and date_arrived_sakonnakhon is null
      group by c.real_risk";
        $sk64_params = ['ampur_code' => $_SESSION['ampur_code']];
        break;

    default:
        # code...
        break;
}

$obj = $connect->prepare($sk64_sql_all);
$obj->execute($sk64_params);
$sk64_rows_e_all = $obj->fetchAll(PDO::FETCH_ASSOC);

$obj = $connect->prepare($sk64_sql_not_eval);
$obj->execute($sk64_params);
$sk64_rows_all_not_eval = $obj->fetchAll(PDO::FETCH_ASSOC);

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


<!-- ด่านตรวจ -->
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
} else {
    ?>






<div class="container marketing" style="width: 95%; border: solid 1px #000000; border-radius: 7px; padding-top: 10px; padding: 5px; margin-bottom: 10px;">
  <div style="border: solid 1px #E2E2E2; border-radius: 5px; padding: 2px; padding-left: 10px; margin-bottom: 20px;">
    <h5>แบ่งตามเกณฑ์พื้นที่เสี่ยงใหม่(ผู้ที่จะเดินทางเข้าสกลนครตั้งแต่วันที่ 18 เมษายน 2564 เป็นต้นมา)</h5>
  </div>

  <div class="container marketing">
    <div class="row">
<?php
if ($_SESSION['group_id'] > 0) {
        ?>


      <div class="col-lg-6" style="margin-bottom: 20px;">
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
}
        ?>
        <?php
$count_rows_e_all = 0;
        foreach ($sk64_v2_rows_e_all as $key => $value) {
            $count_rows_e_all += $value['count_e'];
        }
        ?>
        <!-- <div class="sk64-btn-all" style="cursor:pointer; height: 60px;"> -->
        <div class="sk64-v2-btn-all" style=" cursor: pointer;">
          <h5>ข้อมูลทั้งหมด <span class="badge badge-primary"><?php echo $count_rows_e_all; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level_songkran64_v2 order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($sk64_v2_rows_e_all as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['evaluate_level']) {
                    $this_value = $value['count_e'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left sk64-v2-btn-risk-level-all" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>
      </div><!-- /.col-lg-6 -->


      <div class="col-lg-6" style="margin-bottom: 20px;">
        <div style="width: 100%; text-align: center;">
          <div>
            <!-- <div style="display: inline; background-color: #7f7f7f; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; margin-right: 10px; cursor: pointer;" onclick="window.location='report_risk_list_grey.php';"> -->
            <div style="display: inline; background-color: #C70039; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; margin-right: 10px; cursor: pointer;" onclick="window.location='pcu_register_list_songkran64_v2.php?type=all&risk_level_id=203';">
              รายชื่อกลุ่มเสี่ยงสีแดง
            </div>
            <!-- <div style="display: inline; background-color: #ff6600; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; cursor: pointer;" onclick="window.location='report_risk_list_orange.php';"> -->
            <div style="display: inline; background-color: #ff6600; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; cursor: pointer;" onclick="window.location='pcu_register_list_songkran64_v2.php?type=all&risk_level_id=202';">
              รายชื่อกลุ่มเสี่ยงสีส้ม
            </div>
          </div>
          <div style="height: 20px;"></div>
          <div style="width: 100%; text-align: center;">
            <img src="../image/skn_covid_color_202104_v2.jpg" style="width: 400px;">
          </div>
        </div>
      </div>


      <div class="col-lg-6" style="display: none;">
        <?php
$count_rows_risk_level_all = 0;
        foreach ($sk64_v2_rows_all_not_eval as $key => $value) {
            $count_rows_risk_level_all += $value['count_risk_level'];
        }
        ?>
        <!-- <div class="sk64-risk-evaluate" style="cursor:pointer; height: 60px;"> -->
        <div class="sk64-v2-risk-not-eval"  style=" cursor: pointer;">
          <h5>จนท.ยังไม่ประเมิน<span class="badge badge-primary"><?php echo $count_rows_risk_level_all; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level_songkran64_v2 order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($sk64_v2_rows_all_not_eval as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['risk_level_id']) {
                    $this_value = $value['count_risk_level'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left sk64-v2-btn-risk-level-not-eval" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>
      </div>
      <!-- /.col-lg-6 -->



<?php
}
    ?>

    </div><!-- /.row -->

  </div>
</div>


<div class="container marketing" style="width: 95%; border: solid 1px #000000; border-radius: 7px; padding-top: 10px; padding: 5px; margin-bottom: 10px;">
  <div style="border: solid 1px #E2E2E2; border-radius: 5px; padding: 2px; padding-left: 10px; margin-bottom: 20px;">
    <h5>แบ่งตามเกณฑ์พื้นที่เสี่ยงใหม่(ผู้ที่จะเดินทางเข้าสกลนครตั้งแต่วันที่ 9 - 17 เมษายน 2564)</h5>
  </div>

  <div class="container marketing">
    <div class="row">
<?php
if ($_SESSION['group_id'] > 0) {
        ?>


      <div class="col-lg-6" style="margin-bottom: 20px;">
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
}
        ?>
        <?php
$count_rows_e_all = 0;
        foreach ($sk64_rows_e_all as $key => $value) {
            $count_rows_e_all += $value['count_e'];
        }
        ?>
        <!-- <div class="sk64-btn-all" style="cursor:pointer; height: 60px;"> -->
        <div class="sk64-btn-all" style=" cursor: pointer;">
          <h5>ข้อมูลทั้งหมด <span class="badge badge-primary"><?php echo $count_rows_e_all; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level_songkran64 order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($sk64_rows_e_all as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['evaluate_level']) {
                    $this_value = $value['count_e'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left sk64-btn-risk-level-all" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>
      </div><!-- /.col-lg-6 -->


      <div class="col-lg-6" style="margin-bottom: 20px;">
        <div style="width: 100%; text-align: center;">
          <div>
            <!-- <div style="display: inline; background-color: #7f7f7f; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; margin-right: 10px; cursor: pointer;" onclick="window.location='report_risk_list_grey.php';"> -->
            <div style="display: inline; background-color: #7f7f7f; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; margin-right: 10px; cursor: pointer;" onclick="window.location='pcu_register_list_songkran64_v2.php?type=all&risk_level_id=203';">
              รายชื่อกลุ่มเสี่ยงสีเทา
            </div>
            <!-- <div style="display: inline; background-color: #ff6600; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; cursor: pointer;" onclick="window.location='report_risk_list_orange.php';"> -->
            <div style="display: inline; background-color: #ff6600; border: solid 1px #000000; padding: 10px; border-radius: 5px; color: #FFFFFF; cursor: pointer;" onclick="window.location='pcu_register_list_songkran64_v2.php?type=all&risk_level_id=202';">
              รายชื่อกลุ่มเสี่ยงสีส้ม
            </div>
          </div>
          <div style="height: 20px;"></div>
          <div style="width: 100%; text-align: center;">
            <img src="../image/skn_covid_color_202104.jpg" style="width: 400px;">
          </div>
        </div>
      </div>


      <div class="col-lg-6" style="display: none;">
        <?php
$count_rows_risk_level_all = 0;
        foreach ($sk64_rows_all_not_eval as $key => $value) {
            $count_rows_risk_level_all += $value['count_risk_level'];
        }
        ?>
        <!-- <div class="sk64-risk-evaluate" style="cursor:pointer; height: 60px;"> -->
        <div class="sk64-risk-not-eval"  style=" cursor: pointer;">
          <h5>จนท.ยังไม่ประเมิน<span class="badge badge-primary"><?php echo $count_rows_risk_level_all; ?></span></h5>
        </div>
        <?php
$sql = "select * from risk_level_songkran64 order by order_id desc";
        $obj = $connect->prepare($sql);
        $obj->execute();
        $rows = $obj->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value = 0;
            foreach ($sk64_rows_all_not_eval as $key => $value) {
                if ($rows_value['risk_level_id'] == $value['risk_level_id']) {
                    $this_value = $value['count_risk_level'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left sk64-btn-risk-level-not-eval" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?>
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
}?>
      </div>
      <!-- /.col-lg-6 -->




<?php
}
    ?>

    </div><!-- /.row -->

  </div>
</div>



<div class="container marketing" style="width: 95%; border: solid 1px #000000; border-radius: 7px; padding-top: 10px; padding: 5px;">
  <div style="border: solid 1px #E2E2E2; border-radius: 5px; padding: 2px; padding-left: 10px;">
    <a href="index_before_songkran64.php">
      <h5>แบ่งตามเกณฑ์พื้นที่เสี่ยงเดิม >>คลิก<< </h5>
    </a>
  </div>
</div>

<br><br><br>

<?php
}
?>


<!-- FOOTER -->
<?php
include "./footer.php";
?>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script>
  window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')
</script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tableToCards.js"></script>
<script>
$(function(){
//--------------------------------------- สงกรานต์64_v2
  $(".sk64-v2-risk-not-eval").click(function(){
    // console.log($(this).attr("risk_level_id"));
    window.location = './pcu_register_list_songkran64_v2.php?type=not_eval';
  })
  $(".sk64-v2-btn-risk-level-not-eval").click(function(){
    console.log($(this).attr("risk_level_id"));
    window.location = './pcu_register_list_songkran64_v2.php?type=not_eval&risk_level_id='+$(this).attr("risk_level_id");
  })
  $(".sk64-v2-btn-all").click(function(){
    // window.location = './MyCovid19register_songkran64.php?type=all&risk_level_id=-1';
    window.location = './pcu_register_list_songkran64_v2.php?type=all';
  })
  $(".sk64-v2-btn-risk-level-all").click(function(){
      console.log($(this).attr("risk_level_id"));
      // window.location = './MyCovid19register_songkran64.php?type=all&risk_level_id=' + $(this).attr("risk_level_id");
      window.location = './pcu_register_list_songkran64_v2.php?type=all&risk_level_id='+$(this).attr("risk_level_id");
  })
  //--------------------------------------- สงกรานต์64
  $(".sk64-risk-not-eval").click(function(){
    // console.log($(this).attr("risk_level_id"));
    window.location = './pcu_register_list_songkran64.php?type=not_eval';
  })
  $(".sk64-btn-risk-level-not-eval").click(function(){
    console.log($(this).attr("risk_level_id"));
    window.location = './pcu_register_list_songkran64.php?type=not_eval&risk_level_id='+$(this).attr("risk_level_id");
  })
  $(".sk64-btn-all").click(function(){
    // window.location = './MyCovid19register_songkran64.php?type=all&risk_level_id=-1';
    window.location = './pcu_register_list_songkran64.php?type=all';
  })
  $(".sk64-btn-risk-level-all").click(function(){
      console.log($(this).attr("risk_level_id"));
      // window.location = './MyCovid19register_songkran64.php?type=all&risk_level_id=' + $(this).attr("risk_level_id");
      window.location = './pcu_register_list_songkran64.php?type=all&risk_level_id='+$(this).attr("risk_level_id");
  })
})
</script>

</html>
