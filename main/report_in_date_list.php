<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
include('../include/functions.php');

$sql_report_risk="select c.*,
p.prename_name,
cw.changwat_name as changwat_name_out,
a.ampur_name as ampur_name_out,
t.tambon_name as tambon_name_out,
cw2.changwat_name as changwat_work_name_out,
a2.ampur_name as ampur_work_name_out,
t2.tambon_name as tambon_work_name_out,
a47.ampur_name as ampur_name_in,
t47.tambon_name as tambon_name_in,
o.occupation_name,
r.risk_level_long_name,
r.background_color,
r.color
from covid_register c 
left join changwat cw on c.changwat_out_code=cw.changwat_code 
left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code
left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code
left join changwat cw2 on c.changwat_work_code=cw2.changwat_code 
left join ampur a2 on c.changwat_work_code=a2.changwat_code and c.ampur_work_code=a2.ampur_code
left join tambon t2 on c.changwat_work_code=t2.changwat_code and c.ampur_work_code=t2.ampur_code and c.tambon_work_code=t2.tambon_code
left join ampur47 a47 on c.ampur_in_code=a47.ampur_code
left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code
left join coccupation o on c.occupation_id=o.occupation_id
left join risk_level r on c.risk_level_id=r.risk_level_id
left join prename p on c.prename_id=p.prename_id";
if ($_SESSION['group_id']==8 or $_SESSION['group_id']==9){
  $sql_report_risk.=" where c.hospcode='".$_SESSION['office_code']."' and c.date_to_sakonnakhon='".$_POST['date_to_sakonnakhon']."'"; 
} else{
    $sql_report_risk.=" c.date_to_sakonnakhon='".$_POST['date_to_sakonnakhon']."'"; 
}
// $sql_report_risk.=" GROUP BY
// date_to_sakonnakhon";
$obj=$connect->prepare($sql_report_risk);
$obj->execute();
$rows_report_risk=$obj->fetchAll(PDO::FETCH_ASSOC);
//print_r($sql_report_risk);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนคร แยกวันตามวันที่</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">

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
      .data{
        color: blue;
        display: inline;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body>
<?php
include("./header.php");
?>
<main role="main" style="margin-top:60px;">
<!-- <?php print_r($sql_report_risk); ?> -->
    <div class="container">
        <h5>รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนคร แยกวันตามวันที่ <?php echo thailongdate($_POST['date_to_sakonnakhon'])  ?></h5>
    </div>
    <table class="table" id="myTable">
    <thead>
        <tr>
        <th>ลำดับ</th>
            <th data-card-title>ชื่อ นามสกุล</th>
            <th>CID</th>
            <th>วันที่บันทึก</th>
            <th>อาชีพ</th>
            <th>ที่อยู่ก่อนเข้าสกลนคร</th>
            <th>ที่ทำงาน</th>
            <th>มาที่</th>
            <th>วันที่มาถึงสกลนคร</th> 
            <th data-card-footer>โทรศัพท์</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($rows_report_risk as $key => $value) 
        {
            ?>
            <tr id="<?php echo $value['covid_register_id'] ?>">
            <td><?php echo ++$i; ?></td>
              <td>
                <span class="badge badge-info" style="background-color:<?php echo $value['background_color']; ?>;color:<?php echo $value['color']; ?>;"><?php echo $key+1; ?></span>
                <?php echo $value['prename_name'].$value['fname']." ".$value['lname']; ?>
              </td>
              <td><div class="data"><?php echo $value['cid']; ?></div></div></td>
              <td><div class="data"><?php echo $value['register_datetime']; ?></div></td>
              <td><div class="data"><?php echo $value['occupation_name']; ?></div></td>
              <td><div class="data">
                ต. <?php echo $value['tambon_name_out']; ?>
                อ. <?php echo $value['ampur_name_out']; ?>
                จ. <?php echo $value['changwat_name_out']; ?>
              </div></td>
              <td><div class="data">
                ต. <?php echo $value['tambon_work_name_out']; ?>
                อ. <?php echo $value['ampur_work_name_out']; ?>
                จ. <?php echo $value['changwat_work_name_out']; ?>
              </div></td>
              <td><div class="data">
                ที่อยู่ <?php echo $value['house_in_no']; ?>
                ม. <?php echo $value['moo_in_code']; ?>
                ต. <?php echo $value['tambon_name_in']; ?>
                อ. <?php echo $value['ampur_name_in']; ?>
              </div></td>
              <?php if($value['date_to_sakonnakhon'] == "0000-00-00") { ?>
                <td><div class="data">
                    ไม่ทราบวันที่มาถึง
                </div></td>
              <?php  } ?>
              <?php if($value['date_to_sakonnakhon'] != "0000-00-00") { ?>
                  <td><div class="data"><?php echo thailongdate($value['date_to_sakonnakhon']);?> 
              </div></td>
              <?php  } ?>
              <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-telephone-fill" viewBox="0 0 16 16" stroke="blue" fill="yellow" fill-opacity="0.5" stroke-opacity="0.8">
                  <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
                </svg>
                <?php echo $value['tel']; ?>
              </td>
            </tr>
            <?php
        }?>
    </tbody>
    </table>
</main>

<div id="forExcelExport" style="display: none;"></div>

<!-- FOOTER -->
<?php
include("./footer.php");
?>
<script src="../js/jquery-3.2.1.min.js" ></script>
<script>
  window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')
</script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tableToCards.js"></script>
<script src='../js/table2excel.js'></script>
      
</html>
