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

$sql_current_cut=" select c.*, count(a.ampur_code) as ampur_total from changwat c
LEFT JOIN ampur a on c.changwat_code = a.changwat_code
GROUP BY a.changwat_code";
$obj=$connect->prepare($sql_current_cut);
$obj->execute();
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
    <title>Changwat Risk</title>

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
<table class="table" id="myTable">
  <thead>
    <tr>
      <th data-card-title>จังหวัด</th>  
      <!-- <th>รวม</th> -->
      <th>รวมอำเภอ</th>
      <th data-card-footer>รายละเอียด</th>
    </tr>
  </thead>
  <tbody>
      <?php
      foreach ($rows_current_cut as $key => $value) {
          ?>
        <tr>
            <td><?php echo $value['changwat_name']; ?></td>
            <td><?php echo $value['ampur_total']; ?></td>
            <td>
              <button changwat_code = "<?php echo $value['changwat_code']; ?>" changwat_name = "<?php echo $value['changwat_name']; ?>"  type="button" class="btn btn-info tag-link">รายละเอียด</button>
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
                var form = $('<form action="./ampur_risk.php" method="post"><input type="hidden" name="changwat_code" value="' + $(this).attr("changwat_code") + '"></input> <input type="hidden" name="changwat_name" value="' + $(this).attr("changwat_name") + '"></input>' + '</form>');
                $('body').append(form);
                $(form).submit(); 
            })
        })
      </script>
</html>
