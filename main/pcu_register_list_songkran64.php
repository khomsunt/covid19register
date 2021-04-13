<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
echo "<br>";
// print_r($_POST);
// print_r($_SESSION);
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
  r.cut_status_name,
  c.tel,
  r2.risk_level_long_name as evaluate_level_name
  from from_real_risk c 
  inner join from_real_risk_songkran64 s64 on s64.covid_register_id=c.covid_register_id
  left join changwat cw on c.changwat_out_code=cw.changwat_code 
  left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code
  left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code
  left join changwat cw2 on c.changwat_work_code=cw2.changwat_code 
  left join ampur a2 on c.changwat_work_code=a2.changwat_code and c.ampur_work_code=a2.ampur_code
  left join tambon t2 on c.changwat_work_code=t2.changwat_code and c.ampur_work_code=t2.ampur_code and c.tambon_work_code=t2.tambon_code
  left join ampur47 a47 on c.ampur_in_code=a47.ampur_code
  left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code
  left join coccupation o on c.occupation_id=o.occupation_id
  left join cut_status r on c.cut_status_id=r.cut_status_id
  left join risk_level r2 on c.real_risk=r2.risk_level_id
  left join prename p on c.prename_id=p.prename_id";
// if ($_SESSION['group_id']==3){
  $where="";
  if (isset($_POST['cid'])){
    $where.=" where c.hospcode='".$_SESSION['office_code']."' and (c.cid='".$_POST['cid']."' or c.fname like '%".$_POST['cid']."%') ";
  }else if($_SESSION['group_id']=='7'){
    //$where.=" where c.ampur_in_code='".$_SESSION['office_code']."'";
    $where.=" where c.ampur_in_code='".$_SESSION['ampur_code']."' ";
  }else{
    $where.=" where c.hospcode='".$_SESSION['office_code']."'";
  }
  if ($_GET['risk_level_id']!='undefined' & $_GET['risk_level_id']!=''){
    $where.=" and s64.real_risk=".$_GET['risk_level_id'];
  }
  $sql.=$where;
  
  // echo "<br><br><br>";
  // print_r($rows_count);

  $rp=10000000; //rows per page
  $sql_count="select count(c.covid_register_id) as count_all from from_real_risk c ";
  include("./autoPaginationFunction.php");



  $obj=$connect->prepare($sql);
  $obj->execute();
  $rows=$obj->fetchAll(PDO::FETCH_ASSOC);

  // echo "<br><br>POST=";
  // print_r($_POST);
  // echo "<br><br><br><br><br><br><br><br><br>".$sql;

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

      .modal {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('http://i.stack.imgur.com/FhHRx.gif') 
                    50% 50% 
                    no-repeat;
      }
      body.loading .modal {
          overflow: hidden;   
      }
      body.loading .modal {
          display: block;
      }
      


    </style>
    <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>

    <script src="../js/jquery-3.2.1.min.js" ></script>
    <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/tableToCards.js"></script>
</head>
<body>
<div class="modal"></div>
  <?php
    include("./header.php");
  ?>

      <div id="auto_table_title" style="padding: 10px; float:left; float:top; position:fixed; z-index:1000; background-color:#D3D3D3; width:100%;">
        <h5>
          <img alt="เรียกข้อมูลใหม่" class="img-refresh" src="../image/refresh.svg" style="width:25px;height:25px;cursor:pointer;"> 
          รายชื่อผู้เดินทางเข้า 
          <?php echo decodeCode('office',$_SESSION['office_code'],'office_code','office_name'); ?>
        </h5>
        <div>
          <div class="input-group">
            <input id="cid" type="text" class="form-control" placeholder="เลขประจำตัวประชาชน" aria-label="เลขประจำตัวประชาชน" aria-describedby="basic-addon2" value="<?php echo $_POST['cid']; ?>">
            <div class="input-group-append">
              <button class="btn btn-outline-secondary btn-info btn-cid-search" type="button" style="color:#000000">ค้นหา</button>
            </div>
          </div>        
        </div>
      </div>
      <div id="register_div" class="container" style="display:none;">
        <div style="width:100%;text-align:right;">
          <button style="float-right" id= "btn-close-register">x</button>
        </div>
        <iframe id="register" frameborder="0" src="./register.php" title="" style="width:100%;height:100%"></iframe>
      </div>
      <?php
      include("./autoPagination.php");
      ?>

    <main role="main">

      <div id="divMyTable">
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
            <th>สถานะ</th>
            <th>วันที่แจ้งมาถึงสกลนคร</th>  
            <th>วันที่แจ้งออกจากสกลนคร</th>  
            <th>วันที่มาถึงสกลนครจริง</th>  
            <th>วันที่ออกจากสกลนครจริง</th>  
            <th>สถานะข้อมูล</th>
            <th data-card-footer>โทรศัพท์</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql="select * from cut_status order by cut_status_id";
          $obj=$connect->prepare($sql);
          $obj->execute();
          $rows_cut_status=$obj->fetchAll(PDO::FETCH_ASSOC);
          foreach ($rows as $key => $value) {
            ?>
            <tr id="<?php echo $value['covid_register_id'] ?>">
              <td>
                <span class="badge badge-info" style="background-color:<?php echo $value['background_color']; ?>;color:<?php echo $value['color']; ?>;"><?php echo $start+$key+1; ?>.</span>
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
              <td><div class="data"><?php echo $value['evaluate_level_name']; ?></div></td>
              <td>
                <div class="data">
                  <?php echo $value['date_to_sakonnakhon']; ?>
                </div>
              </td>
              <td>
                <div class="data">
                  <?php echo $value['date_out_sakonnakhon']; ?>
                </div>
              </td>
              <td>
                <div class="data date_arrived_sakonnakhon_<?php echo $value['covid_register_id']; ?>">
                  <?php echo $value['date_arrived_sakonnakhon']; ?>
                </div>
                <div class="data select_date_arrived_sakonnakhon_<?php echo $value['covid_register_id']; ?>" style="display:none">
                  <input name="date_arrived_sakonnakhon" class="form-control datepicker" id="date_arrived_sakonnakhon_<?php echo $value['covid_register_id']; ?>" value="<?php echo deFormatDate(($value['date_arrived_sakonnakhon'])?$value['date_arrived_sakonnakhon']:$value['date_to_sakonnakhon']); ?>"/>
                </div>
              </td>
              <td>
                <div class="data date_leaved_sakonnakhon_<?php echo $value['covid_register_id']; ?>">
                  <?php echo $value['date_leaved_sakonnakhon']; ?>
                </div>
                <div class="data select_date_leaved_sakonnakhon_<?php echo $value['covid_register_id']; ?>" style="display:none">
                  <input name="date_leaved_sakonnakhon" class="form-control datepicker" id="date_leaved_sakonnakhon_<?php echo $value['covid_register_id']; ?>" value="<?php echo deFormatDate(($value['date_leaved_sakonnakhon'])?$value['date_leaved_sakonnakhon']:$value['date_out_sakonnakhon']); ?>"/>
                </div>
              </td>
              <td>
                <div class="data cut_status_id_<?php echo $value['covid_register_id']; ?>" ><?php echo $value['cut_status_name']; ?></div>
                <div class="btn-group select_cut_status_id_<?php echo $value['covid_register_id']; ?>" style="display:none">
                  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false" style="background-color:<?php echo $value['background_color']; ?>;color:<?php echo $value['color']; ?>;">
                    <?php echo $value['cut_status_name']; ?>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                    <?php
                      foreach ($rows_cut_status as $key => $value_cut_status) {
                        if ($value_cut_status['cut_status_id']<>$value['cut_status_id']){
                          ?>
                          <button covid_register_id="<?php echo $value['covid_register_id']; ?>" cut_status_id="<?php echo $value_cut_status['cut_status_id']; ?>" class="dropdown-item btn-change-cut-status" type="button">
                            <?php echo $value_cut_status['cut_status_name']; ?>
                          </button>
                          <?php
                        }
                      }
                    ?>
                  </div>
                </div>
              </td>
              <td>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-telephone-fill" viewBox="0 0 16 16" stroke="blue" fill="yellow"
        fill-opacity="0.5" stroke-opacity="0.8">
                  <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
                </svg>
                <?php echo $value['tel']; ?>
                <span class="float-right">
                  <button cut_status_id="<?php echo $value['cut_status_id']; ?>" covid_register_id="<?php echo $value['covid_register_id']; ?>" type="button" class='btn btn-secondary btn-edit btn_edit_<?php echo $value['covid_register_id']; ?>'>ป้อนข้อมูล</button>
                  <button covid_register_id="<?php echo $value['covid_register_id']; ?>" type="button" class='btn btn-primary btn-save btn_save_<?php echo $value['covid_register_id']; ?>' style="display:none;">บันทึก</button>
                  <button covid_register_id="<?php echo $value['covid_register_id']; ?>" type="button" class='btn btn-danger btn-cancel btn_cancel_<?php echo $value['covid_register_id']; ?>' style="display:none;">ยกเลิก</button>
                </span>
              </td>
            </tr>
          <?php
          } ?>
        </tbody>
      </table>
      </div>
    </main>
    <?php
      include("./footer.php");
    ?>
    
    <script>
      $body = $("body");
      var cut_status_id_default=0;
      function close_iframe(){
        $("#register_div").hide();
        $(".auto-pagination").show();
        $("#register").attr("src","./register.php");
      }
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
      function deFormatDate(d) {
        var r="";
        if (typeof d !='undefined') {
          if (d.length>0) {
            var x=d.split("-");
            r=x[0]+"/"+x[1]+"/"+x[2];
          }
        }
        return r;
      }

      var headerHeight=0;
      var autoTableTitleHeight=0;
      var autoPaginationHeight=0;
      $(function () {
          headerHeight=$("#topbar_menu").outerHeight();
          $("#auto_table_title").offset({top: headerHeight});
          autoTableTitleHeight=$("#auto_table_title").outerHeight();
          autoPaginationHeight=$("#auto_pagination").outerHeight(true);
          $("#auto_pagination").css("margin-top",headerHeight+autoTableTitleHeight);
          $("#divMyTable").css("margin-top",(headerHeight+autoTableTitleHeight+autoPaginationHeight)+"px");
          //alert(headerHeight+autoTableTitleHeight+autoPaginationHeight+20);
          $("#register_div").hide();
        $(".auto-pagination").show();
        



        $('.datepicker').datepicker({
          // startDate: '+0d',
          format: 'dd/mm/yyyy',
          todayBtn: false,
          language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
          // thaiyear: true, //Set เป็นปี พ.ศ.
          autoclose: true
        });

        $(".btn-edit").click(function(){
          cut_status_id_default=$(this).attr("cut_status_id");
          let thisId=$(this).attr("covid_register_id");
          $(this).parent().find(".btn-edit").hide();
          $(this).parent().find(".btn-save").show();
          $(this).parent().find(".btn-cancel").show();

          $(".cut_status_id_"+thisId).hide();
          $(".select_cut_status_id_"+thisId).show();
          $(".date_arrived_sakonnakhon_"+thisId).hide();
          $(".select_date_arrived_sakonnakhon_"+thisId).show();
          $(".date_leaved_sakonnakhon_"+thisId).hide();
          $(".select_date_leaved_sakonnakhon_"+thisId).show();
        })
        $(".btn-save").click(function(){
          let thisId=$(this).attr("covid_register_id");
          $(this).parent().find(".btn-edit").show();
          $(this).parent().find(".btn-save").hide();
          $(this).parent().find(".btn-cancel").hide();
          if ($(".btn-change-cut-status").parent().parent().parent().parent().parent().parent().parent().parent().length==1){
          }else{
            $("#date_arrived_sakonnakhon_"+thisId).remove();
            $("#date_leaved_sakonnakhon_"+thisId).remove();
          }
          console.log($("#date_arrived_sakonnakhon_"+thisId).val());
          console.log($("#date_leaved_sakonnakhon_"+thisId).val());
          console.log({ covid_register_id: thisId, cut_status_id: cut_status_id_default });

          $.ajax({
            method: "POST",
            url: "./pcu_changeRiskLevel.php",
            data: { date_arrived_sakonnakhon: formatDate($("#date_arrived_sakonnakhon_"+thisId).val()),date_leaved_sakonnakhon: formatDate($("#date_leaved_sakonnakhon_"+thisId).val()), covid_register_id: thisId, cut_status_id: cut_status_id_default }
          })
          .done(function( msg ) {
            console.log(msg);
            // if (thisObj.parent().parent().parent().parent().parent().parent().parent().attr('id')=='myTable'){
            //   thisObj.parent().parent().parent().parent().parent().hide();
            // }else{
            //   thisObj.parent().parent().parent().parent().parent().parent().parent().hide();
            // }
            // console.log(msg);
            location.reload();
          })



          $(".cut_status_id_"+thisId).show();
          $(".select_cut_status_id_"+thisId).hide();
          $(".date_arrived_sakonnakhon_"+thisId).show();
          $(".select_date_arrived_sakonnakhon_"+thisId).hide();
          $(".date_leaved_sakonnakhon_"+thisId).show();
          $(".select_date_leaved_sakonnakhon_"+thisId).hide();

        })
        $(".btn-cancel").click(function(){
          let thisId=$(this).attr("covid_register_id");
          $(this).parent().find(".btn-edit").show();
          $(this).parent().find(".btn-save").hide();
          $(this).parent().find(".btn-cancel").hide();

          $(".cut_status_id_"+thisId).show();
          $(".select_cut_status_id_"+thisId).hide();
          $(".date_arrived_sakonnakhon_"+thisId).show();
          $(".select_date_arrived_sakonnakhon_"+thisId).hide();
          $(".date_leaved_sakonnakhon_"+thisId).show();
          $(".select_date_leaved_sakonnakhon_"+thisId).hide();
        })
        $("#btn-close-register").click(function(){
          close_iframe();
        })
        $(".btn-cid-search").click(function(){
          $body.addClass("loading");
          var thisObj=$(this);
          $.ajax({
            method: "POST",
            url: "./pcu_cid_search.php",
            data: { cid: $("#cid").val() }
          })
          .done(function( msg ) {
            console.log(msg);
            $body.removeClass("loading");
            let json_data=JSON.parse(msg);
            if (json_data.data.length>0){
              if (json_data.dataSource=='covid'){
                var form = $('<form action="./pcu_register_list.php?<?php echo $strqry; ?>0" method="post"><input type="hidden" name="cid" value="' + $("#cid").val() + '"></input>' + '</form>');
                $('body').append(form);
                $(form).submit();                
              }else{
                let r=confirm("ไม่พบข้อมูลในฐานโควิด แต่พบข้อมูลในฐาน HDC ต้องการลงทะเบียนรายงานเข้าสกลนครหรือไม่");
                if (r==true){
                  $("#register").contents().find("input").val("");
                  $("#register").contents().find("select").val("");
                  let thisData=json_data.data[0];
                  $("#divMyTable").hide();
                  $("#register_div").show();
                  $(".auto-pagination").hide();
                  $("#register").contents().find('#cid').val(thisData['CID']);
                  $("#register").contents().find('#fname').val(thisData['NAME']);
                  $("#register").contents().find('#lname').val(thisData['LNAME']);
                  $("#register").contents().find('#tel').val(thisData['MOBILE']);
                  $("#register").contents().find('#ampur_in_code').val(thisData['AMPUR']);
                  document.getElementById("register").contentWindow.ampurInCodeChange('47'+thisData['AMPUR'],thisData['TAMBON']);
                  document.getElementById("register").contentWindow.tambonInCodeChange('47'+thisData['AMPUR']+thisData['TAMBON'],thisData['VILLAGE']);
                  $("#register").contents().find('#house_in_no').val(thisData['HOUSE']);
                }
              }
            }else{
              let r=confirm('ไม่พบข้อมูลที่ต้องการค้นหา ต้องการลงทะเบียนรายงานเข้าสกลนครหรือไม่');
              if (r==true){
                $("#register").contents().find("input").val("");
                $("#register").contents().find("select").val("");
                $("#divMyTable").hide();
                $("#register_div").show();
                $(".auto-pagination").hide();
                $("#register").contents().find('#cid').val($("#cid").val());

              }
            }
          });
        });
        $(".btn-change-cut-status").click(function(){
          var thisObj=$(this);
          cut_status_id_default=thisObj.attr("cut_status_id");
          console.log(thisObj.parent().parent().children().first());
          thisObj.parent().parent().children().first().html(thisObj.html());
          // $.ajax({
          //   method: "POST",
          //   url: "./changeRiskLevel.php",
          //   data: { covid_register_id: thisObj.attr("covid_register_id"), cut_status_id: thisObj.attr("cut_status_id") }
          // })
          // .done(function( msg ) {
          //   // if ($(".btn-change-cut-status").parent().parent().parent().parent().parent().parent().parent().attr('id')=='myTable'){
          //   //   thisObj.parent().parent().parent().parent().parent().hide();
          //   // }else{
          //   //   thisObj.parent().parent().parent().parent().parent().parent().parent().hide();
          //   // }
          //   console.log(msg)
          // })
        })
        $(".img-refresh").click(function(){
          location.reload();
        })
      })
    </script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>

  </body>
</html>

<?php 
function deFormatDate($d){
  $_return="";
  if ($d<>""){
    $a_d=explode("-",$d);
    $_return=$a_d[2]."/".$a_d[1]."/".$a_d[0];
  }
  return $_return;
}
?>
