<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');


$sql_current_cut="select ampur_name, a.ampur_code_full,
a.risk_status_id, r.risk_level_long_name, 
sum(t.total_tambon) total_tambon,
sum(t.total_risk_tambon0) as total_risk_tambon0,
sum(t.total_risk_tambon1) as total_risk_tambon1,
sum(t.total_risk_tambon2) as total_risk_tambon2,
sum(t.total_risk_tambon3) as total_risk_tambon3
from ampur a
LEFT JOIN 
(SELECT ampur_code_full,
count(tambon_code) as total_tambon ,
sum(if(risk_status_id='0',1,0)) as total_risk_tambon0,
sum(if(risk_status_id='1',1,0)) as total_risk_tambon1,
sum(if(risk_status_id='2',1,0)) as total_risk_tambon2,
sum(if(risk_status_id='3',1,0)) as total_risk_tambon3 
FROM tambon WHERE changwat_code = :changwat_code GROUP BY ampur_code_full) t on a.ampur_code_full = t.ampur_code_full
LEFT JOIN risk_level r on a.risk_status_id = r.risk_level_id
where a.changwat_code = :changwat_code
GROUP BY a.ampur_code_full";

// $sql_current_cut=" select a.ampur_code, a.ampur_name, a.ampur_code_full,
// a.risk_status_id, r.risk_level_long_name, count(tambon_code) as total_tambon 
// from ampur a
// LEFT JOIN tambon t on a.ampur_code_full = t.ampur_code_full
// LEFT JOIN risk_level r on a.risk_status_id = r.risk_level_id
// where a.changwat_code = :changwat_code
// GROUP BY a.ampur_code";
$obj=$connect->prepare($sql_current_cut);
$obj->execute(["changwat_code"=>$_POST['changwat_code']]);
$rows_current_cut=$obj->fetchAll(PDO::FETCH_ASSOC);
//print_r($rows_current_cut);
?>

<!doctype html>
<html lang="en">
  <head>
  <?php
    header("Cache-Control: private, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Ampur Risk</title>

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

<main role="main" style="margin-top:90px;">
<h5 style="text-align:center;">จังหวัด<?php echo $_POST['changwat_name']; ?></h5>
<br>
<table class="table" id="myTable">
  <thead>
    <tr>
      <th data-card-title style="text-align: center;">ลำดับ</th>
      <th data-card-title style="text-align: left;">ชื่ออำเภอ</th>
      <th style="text-align: center;">ตำบลทั้งหมด</th>
      <th style="text-align: center;">เสี่ยงต่ำมาก</th>
      <th style="text-align: center;">เสี่ยงต่ำ</th>
      <th style="text-align: center;">เสี่ยงปานกลาง</th>
      <th style="text-align: center;">เสี่ยงสูง</th>
      <th data-card-footer style="text-align: center;">รายละเอียด</th>
    </tr>
  </thead>
  <tbody>
      <?php
      //$sql="select * from risk_status";
      $sql="select * from risk_level where not risk_level_id ='99'  order by order_id asc ";
      $obj=$connect->prepare($sql);
      $obj->execute();
      $rows_ampur_risk=$obj->fetchAll(PDO::FETCH_ASSOC);

      $i = 0;
      foreach ($rows_current_cut as $key => $value) {
          ?>
        <tr>
            <td style="text-align: center;"><?php echo ++$i; ?></td>
            <td style="text-align: left;"><?php echo $value['ampur_name']; ?></td>
            <td style="text-align: center;"><?php echo $value['total_tambon'] ? $value['total_tambon'] :'0' ; ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_tambon0'] ? $value['total_risk_tambon0'] :'0' ; ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_tambon1'] ? $value['total_risk_tambon1'] :'0' ;  ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_tambon2'] ? $value['total_risk_tambon2'] :'0' ;  ?></td>
            <td style="text-align: center;"><?php echo $value['total_risk_tambon3'] ? $value['total_risk_tambon3'] :'0' ;  ?></td>
            <td style="text-align: center;">
                <div class="btn-group">
                    <button type="button" 
                      <?php if($value['risk_status_id']==0) { //เสี่ยงต่ำมาก ?> 
                          class="btn dropdown-toggle" style="background-color:#00FF00; color:#000000" 
                      <?php } else if($value['risk_status_id']==1) { //เสี่ยงต่ำ  ?>
                          class="btn dropdown-toggle" style="background-color:#FFFF00; color:#000000"
                      <?php } else if($value['risk_status_id']==2) { //เสี่ยงปานกลาง  ?>
                          class="btn dropdown-toggle" style="background-color:#FF8800; color:#FFFFFF"
                      <?php } else if($value['risk_status_id']==4) { //เสี่ยงสูง  ?>
                          class="btn dropdown-toggle" style="background-color:#F78181; color:#FFFFFF"
                      <?php } else {  //เสี่ยงสูงสุด ?>
                        class="btn dropdown-toggle" style="background-color:#DF0101; color:#FFFFFF"
                      <?php } ?>
                        data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                      <?php echo $value['risk_level_long_name']; ?>

                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                        <?php
                        foreach ($rows_ampur_risk as $key_risk_area => $value_area) {
                            ?>
                            <button ampur_code_full="<?php echo $value['ampur_code_full']; ?>" risk_status_id="<?php echo $value_area['risk_level_id']; ?>" class="dropdown-item btn-change-ampur-risk" type="button">
                                <?php echo $value_area['risk_level_long_name']; ?>
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
              <button changwat_code = "<?php echo $_POST['changwat_code']; ?>" changwat_name = "<?php echo $_POST['changwat_name']; ?>"  ampur_code_full = "<?php echo $value['ampur_code_full']; ?>"  ampur_name = "<?php echo $value['ampur_name']; ?>"  type="button" class="btn btn-primary tag-link">รายละเอียด</button>
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
            $(".tag-link").click(function(){
                console.log($(this).attr("changwat_code"));
                var form = $('<form action="./tambon_risk_detail.php" method="post"><input type="hidden" name="changwat_code" value="' + $(this).attr("changwat_code") + '"></input> <input type="hidden" name="changwat_name" value="' + $(this).attr("changwat_name") + '"></input><input type="hidden" name="ampur_name" value="' + $(this).attr("ampur_name") + '"></input> <input type="hidden" name="ampur_code_full" value="' + $(this).attr("ampur_code_full") + '"></input> ' + '</form>');
                $('body').append(form);
                $(form).submit(); 
            })
            $(".btn-change-ampur-risk").click(function(){ //เปลี่ยนสถานะ
                console.log($(this).attr("ampur_code_full"));
                $.ajax({
                    method: "POST",
                    url: "./change_risk_ampur.php",
                    data: { ampur_code_full: $(this).attr("ampur_code_full"),risk_status_id: $(this).attr("risk_status_id")}
                })
                .done(function( msg ) {
                  console.log(msg)
                  location.reload();
               })
            })
        })
      </script>
</html>
