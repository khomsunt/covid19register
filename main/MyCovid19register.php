<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
include('../include/config.php');
include('../include/functions.php');
$sql="select c.*,
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
  r2.risk_level_long_name as evaluate_level_name,
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
  left join risk_level r2 on c.evaluate_level=r2.risk_level_id
  left join prename p on c.prename_id=p.prename_id";
if ($_GET['risk_level_id']>=0){  
  $sql.=" where c.hospcode='".$_SESSION['office_code']."' and c.evaluate_level=".$_GET['risk_level_id'];
}else{
  $sql.=" where c.hospcode='".$_SESSION['office_code']."' ";
}
// }else{
//   $sql.=" where c.risk_level_id=:risk_level_id";
// }
if ($_GET['type']=="new"){
  $sql.=" and c.cut_status_id=0";
}else{
  if ($_GET['type']=='cutted'){
    $sql.=" and c.cut_status_id=1";
  }
}
// $sql.=" limit 20";
// echo "<br><br><br><br>_SESSION['node_id']=".$_SESSION['node_id'];
// echo "<br>node_id=".$_SESSION['node_id'];
// echo "<br><br><br>";
// print_r($_SESSION);
// echo $sql;
$obj=$connect->prepare($sql);
if ($_SESSION['group_id']==8 or $_SESSION['group_id']==9){
  $obj->execute();
// }else{
//   $obj->execute([ 'risk_level_id' => $_GET['risk_level_id'] ]);
}
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
    <title><?php echo $projectTitle; ?></title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">
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
      <div class="container">
        <h5><img alt="เรียกข้อมูลใหม่" class="img-refresh" src="../image/refresh.svg" style="width:25px;height:25px;cursor:pointer;"> รายชื่อผู้แจ้งเข้าจังหวัดกลุ่ม <?php echo decodeCode('risk_level',$_GET['risk_level_id'],'risk_level_id','risk_level_long_name'); ?>
        </h5>
      </div>
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th data-card-title>ชื่อ นามสกุล</th>
            <th>CID</th>
            <th>วันที่บันทึก</th>
            <th>อาชีพ</th>
            <th>ที่อยู่ก่อนเข้าสกลนคร</th>
            <th>ที่ทำงาน</th>
            <th>มาที่</th>
            <th>วันที่มาถึงสกลนคร</th>  
            <?php
              if ($_GET['type']=='new'){
            ?>    
            <th>ผลการประเมินตนเอง</th>
            <!-- <th>ผลการประเมิน (จนท)</th> -->
            <?php } ?>
            <th data-card-footer>โทรศัพท์</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql="select * from risk_level order by risk_level_id desc";
          $obj=$connect->prepare($sql);
          $obj->execute();
          $rows_risk_level=$obj->fetchAll(PDO::FETCH_ASSOC);
          foreach ($rows as $key => $value) {
            ?>
            <tr id="<?php echo $value['covid_register_id'] ?>">
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
              <td><div class="data">
                <?php echo $value['date_to_sakonnakhon']; ?>
              </div></td>
              <td><div class="data"><?php echo $value['evaluate_level_name']; ?></div></td>
              <!-- <?php
                if ($_GET['type']=='new'){
                  ?>    
                  <td>
                    <span class="float-right">
                      <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" style="background-color:<?php echo $value['background_color']; ?>;color:<?php echo $value['color']; ?>;">
                          <?php echo $value['risk_level_long_name']; ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                          <?php
                            foreach ($rows_risk_level as $key_risk_level => $value_risk_level) {
                              if ($value_risk_level['risk_level_id']<>$value['risk_level_id']){
                                ?>
                                <button covid_register_id="<?php echo $value['covid_register_id']; ?>" risk_level_id="<?php echo $value_risk_level['risk_level_id']; ?>" class="dropdown-item btn-change-risk-level" type="button">
                                  <?php echo $value_risk_level['risk_level_long_name']; ?>
                                </button>
                                <?php
                              }
                            }
                          ?>
                        </div>
                      </div>
                    </span>
                  </td>
                  <?php 
                } ?> -->
              <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-telephone-fill" viewBox="0 0 16 16" stroke="blue" fill="yellow"
        fill-opacity="0.5" stroke-opacity="0.8">
                  <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
                </svg>
                <?php echo $value['tel']; ?>
              </td>
            </tr>
          <?php
          } ?>
        </tbody>
      </table>
    </main>
    <?php
      include("./footer.php");
    ?>
    <script src="../js/jquery-3.2.1.min.js" ></script>
    <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/tableToCards.js"></script>
    <script>
      $(function(){
        $(".btn-change-risk-level").click(function(){
          var thisObj=$(this);
          $.ajax({
            method: "POST",
            url: "./changeRiskLevel.php",
            data: { covid_register_id: thisObj.attr("covid_register_id"), risk_level_id: thisObj.attr("risk_level_id") }
          })
          .done(function( msg ) {
            if (thisObj.parent().parent().parent().parent().parent().parent().parent().attr('id')=='myTable'){
              thisObj.parent().parent().parent().parent().parent().hide();
            }else{
              thisObj.parent().parent().parent().parent().parent().parent().parent().hide();
            }
            // console.log(msg)
          })
        })
        $(".img-refresh").click(function(){
          location.reload();
        })
      })
    </script>
  </body>
</html>
