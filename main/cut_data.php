<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

$sql_cut_data="SELECT
c.cut_datetime,
count(*) AS cut_all,
sum(
IF
( c.risk_level_id = 1, 1, 0 )) AS risk_level_1,
sum(
IF
( c.risk_level_id = 2, 1, 0 )) AS risk_level_2,
sum(
IF
( c.risk_level_id = 3, 1, 0 )) AS risk_level_3,
sum(
IF
( c.risk_level_id = 4, 1, 0 )) AS risk_level_4,
u.fname,
u.lname
FROM
covid_register_cut c 
left join user u on c.cut_user_id=u.user_id
GROUP BY
c.cut_datetime";
$obj=$connect->prepare($sql_cut_data);
$obj->execute();
$rows_cut_data=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows_cut_data);
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
    <div class="container">
        <h5>ประวัติการตัดข้อมูล</h5>
    </div>
    <table class="table" id="myTable">
    <thead>
        <tr>
        <th data-card-title>วันที่ตัดข้อมูล</th>
        <th>เสี่ยงสูง</th>
        <th>เสี่ยงปานกลาง</th>
        <th>เสี่ยงต่ำ</th>
        <th>ไม่เสี่ยง</th>      
        <th>รวม</th>  
        <th>ผู้ตัดข้อมูล</th>    
        <th data-card-footer></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($rows_cut_data as $key => $value) {
            ?>
            <tr>
                <td><?php echo $value['cut_datetime']; ?></td>
                <td><?php echo $value['risk_level_1']; ?></td>
                <td><?php echo $value['risk_level_2']; ?></td>
                <td><?php echo $value['risk_level_3']; ?></td>
                <td><?php echo $value['risk_level_4']; ?></td>
                <td><?php echo $value['cut_all']; ?></td>
                <td><?php echo $value['fname']." ".$value['lname']; ?></td>
                <td>
                    <button cut_datetime="<?php echo $value['cut_datetime']; ?>" type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>
                    <button cut_datetime="<?php echo $value['cut_datetime']; ?>" type="button" class="btn btn-info btn_cut_data_detail">รายละเอียด</button>
                </td>
            </tr>
            <?php
        }?>
    </tbody>
    </table>
</main>

<div id="forExcelExport" style="display: none;"></div>

<!-- FOOTER -->
<?php
include("./footer.php");
?>
<script src="../js/jquery-3.2.1.min.js" ></script>
<script>
  window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')
</script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/tableToCards.js"></script>
<script src='../js/table2excel.js'></script>
<script>
$(function(){
  $(".btn_cut_data_detail").click(function(){
      console.log($(this).attr("cut_datetime"));
      var form = $('<form action="./cut_data_detail.php" method="post"><input type="hidden" name="cut_datetime" value="' + $(this).attr("cut_datetime") + '"></input>' + '</form>');
      $('body').append(form);
      $(form).submit();                
  });

  $(".btn_cut_print").click(function() {
    //console.log('btn_cut_print----------');
    var file_name=$(this).attr('cut_datetime').toString();
    //console.log(file_name);
    file_name=file_name.replaceAll('-','');
    file_name=file_name.replaceAll(' ','');
    file_name=file_name.replaceAll(':','');
    //console.log(file_name);
    $.ajax({method: "POST", url: "ajaxExportCutData.php",
      data: {cut_datetime: $(this).attr("cut_datetime") }
    })
    .done(function(x) {
    // console.log(x);
      $("#forExcelExport").append(x);
      $("#forExcelExport").table2excel({
        filename: file_name+".xls"
      });

    });
  });   
})
</script>
      
</html>
