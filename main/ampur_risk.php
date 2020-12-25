<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

$sql_current_cut=" select a.ampur_code, a.ampur_name, a.ampur_code_full, 
count(tambon_code) as total_tambon from ampur a
LEFT JOIN tambon t on a.ampur_code_full = t.ampur_code_full
where a.changwat_code = :changwat_code
GROUP BY a.ampur_code";
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

<main role="main" style="margin-top:60px;">
<h5 style="text-align:center;">จังหวัด<?php echo $_POST['changwat_name']; ?></h5>
<br>
<table class="table" id="myTable">
  <thead>
    <tr>
      <th data-card-title>ชื่ออำเภอ</th>  
      <!-- <th>รวม</th> -->
      <th>รวมตำบล</th>
      <th data-card-footer>รายละเอียด</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($rows_current_cut as $key => $value) {
          ?>
        <tr>
            <td><?php echo $value['ampur_name']; ?></td>
            <td><?php echo $value['total_tambon']; ?></td>
            <td>
              <button type="button" class="btn btn-danger">ระบาด</button>
              <button changwat_code = "<?php echo $_POST['changwat_code']; ?>" changwat_name = "<?php echo $_POST['changwat_name']; ?>"  ampur_code_full = "<?php echo $value['ampur_code_full']; ?>"  ampur_name = "<?php echo $value['ampur_name']; ?>"  type="button" class="btn btn-warning tag-link">รายละเอียด</button>
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
        })
      </script>
</html>
