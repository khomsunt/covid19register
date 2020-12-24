<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

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
<h5 style="text-align:center;">จังหวัด<?php echo $_POST['changwat_name']; ?></h5>
<h5 style="text-align:center;">รหัสจังหวัด <?php echo $_POST['changwat_code']; ?></h5>
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
    <div class="container">
      <div class="row">
        <div class="col text-center">
          <button type="button" class="btn btn-success btn-add-area" changwat_code = "<?php echo $_POST['changwat_code']; ?>">เพิ่มสถานที่</button>
        </div>
      </div>
    </div>
      
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
                console.log($(this).attr("risk_area_id"));
                $.ajax({
                    method: "POST",
                    url: "./change_risk_area.php",
                    data: { risk_area_id: $(this).attr("risk_area_id"),status_id: $(this).attr("status_id")}
                })
                .done(function( msg ) {
                  console.log(msg)
                  location.reload();
               })
            })
            $(".btn-add-area").click(function(){ //เพิ่มสถานที่
                console.log($(this).attr("changwat_code"));
                var form = $('<form action="./add_area.php" method="post"><input type="hidden" name="changwat_code" value="' + $(this).attr("changwat_code") + '"></input>' + '</form>');
                $('body').append(form);
                $(form).submit(); 
            })
        })
      </script>
</html>
