<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

$sql_current_cut=" SELECT t.*, r.* from tambon t
LEFT JOIN risk_level r on t.risk_status_id = r.risk_level_id
where ampur_code_full =".$_POST['ampur_code_full'];

$obj=$connect->prepare($sql_current_cut);
$obj->execute(["changwat_code"=>$_POST['changwat_code']]);
$rows_current_cut=$obj->fetchAll(PDO::FETCH_ASSOC);
//print_r($rows_current_cut);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Tambon Risk Detail</title>

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
<br>
<h5 style="text-align:center;">จังหวัด<?php echo $_POST['changwat_name']; ?></h5>
<!-- <h5 style="text-align:center;">รหัส<?php echo $_POST['changwat_code']; ?></h5> -->
<h5 style="text-align:center;">อำเภอ<?php echo $_POST['ampur_name']; ?></h5>
<!-- <h5 style="text-align:center;">รหัส<?php echo $_POST['ampur_code_full']; ?></h5> -->
<table class="table" id="myTable">
  <thead>
    <tr>
      <th data-card-title>ชื่อตำบล</th>
      <th>สถานะ</th>

    </tr>
  </thead>
  <tbody>
      <?php
      //$sql="select * from risk_status";
      $sql="select * from risk_level where not risk_level_id ='99'  order by risk_level_id asc ";
      $obj=$connect->prepare($sql);
      $obj->execute();
      $rows_risk=$obj->fetchAll(PDO::FETCH_ASSOC);

      foreach ($rows_current_cut as $key => $value) {
          ?>
            <tr>
            <td><?php echo $value['tambon_name']; ?></td>
            <td>
            <div class="btn-group">
                    <button type="button" 
                    <?php if($value['risk_status_id']==0) { //เสี่ยงต่ำมาก ?> 
                          class="btn dropdown-toggle" style="background-color:#00FF00; " 
                      <?php } else if($value['risk_status_id']==1) { //เสี่ยงต่ำ  ?>
                          class="btn dropdown-toggle" style="background-color:#FFFF00; "
                      <?php } else if($value['risk_status_id']==2) { //เสี่ยงปานกลาง  ?>
                          class="btn dropdown-toggle" style="background-color:#FF8800; color:#FFFFFF"
                      <?php } else {  //เสี่ยงสูง ?>
                        class="btn dropdown-toggle" style="background-color:#FF0000; color:#FFFFFF"
                      <?php } ?>
                        data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                      <?php echo $value['risk_level_long_name']; ?>
                      
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                        <?php
                        foreach ($rows_risk as $key_risk_area => $value_area) {
                            ?>
                            <button tambon_code_full="<?php echo $value['tambon_code_full']; ?>" risk_status_id="<?php echo $value_area['risk_level_id']; ?>" class="dropdown-item btn-change-area" type="button">
                                <?php echo $value_area['risk_level_long_name']; ?>
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </td>
        </tr>
        <?php
        
    }?>
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
            $(".btn-change-area").click(function(){ //เปลี่ยนสถานะ
                console.log($(this).attr("tambon_code_full"));
                $.ajax({
                    method: "POST",
                    url: "./change_risk_tambon.php",
                    data: { tambon_code_full: $(this).attr("tambon_code_full"),risk_status_id: $(this).attr("risk_status_id")}
                })
                .done(function( msg ) {
                  console.log(msg)
                  location.reload();
               })
            })
            $(".btn-add-area").click(function(){ //เพิ่มสถานที่
                console.log($(this).attr("changwat_code"));
                var form = $('<form action="./add_area.php" method="post"><input type="hidden" name="changwat_code" value="' + $(this).attr("changwat_code") + '"></input> <input type="hidden" name="changwat_name" value="' + $(this).attr("changwat_name") + '"></input>'  + '</form>');
                $('body').append(form);
                $(form).submit(); 
            })
        })
      </script>
</html>
