<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../include/config.php';
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title></title>

  <script src="../js/jquery-3.5.1.min.js"></script>
  <script type="text/javascript" src="../js/bootstrap.js"></script>
  <link href="../css/bootstrap.min.css" rel="stylesheet">

</head>


<body >
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="card" style="margin-bottom: 20px;">
      <div class="card-header">เลือกผลการคัดกรอง</div>
      <div class="card-body" style="padding: 0px; padding-left: 10px; padding-right: 10px;">

        <div class="form-group">
          <label for="exampleFormControlSelect1">การคัดกรอง <span class="required"></span></label>
          <select class="form-control" id="checkpoint_activity" name="checkpoint_activity">
            <option value="">--เลือก--</option>
  <?php
$sql = "select * from `checkpoint_activity` order by id asc ";
$obj = $connect->prepare($sql);
$obj->execute();
$rows = $obj->fetchAll(PDO::FETCH_ASSOC);
for ($i = 0; $i < count($rows); $i++) {
    echo "<option value='" . $rows[$i]["id"] . "'>" . $rows[$i]["checkpoint_activity_name"] . "</option>";
}
?>
</body>
</html>
