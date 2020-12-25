<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
include('../include/functions.php');
$sql="select c.*,
p.prename_name,
cw.changwat_name as changwat_name_out,
a.ampur_name as ampur_name_out,
t.tambon_name as tambon_name_out,
a47.ampur_name as ampur_name_in,
t47.tambon_name as tambon_name_in,
o.occupation_name,
r.risk_level_long_name,
r2.risk_level_long_name as evaluate_level_name,
f.foreign_worker_nation_name
from covid_register c 
left join changwat cw on c.changwat_out_code=cw.changwat_code 
left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code
left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code
left join ampur47 a47 on c.ampur_in_code=a47.ampur_code
left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code
left join coccupation o on c.occupation_id=o.occupation_id
left join risk_level r on c.risk_level_id=r.risk_level_id
left join risk_level r2 on c.evaluate_level=r2.risk_level_id
left join prename p on c.prename_id=p.prename_id
left join foreign_worker_nation f on c.foreign_worker_nation_id=f.foreign_worker_nation_id
where a47.node_id=:user_node_id and c.risk_level_id=:risk_level_id";
if ($_GET['type']=="new"){
  $sql.=" and c.cut_status_id=0";
}
// echo "<br><br><br><br>_SESSION['node_id']=".$_SESSION['node_id'];
// echo "<br>node_id=".$_SESSION['node_id'];
// echo $sql;
$obj=$connect->prepare($sql);
$obj->execute([ 'user_node_id' => $_SESSION['node_id'], 'risk_level_id' => $_GET['risk_level_id'] ]);
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
    <title>Carousel Template · Bootstrap</title>

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
  <div class="container">
    <h5>รายชื่อผู้แจ้งเข้าจังหวัดกลุ่ม <?php echo decodeCode('risk_level',$_GET['risk_level_id'],'risk_level_id','risk_level_long_name'); ?></h5>
  </div>
  <table class="table" id="myTable">
    <thead>
      <tr>
        <th data-card-title>ชื่อ นามสกุล</th>
        <th>CID</th>
        <th data-card-action-links>วันที่บันทึก</th>
        <th>อาชีพ</th>
        <th>มาจาก</th>
        <th>มาที่</th>
        <th>วันที่มาถึงสกลนคร</th>  
        <th>เป็นแรงงานต่างด้าว</th>
        <th>สัญชาติ</th>
        <th>ไปพื้นที่เสี่ยง</th>
        <th>มาจากพื้นที่เสี่ยง</th>
        <th>ทำงานในสถานกักกัน</th>
        <th>มีประวัติสัมผัสโรค</th>
        <th>บุคลากรทางการแพทย์</th>
        <th>ไปในที่สังสัยหรือยืนยัน Covid-19</th>
        <th>คนใกล้ชิดมีอาการ</th>
        <th>อาการรอบ 14 วัน</th>
        <th>วันที่มีอาการ</th>
        <?php
          if ($_GET['type']=='new'){
        ?>    
        <th>ผลการประเมินตนเอง</th>
        <th>ผลการประเมิน (จนท)</th>
        <?php } ?>
        <th data-card-footer>มาจาก</th>
      </tr>
    </thead>
    <tbody>
        <?php

        $sql="select * from risk_level order by risk_level_id";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rows_risk_level=$obj->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($rows as $key => $value) {
          ?>
          <tr>

              <td>
              <span class="badge badge-info"><?php echo $key+1; ?></span>
              <?php echo $value['prename_name'].$value['fname']." ".$value['lname']; ?>
              </div></td>

              <td><div class="data"><?php echo $value['cid']; ?></div></div></td>
              <td><div class="data"><?php echo $value['register_datetime']; ?></div></td>
              <td><div class="data"><?php echo $value['occupation_name']; ?></div></td>
              <td><div class="data">
                  ที่อยู่ <?php echo $value['house_out_no']; ?>
                  ม. <?php echo $value['moo_out_code']; ?>
                  ต. <?php echo $value['tambon_name_out']; ?>
                  อ. <?php echo $value['ampur_name_out']; ?>
                  จ. <?php echo $value['changwat_name_out']; ?>
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
              <td><div class="data">
                  <?php echo ($value['foreign_worker']=='1')?"ใช่":"ไม่ใช่"; ?>
              </div></td>
              <td><div class="data">
                  <?php echo $value['foreign_worker_nation_name']; ?>
              </div></td>


              <td><div class="data">
              <?php
              $sql_risk_area = "select * from covid_register_risk_area c left join risk_area r on c.risk_area_id=r.risk_area_id where c.covid_register_id=:covid_register_id";
              
              $obj=$connect->prepare($sql_risk_area);
              $obj->execute(["covid_register_id"=>$value['covid_register_id']]);
              $rows_risk_area=$obj->fetchAll(PDO::FETCH_ASSOC);
              $a_area=[];
              foreach ($rows_risk_area as $key_risk_area => $value_risk_area) {
                array_push($a_area,$value_risk_area['area_name']);
              } 
              echo implode(",",$a_area); 
              ?>            
              </div></td>
              <td><div class="data"><?php echo ($value['q1_enter_risk_area']=="1")?"ใช่":"ไม่ใช่"; ?></div></td>
              <td><div class="data"><?php echo ($value['q2_quarantine_work_place']=="1")?"ใช่":"ไม่ใช่"; ?></div></td>
              <td><div class="data"><?php echo ($value['q3_touch_patient']=="1")?"ใช่":"ไม่ใช่"; ?></div></td>
              <td><div class="data"><?php echo ($value['q4_health_officer']=="1")?"ใช่":"ไม่ใช่"; ?></div></td>
              <td><div class="data"><?php echo ($value['q5_enter_patient_area']=="1")?"ใช่":"ไม่ใช่"; ?></div></td>
              <td><div class="data"><?php echo ($value['q6_sick_closer']=="1")?"ใช่":"ไม่ใช่"; ?></div></td>
              <td><div class="data">
                <?php echo ($value['symptom_fever']=='1')?'มีไข้ ':""; ?>
                <?php echo ($value['symptom_cough']=='1')?"ไอ ":""; ?>
                <?php echo ($value['symptom_nasal_mucus']=="1")?"มีน้ำมูก ":""; ?>
                <?php echo ($value['symptom_sore_throat']=="1")?"เจ็บคอ ":""; ?>
                <?php echo ($value['symptom_dyspnea']=="1")?"หายใจลำบาก หอบเหนื่อย ":""; ?>
                <?php echo ($value['symptom_not_smell']=="1")?"ไม่ได้กลิ่น ":""; ?>
                <?php echo ($value['symptom_not_taste']=="1")?"ไม่รู้รส ":""; ?>
                <?php echo ($value['symptom_fever']+$value['symptom_cough']+$value['symptom_nasal_mucus']+$value['symptom_sore_throat']+$value['symptom_dyspnea']+$value['symptom_not_smell']+$value['symptom_not_taste']==0)?"ไม่มีอาการ":""; ?>
              </div></td>
              <td><div class="data"><?php echo $value['symptom_date']; ?></div></td>
              <td><div class="data"><?php echo $value['evaluate_level_name']; ?></div></td>

              <?php
                if ($_GET['type']=='new'){
              ?>    
              <td>
                <span class="float-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                            <?php echo $value['risk_level_long_name']; ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                            <?php
                            foreach ($rows_risk_level as $key_risk_level => $value_risk_level) {
                                ?>
                                <button covid_register_id="<?php echo $value['covid_register_id']; ?>" risk_level_id="<?php echo $value_risk_level['risk_level_id']; ?>" class="dropdown-item btn-change-risk-level" type="button">
                                    <?php echo $value_risk_level['risk_level_long_name']; ?>
                                </button>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </span>
              </td>
              <?php } ?>
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
<!-- FOOTER -->
<?php
include("./footer.php");
?>
<script src="../js/jquery-3.2.1.min.js" ></script>
      <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/tableToCards.js"></script>
      <script>
        $(function(){
            $(".btn-change-risk-level").click(function(){
                console.log($(this).attr("covid_register_id"));
                $.ajax({
                    method: "POST",
                    url: "./changeRiskLevel.php",
                    data: { covid_register_id: $(this).attr("covid_register_id"), risk_level_id: $(this).attr("risk_level_id") }
                })
                .done(function( msg ) {
                  console.log(msg)
                  location.reload();

                  // $(this).parent().parent().children().first().html($(this).html())
                })
            })
        })
      </script>
</html>
