<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

$sql_report_risk="SELECT
a.ampur_code,
a.ampur_name,
a.node_id,
sum(if(c.evaluate_level=0,1,0)) as green,
sum(if(c.evaluate_level=1,1,0)) as yellow,
sum(if(c.evaluate_level=2,1,0)) as orange,
sum(if(c.evaluate_level=3,1,0)) as red,
sum(if(c.evaluate_level=99,1,0)) as gray,
count(c.covid_register_id) as all_color
FROM
covid_register c
left join ampur47 a on c.ampur_in_code = a.ampur_code
GROUP BY
a.ampur_code";
$obj=$connect->prepare($sql_report_risk);
$obj->execute();
$rows_report_risk=$obj->fetchAll(PDO::FETCH_ASSOC);
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
        <h5>รายงานข้อมูลกลุ่มเสี่ยงแยกตามอำเภอ</h5>
    </div>
    <table class="table" id="myTable">
    <thead>
        <tr>
        <th>ลำดับที่</th>
        <th>ชื่ออำเภอ</th>
        <th>Node </th>
        <th>สีเขียว</th>
        <th>สีเหลือง</th>
        <th>สีส้ม</th>      
        <th>สีแดง</th>  
        <th>สีเทา</th>  
        <th>จำนวนทั้งหมด</th>  
       
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($rows_report_risk as $key => $value) 
        {
            ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $value['ampur_name']; ?></td>
                <td><?php echo $value['node_id']; ?></td>
                <td><?php echo $value['green']; ?></td>
                <td><?php echo $value['yellow']; ?></td>
                <td><?php echo $value['orange']; ?></td>
                <td><?php echo $value['red']; ?></td>
                <td><?php echo $value['gray']; ?></td>
                <td><?php echo $value['all_color']; ?></td>
                <!--<td>
                    <button cut_datetime="<?php echo $value['cut_datetime']; ?>" type="button" class="btn btn-primary btn_cut_print">ส่งออก</button>
                    <button cut_datetime="<?php echo $value['cut_datetime']; ?>" type="button" class="btn btn-info btn_cut_data_detail">รายละเอียด</button>
                </td>-->
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
