<?php
  include('../include/config.php');
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูลเจ้าหน้าที่ทั้งหมด</title>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/content/tables/">

    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <style>
      #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
      }

      #customers tr:nth-child(even){background-color: #f2f2f2;}

      #customers tr:hover {background-color: #ddd;}

      #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
      }

      .button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
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
  try {
    $pdo = new PDO($query_string,$username,$password);

    $sql = 'SELECT * FROM user 
             LEFT JOIN prename ON user.prename_id = prename.prename_id
             LEFT JOIN office ON user.office_id =office.office_id
             LEFT JOIN `status` ON user.status_id = status.status_id
             LEFT JOIN `group` ON user.group_id = group.group_id';
    $obj = $pdo->prepare($sql);
    $obj -> execute();
    $obj -> setFetchMode(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    die("Could not connect to the database $dbname : " . $e -> getMessage());
  }
?>

  <h1>แสดงข้อมูลเจ้าหน้าที่ทั้งหมด</h1>
  <!-- <button class="button" onclick>เพิ่ม</button> -->
  <!-- <button onclick="myFunction()">Click me</button> -->
  <button class="button" onclick="userPage()">เพิ่ม</button>

  <script>
    function userPage() {
      window.location = "user.php";
    }
  </script>

  <table id="customers">
  <tr>
  <th scope="col">ลำดับ</th>
            <th scope="col">Username</th>
            <th scope="col">คำนำหน้าชื่อ</th>
            <th scope="col">ชื่อ</th>
            <th scope="col">สกุล</th>
            <th scope="col">เบอร์โทร</th>
            <th scope="col">หน่วยงาน</th>
            <th scope="col">สิทธิ์การใช้งาน</th>
            <th scope="col">สถานะ</th>
            <th scope="col">วันที่ลงทะเบียน</th>
            <th scope="col">แก้ไข</th>
  </tr>
  <tr>
      <?php
            while($rows = $obj -> fetch()):
            ?>
            <tr>
                <th scope="row"><?php echo $rows['user_id'] ?></th>
                <td><?php echo $rows['user_login'] ?></td>
                <td><?php echo $rows['prename_name'] ?></td>
                <td><?php echo $rows['fname'] ?></td>
                <td><?php echo $rows['lname'] ?></td>
                <td><?php echo $rows['phone'] ?></td>
                <td><?php echo $rows['office_name'] ?></td>
                <td><?php echo $rows['group_name'] ?></td>
                <td><?php echo $rows['status_name'] ?></td>
                <td><?php echo $rows['date_register'] ?></td>
                <td><a href="../main/userEdit.php?user_id=<?php echo htmlspecialchars($rows['user_id']) ?>" class="button">แก้ไข</a></td>
              </tr>
      <?php endwhile; ?>
</table>
</body>
</html>