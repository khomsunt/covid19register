<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

// $sql_cut_data="SELECT
// c.cut_datetime,
// count(*) AS cut_all,
// sum(
// IF
// ( c.risk_level_id = 1, 1, 0 )) AS risk_level_1,
// sum(
// IF
// ( c.risk_level_id = 2, 1, 0 )) AS risk_level_2,
// sum(
// IF
// ( c.risk_level_id = 3, 1, 0 )) AS risk_level_3,
// sum(
// IF
// ( c.risk_level_id = 4, 1, 0 )) AS risk_level_4 
// FROM
// covid_register_cut c 
// GROUP BY
// c.cut_datetime";
// $obj=$connect->prepare($sql_cut_data);
// $obj->execute();
// $rows_cut_data=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows_cut_data);

$sql_current_cut="select r.*, s.* from risk_area r
left JOIN `status` s on r.status_id = s.status_id
where r.changwat_code = :changwat_code;
";
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
<h5>จังหวัด<?php echo $_POST['changwat_name']; ?></h5>
<h5>รายชื่อกลุ่มเสี่ยงประจำวันที่ <?php echo $_POST['changwat_code']; ?></h5>
<table class="table" id="myTable">
  <thead>
    <tr>
      <th data-card-title>ชื่อสถานที่</th>  
      <th>วันที่เริ่มระบาด</th>
      <th>วันที่ระบาดล่าสุด</th>
      <th>สถานะ</th>

    </tr>
  </thead>
  <tbody>
      <?php
      $sql="select * from status";
      $obj=$connect->prepare($sql);
      $obj->execute();
      $rows_risk_area=$obj->fetchAll(PDO::FETCH_ASSOC);

      foreach ($rows_current_cut as $key => $value) {
          ?>
            <tr>
            <td><?php echo $value['area_name']; ?></td>
            <td><?php echo $value['risk_start_datetime']; ?></td>
            <td><?php echo $value['risk_last_datetime']; ?></td>
            <td>
            <span class="float-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                        <?php echo $value['status_name']; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                        <?php
                        foreach ($rows_risk_area as $key_risk_area => $value_area) {
                            ?>
                            <button risk_area_id="<?php echo $value['risk_area_id']; ?>" status_id="<?php echo $value_area['status_id']; ?>" class="dropdown-item btn-change-area" type="button">
                                <?php echo $value_area['status_name']; ?>
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </span>
            </td>
        </tr>
        <?php
        
    }?>
  </tbody>
</table>
<button type="button" class="btn btn-success">Success</button>
      
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
            $(".btn-change-area").click(function(){
                console.log($(this).attr("risk_area_id"));
                $.ajax({
                    method: "POST",
                    url: "./change_risk_area.php",
                    data: { risk_area_id: $(this).attr("risk_area_id"),status_id: $(this).attr("status_id")}
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
