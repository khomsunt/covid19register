<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูลผู้ใช้งาน</title>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/content/tables/">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'th sarabunpsk';
      }
      
      h1 {
        top: 20px;
        font-size: 36px;
        color: #000000;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 1000;
      }

      table {
        border-collapse: collapse;
        background-color: #FFFFFF;
        box-shadow: 0 10px 20px 0 rgba(0, 0, 0, 0.03);
        border-radius: 10px;
        margin: auto;
      }

      th, td {
        border: 1px solid #f2f2f2;
        padding: 8px 30px;
        text-align: center;
        color: grey;
      }

      th {
        color: #000000;
        font-weight: 1000;
      }

      thead {
        background-color: lime;
      }

      tr {
        color: black;
      }

      td,tr {
        font-weight: 600;
        font-size: 24px;
        color: #000000;
      }
      
      .content {
        background-color: aqua;
      }

    </style>

</head>
<body>

<script>
  $.ajax({
    method: "POST",
    url: "ajaxTest.php",
    data:""
  }).done(function(x){
    console.log(x);
    var xdata=jQuery.parseJSON(x);
    console.log(xdata);
  });
</script>

<?php
  include('../include/config.php');
            
  try {
    $pdo = new PDO($query_string,$username,$password); 
    $query = 'SELECT * FROM user ORDER BY user_id asc'; 
    $q = $pdo->query($query);
    $q -> setFetchMode(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
      die("Could not connect to the database $dbname : " .$e->getMessage());
    }
?>

  <h1>แสดงข้อมูลผู้ใช้งาน</h1>

  <div class="center-div">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">Username</th>
            <th scope="col">คำนำหน้าชื่อ</th>
            <th scope="col">ชื่อ</th>
            <th scope="col">สกุล</th>
            <th scope="col">เบอร์โทร</th>
            <th scope="col">อำเภอ</th>
            <th scope="col">ตำบล</th>
            <th scope="col">สถานะ</th>
            <th scope="col">วันที่ลงทะเบียน</th>
          </tr>
        </thead>

        <tbody class="content">
          <?php
            while($rows = $q -> fetch()):
            print_r($rows)
            ?>
              <tr>
                <th scope="row"><?php echo htmlspecialchars($rows['user_id']) ?></th>
                <td><?php echo htmlspecialchars($rows['username']) ?></td>
                <td><?php echo htmlspecialchars($rows['user_name_Title']) ?></td>
                <td><?php echo htmlspecialchars($rows['user_fname']) ?></td>
                <td><?php echo htmlspecialchars($rows['user_lname']) ?></td>
                <td><?php echo htmlspecialchars($rows['phone']) ?></td>
                <td><?php echo htmlspecialchars($rows['user_ampur']) ?></td>
                <td><?php echo htmlspecialchars($rows['user_district']) ?></td>
                <td><?php echo htmlspecialchars($rows['user_status_id']) ?></td>
                <td><?php echo htmlspecialchars($rows['date_register']) ?></td>
              </tr>
              <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>