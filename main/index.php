<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// if ($_SESSION['group_id']<=0){
//   header("Location: ./login.php");
// }
// print_r($_SESSION);
include('../include/config.php');
include('../include/functions.php');

$sql_common="select 
    c.risk_level_id,
    r.risk_level_long_name,
    r.risk_level_name,
    count(c.covid_register_id) as count_risk_level 
    from 
    covid_register c 
    left join risk_level r on c.risk_level_id=r.risk_level_id 
    left join ampur47 a on c.ampur_in_code=a.ampur_code ";
switch ($_SESSION['group_id']) {
  case 1:
  case 2:
  case 4:
  case 5:
    $sql=$sql_common."
      where 
      cut_status_id=0 
      group by 
      c.risk_level_id";
    $sql_all=$sql_common."
      group by
      c.risk_level_id";
    break;
  case 3:
    $sql=$sql_common."
      where 
      cut_status_id=0 
      and a.node_id=:user_node_id 
      group by 
      c.risk_level_id";
    $sql_all=$sql_common."
      where 
      a.node_id=:user_node_id 
      group by
      c.risk_level_id";
    break;
  default:
    # code...
    break;
}
// echo "<br>sql=".$sql;
$obj=$connect->prepare($sql);
$obj->execute([ 'user_node_id' => $_SESSION['node_id'] ]);
$rows_risk_level=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows_risk_level);
// echo "<br>sql_all=".$sql_all;
$obj=$connect->prepare($sql_all);
$obj->execute([ 'user_node_id' => $_SESSION['node_id'] ]);
$rows_risk_level_all=$obj->fetchAll(PDO::FETCH_ASSOC);

// print_r($rows_risk_level_all);
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

    <!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">

    <style>
      .btn-orange, .btn-orange:hover, .btn-orange:active, .btn-orange:visited {
          background-color: #FF8800 !important;
      }    
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
    <!-- Custom styles for this template -->
    <link href="../css/carousel.css" rel="stylesheet">
  </head>
  <body>
<?php
include("./header.php");
?>
<main role="main" style="margin-top:20px;">

  <!-- <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#777"/></svg>
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Example headline.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#777"/></svg>
        <div class="container">
          <div class="carousel-caption">
            <h1>Another example headline.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img"><rect width="100%" height="100%" fill="#777"/></svg>
        <div class="container">
          <div class="carousel-caption text-right">
            <h1>One more for good measure.</h1>
            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div> -->


  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

  <div class="container marketing">
      <?php
        // print_r($_SESSION);
        if (($_SESSION['node_id']>0) and ($_SESSION['group_id']==3)){
        ?>
        <center>
        <h5>ข้อมูลการรายงานตัวเข้าสกลนคร</h5>
        <h5>Node <?php echo decodeCode('node',$_SESSION['node_id'],'node_id','node_name'); ?></h5>
        </center>
        <?php
      }?>
    <!-- Three columns of text below the carousel -->
    <div class="row">
      <?php
      if ($_SESSION['group_id']>0){
      ?>
      <div class="col-lg-4">
        <?php
          $count_rows_risk_level=0;
          foreach ($rows_risk_level as $key=>$value){
            $count_rows_risk_level+=$value['count_risk_level'];
          }
        ?>
        <h5>ข้อมูลใหม่ <span class="badge badge-primary"><?php echo $count_rows_risk_level; ?></span></h5>
        <?php
        $sql="select * from risk_level order by risk_level_id desc";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
        // print_r($rows);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value=0;
            foreach ($rows_risk_level as $key=>$value){
                if ($rows_value['risk_level_id']==$value['risk_level_id']){
                    $this_value=$value['count_risk_level'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left btn-risk-level" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?> 
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
        } ?>
      </div><!-- /.col-lg-4 -->

      <div class="col-lg-4">
      <?php
          $count_rows_risk_level_all=0;
          foreach ($rows_risk_level_all as $key=>$value){
            $count_rows_risk_level_all+=$value['count_risk_level_all'];
          }
        ?>
        <h5>ข้อมูลสะสม <span class="badge badge-primary"><?php echo $count_rows_risk_level; ?></span></h5>
        <?php
        $sql="select * from risk_level order by risk_level_id desc";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $rows_key => $rows_value) {
            $this_value=0;
            foreach ($rows_risk_level_all as $key=>$value){
                if ($rows_value['risk_level_id']==$value['risk_level_id']){
                    $this_value=$value['count_risk_level'];
                    break;
                }
            }
            ?>
            <button risk_level_id="<?php echo $rows_value['risk_level_id']; ?>" type="button" class="btn btn-primary btn-lg btn-block text-left btn-risk-level-all" style="background-color:<?php echo $rows_value['background_color']; ?>;color:<?php echo $rows_value['color']; ?>;">
                <?php echo $rows_value['risk_level_long_name']; ?> 
                <span class="badge badge-light float-right"><?php echo $this_value; ?></span>
            </button>
            <?php
        } ?>

      </div><!-- /.col-lg-4 -->
      <?php 
      } ?>

      <!-- <div class="col-lg-4">
        <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>
        <h2>Heading</h2>
        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <!-- <div class="col-lg-4">
        <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title><rect width="100%" height="100%" fill="#777"/><text x="50%" y="50%" fill="#777" dy=".3em">140x140</text></svg>
        <h2>Heading</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details &raquo;</a></p>
      </div>/.col-lg-4 -->
    </div><!-- /.row -->


    <!-- START THE FEATURETTES -->

    <!-- <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It’ll blow your mind.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7 order-md-2">
        <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5 order-md-1">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
        <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
      </div>
      <div class="col-md-5">
        <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
      </div>
    </div>

    <hr class="featurette-divider"> -->

    <!-- /END THE FEATURETTES -->

  </div><!-- /.container -->


  <!-- FOOTER -->
  <?php
  include("./footer.php");
  ?>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
      <script src="../js/tableToCards.js"></script>
      <script>
        $(function(){
            $(".btn-risk-level").click(function(){
                console.log($(this).attr("risk_level_id"));
                window.location = './MyCovid19register.php?type=new&risk_level_id=' + $(this).attr("risk_level_id");
            })
            $(".btn-risk-level-all").click(function(){
                console.log($(this).attr("risk_level_id"));
                window.location = './MyCovid19register.php?type=all&risk_level_id=' + $(this).attr("risk_level_id");
            })
        })
      </script>

</html>
