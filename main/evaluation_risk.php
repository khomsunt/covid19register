<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
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
$sql_report_risk="
SELECT
	r.risk_level_name,
	r.risk_level_id,
	count( * ) AS count_ampur_risk 
FROM
	ampur a
	LEFT JOIN risk_level r ON a.risk_status_id = r.risk_level_id 
GROUP BY
	a.risk_status_id
";
$obj=$connect->prepare($sql_report_risk);
$obj->execute();
$rows_report_risk=$obj->fetchAll(PDO::FETCH_ASSOC);
$risk_level_id = $rows_report_risk['risk_level_id'];
?>

<main role="main" style="margin-top:90px;">
    <div class="container">
        <h5>เกณฑ์การประเมินความเสี่ยง covid-19 รายบุคคล</h5>
    </div>
    <?php if ($_SESSION['group_id']>0){ ?>
    <img src="../image/covid_evaluate.png" class="rounded img-fluid" alt="...">
    <ul class="list-group">
      <?php foreach ($rows_report_risk as $key => $value) { ?>
      
        <div class="tag-link"  risk_level_id = "<?php echo $value['risk_level_id']; ?>" >
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo $value['risk_level_name']   ?>
          
            <span class="badge badge-primary badge-pill"><?php echo $value['count_ampur_risk']  ?></span>
          
        </li>
        </div>
        <?php } ?>
    </ul>


    
</main>
<?php } ?>
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
<script>

       $(function(){
            $(".tag-link").click(function(){
              console.log($(this).attr("risk_level_id"));
                if($(this).attr("risk_level_id")==0){ //เขียว
                  //console.log($(this).attr("risk_level_id"));
                  var form = $('<form action="./ampur_green.php" method="post"><input type="hidden" name="risk_level_id" value="' + $(this).attr("risk_level_id") + '"></input>' + '</form>');
                
                }else if($(this).attr("risk_level_id")==1){
                  //console.log($(this).attr("risk_level_id"));
                  var form = $('<form action="./ampur_yellow.php" method="post"><input type="hidden" name="risk_level_id" value="' + $(this).attr("risk_level_id") + '"></input>' + '</form>');
                
                }else if($(this).attr("risk_level_id")==2){
                 //console.log($(this).attr("risk_level_id"));
                  var form = $('<form action="./ampur_orange.php" method="post"><input type="hidden" name="risk_level_id" value="' + $(this).attr("risk_level_id") + '"></input>' + '</form>');
                
                }else{
                  //console.log(attr("risk_level_id"));
                  var form = $('<form action="./ampur_red.php" method="post"><input type="hidden" name="risk_level_id" value="' + $(this).attr("risk_level_id") + '"></input>' + '</form>');
                }
                $('body').append(form);
                $(form).submit(); 
            })
        })
      </script>
</html>
