<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
include('../include/config.php');
include('../include/functions.php');
$now_date_time=date('Y-m-d H:i:s');

$sql="select c.*, p.prename_name, cw.changwat_name as changwat_name_out, a.ampur_name as ampur_name_out, t.tambon_name as tambon_name_out, cw2.changwat_name as changwat_work_name_out, 
a2.ampur_name as ampur_work_name_out, t2.tambon_name as tambon_work_name_out, a47.ampur_name as ampur_name_in, t47.tambon_name as tambon_name_in,v.villname,o.occupation_name, 
r.risk_level_long_name, r2.risk_level_long_name as evaluate_level_name, r.background_color, r.color,v.villno,c.hospcode
from covid_register c 
left join changwat cw on c.changwat_out_code=cw.changwat_code 
left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code left join changwat cw2 on c.changwat_work_code=cw2.changwat_code left join ampur a2 on c.changwat_work_code=a2.changwat_code and c.ampur_work_code=a2.ampur_code left join tambon t2 on c.changwat_work_code=t2.changwat_code and c.ampur_work_code=t2.ampur_code and c.tambon_work_code=t2.tambon_code 
left join ampur47 a47 on c.ampur_in_code=a47.ampur_code 
left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code 
LEFT JOIN village v ON CONCAT(c.changwat_in_code,c.ampur_in_code,c.tambon_in_code,c.moo_in_code_new)=v.villcode
left join coccupation o on c.occupation_id=o.occupation_id left join risk_level r on c.risk_level_id=r.risk_level_id 
left join risk_level r2 on c.evaluate_level=r2.risk_level_id left join prename p on c.prename_id=p.prename_id";
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

 //echo $sql;
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
      <button  risk_level_id="<?php echo $_GET['risk_level_id']; ?>"  type_cut="<?php echo $_GET['type']; ?>" office_code="<?php echo $_SESSION['office_code']; ?>"  type="button" class="btn btn-primary btn_cut_print">ตัดข้อมูและส่งออกExcel</button>
      <table class='table table-condensed  table-bordered table-hover' width="100%" id="myTable">
  <thead>
  <tr class="text-center" >
  <th colspan="38"><h4>ทะเบียนรายงานตัวของผู้เดินทาง</h4></th>
  <!-- <th colspan="39"><h4>ทะเบียนรายงานตัวของผู้เดินทาง วันเวลาที่ตัดข้อมูล<?php echo $_POST['cut_datetime']; ?></h4></th> -->
  </tr>
  <tr>
  <th colspan="38" style="background-color:#C8C6C5">
  <h5>
  หมายเหตุ (1) หมายถึง ผู้เดินทางมาจากจังหวัดสมุทรสาคร (ไม่เกี่ยวข้องกับตลาดอาหารปลา)<br>
  หมายเหตุ (2) หมายถึง ผู้มีประหวัดเกี่ยวข้องกับตลาดอาหารทะเลทั้งหมดในจังหวัดสมุทรสาคร<br>
  หมายเหตุ (3) หมายถึง ผู้ประกอบการ/พ่อค้า แม่ค้า ที่มีการติดต่อกับอาหารทะเลทั้งหมดในจังหวัดสมุทรสาคร<br>
  หมายเหตุ (2) หมายถึง พนักงานขับรถและผู้สัมผัสใกล้ชิดรถขนส่งอาหารจำหน่ายอาหารทะเลในจังหวัดสมุทรสาคร<br>
  หมายเหตุ (2) หมายถึง แรงงานต่างด้าว ในพื้นที่จังหวัดสกลนคร<br>
  </h5>
  </th>
 
  </tr>
  <tr>
  <th colspan="38"></th>
  </tr>
  <tr class="text-center">
    <th rowspan="2">วันที่ตัดข้อมูล</th>
    <th rowspan="2">วันที่บันทึก</th>
    <th rowspan="2">ลำดับ</th>
    <th rowspan="2" data-card-title>ชื่อ</th>
    <th rowspan="2" data-card-title>นามสกุล</th>
    <th rowspan="2">เพศ</th>
    <th rowspan="2">อายุ</th>
    <th rowspan="2">อาชีพ</th>
    <th colspan="6">ที่อยู่จริง</th>
    <th rowspan="2">เบอร์โทร</th>
    <th rowspan="2">วดป.ที่เดินทางมา</th>
    <th rowspan="2">วันที่เดินทาง</th>
    <th rowspan="2">สิ้นสุดเฝ้าระวัง</th>
    <th colspan="6">ที่อยู่ในสกลนคร</th>
    <th rowspan="2">สาเหตุที่เดินทางไป</th>
    <th rowspan="2">พาหนะที่ใช้เดินทาง</th>
    <th colspan="2">อาการ</th>
    <th colspan="5">ประเภท</th>
    <th colspan="2">lab</th>
    <th colspan="2">ผล</th>
    <th rowspan="2">หน่วยบริการรับผิดชอบ</th>
    </tr>
    <tr>
      <th>เลขที่</th>
      <th>หมู่</th>
      <th>บ้าน</th>
      <th>ตำบล</th>
      <th>อำเภอ</th>
      <th>จังหวัด</th>
      <th>เลขที่</th>
      <th>หมู่</th>
      <th>บ้าน</th>
      <th>ตำบล</th>
      <th>อำเภอ</th>
      <th>จังหวัด</th>
      <th>ไม่ป่วย</th>
      <th>อื่น(ระบุ)</th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <!-- <th>6</th> -->
      <th>วันที่เก็บ</th>
      <th>วันที่ส่ง</th>
      <th>neg</th>
      <th>รอผล</th>
    </tr>

  </thead>
  <tbody>
      <?php

      $sql="select * from risk_level order by risk_level_id desc";
      $obj=$connect->prepare($sql);
      $obj->execute();
      $rows_risk_level=$obj->fetchAll(PDO::FETCH_ASSOC);
      $i = 1;
      foreach ($rows as $key => $value) {
        ?>
        <tr>
            <td><?php echo $value['cut_datetime']; ?></td>
            <td><?php echo $value['register_datetime']; ?></td>
            <td><?php echo $i ?></td>
            <td><?php echo $value['fname']; ?></td>
            <td><?php echo $value['lname']; ?></td>
            <td></td>
            <td></td>
            <td><?php echo $value['occupation_name']; ?></td>
            <td></td>
            <td></td>
            <td><?php echo $value['moo_out_code']; ?></td>
            <td><?php echo $value['tambon_name_out']; ?></td>
            <td><?php echo $value['ampur_name_out']; ?></td>
            <td><?php echo $value['changwat_name_out']; ?></td>
            <td>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-telephone-fill" viewBox="0 0 16 16" stroke="blue" fill="yellow"
       fill-opacity="0.5" stroke-opacity="0.8">
  <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
</svg>
<?php echo $value['tel']; ?></td>
            <td><?php echo $value['date_to_sakonnakhon']; ?></td> 
            <td></td>
            <td></td>
            <td><?php echo $value['house_in_no']; ?></td>
            <td><?php echo $value['villno']; ?></td>
            <td><?php echo $value['villname']; ?></td>
            <td><?php echo $value['tambon_name_in']; ?></td> 
            <td><?php echo $value['ampur_name_in']; ?></td>
            <td><?php echo 'สกลนคร'; ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

            <td>
              <?php  
                switch ($value['occupation_id']='99' and ($value['changwat_in_code']<>'74' or $value['changwat_work_code']<>'74')) {
														case "1":
														echo "";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['occupation_id']<>'99' and ($value['changwat_in_code']='74' or $value['changwat_work_code']='74')) {
														case "2":
														echo "";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['occupation_id']='1' and ($value['changwat_in_code']='74' or $value['changwat_work_code']='74')) {
														case "3":
														echo "";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['occupation_id']='2' and ($value['changwat_in_code']='74' or $value['changwat_work_code']='74')) {
														case "4":
														echo "";
                            break;} 
              ?>
            </td>
            <td>
              <?php  
                switch ($value['occupation_id']<>'99' and ($value['changwat_in_code']='74' or $value['changwat_work_code']='74')) {
														case "5":
														echo "";
                            break;} 
              ?>
            </td>
            <!-- <td>
              <?php  
                switch ($value['risk_level_id']) {
														case "6":
														echo "/";
                            break;} 
              ?>
            </td> -->
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><?php echo $value['hospcode']; ?></td>
           
        </tr>
      <?php
      $i++;
    // if($_GET['type']=='new'){
    //   $sql_update="update covid_register set cut_status_id=1,cut_datetime='".$now_date_time."' where covid_register_id=".$value['covid_register_id']." and cut_status_id=0";    
    //   //echo "<br>sql_update=".$sql_update;
    //   $obj=$connect->prepare($sql_update);
    //   $obj->execute();
    //                         }
      } ?>
  </tbody>
</table>

<button  risk_level_id="<?php echo $_GET['risk_level_id']; ?>"  type_cut="<?php echo $_GET['type']; ?>" office_code="<?php echo $_SESSION['office_code']; ?>"  type="button" class="btn btn-primary btn_cut_print">ตัดข้อมูและส่งออกExcel</button>
    </main>
    <?php
      include("./footer.php");
    ?>
<div class="modal fade" id="modal01" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="modal01_body" style="margin-top:30px; margin-bottom: 30px;">
        ...
      </div>
      <div class="modal-footer" id="modal01_action" style="text-align: right;">
        <button type="button" class="btn btn-secondary" id="btnInsideModal" data-dismiss="modal">ตกลง</button>
      </div>
    </div>
  </div>
</div>

    <script src="../js/jquery-3.2.1.min.js" ></script>
    <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/tableToCards.js"></script>
    <script src='../js/table2excel.js'></script>
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
    <script type="text/javascript">
            var $btnDLtoExcel = $('.btn_cut_print');
            // var file_name= <?php $now_date_time; ?>
            // file_name=file_name.replaceAll('-','');
            // file_name=file_name.replaceAll(' ','');
            // file_name=file_name.replaceAll(':','');
            $btnDLtoExcel.on('click', function Export() {
              // $("#modal01_body").html('กำลังบันทึก .. กรุณารอซักครู่นะคะ');
              // $("#modal01_action").css({'display':'none'});
              // $("#modal01").modal('show');
            $.ajax({method: "POST", url: "ajaxCut.php",
              data: { 
                open_datetime: "<?php echo date("Y-m-d H:i:s"); ?>", 
                type_cut: $(this).attr("type_cut"),
                office_code: $(this).attr("office_code")
              }
              
            })
            .done(function(x) {
              //console.log(jQuery.parseJSON(x));
              $("#myTable").table2excel({
                          // filename: 'รายชื่อผู้แจ้งเข้าจังหวัด'+file_name+'.xls'
                          filename: 'รายชื่อผู้แจ้งเข้าจังหวัด'+'.xls'
                      });
            });

          
            // $.ajax({method: "POST", url: "cut_data_execute.php",
            //  data: {risk_level_id: $(this).attr("risk_level_id"),type_cut: $(this).attr("type_cut"),office_code:$(this).attr("office_code")}
            //   })
            //   .done(function(x) {
            //    console.log(x);

            //     });
            });



        </script>
  </body>
</html>
