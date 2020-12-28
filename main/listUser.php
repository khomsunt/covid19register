<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
            
try {
  $query = 'SELECT * FROM user 
    LEFT JOIN prename ON user.prename_id = prename.prename_id
    LEFT JOIN office ON user.office_id =office.office_id
    LEFT JOIN `status` ON user.status_id = status.status_id
    LEFT JOIN `group` ON user.group_id = group.group_id';
    $obj=$connect->prepare($query);
    $obj->execute();
    $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (PDOException $e) {
    die("Could not connect to the database $dbname : " .$e->getMessage());
  }

?>

<!DOCTYPE html>
<html lang="th">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>แสดงข้อมูลผู้ใช้งาน</title>
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
    </style>

</head>
<body>
  <?php
  include("./header.php");
  ?>
  <main role="main" style="margin-top:60px;">

    <h5>แสดงข้อมูลผู้ใช้งาน</h5>
    <button class="btn btn-primary btn-add-user">+</button>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th>ลำดับ</th>
          <th>Username</th>
          <th>คำนำหน้าชื่อ</th>
          <th>ชื่อ</th>
          <th>สกุล</th>
          <th>เบอร์โทร</th>
          <th>หน่วยงาน</th>
          <th>Line_Token</th>
          <th>สิทธิ์การใช้งาน</th>
          <th>สถานะ</th>
          <th>วันที่ลงทะเบียน</th>
          <th data-card-footer></th>
        </tr>
      </thead>

      <tbody>
        <?php
        // print_r($rows);
        foreach ($rows as $key => $row) {
          ?>
            <tr>
              <td><?php echo htmlspecialchars($row['user_id']) ?></td>
              <td><?php echo htmlspecialchars($row['user_login']) ?></td>
              <td><?php echo htmlspecialchars($row['prename_id']) ?></td>
              <td><?php echo htmlspecialchars($row['fname']) ?></td>
              <td><?php echo htmlspecialchars($row['lname']) ?></td>
              <td><?php echo htmlspecialchars($row['phone']) ?></td>
              <td><?php echo htmlspecialchars($row['office_name']) ?></td>
              <td><?php echo htmlspecialchars($row['line_token']) ?></td>
              <td><?php echo htmlspecialchars($row['group_name']) ?></td>
              <td><?php echo htmlspecialchars($row['status_name']) ?></td>
              <td><?php echo htmlspecialchars($row['date_register']) ?></td>
              <td>
                <a href="../main/userEdit.php?user_id=<?php echo htmlspecialchars($row['user_id']) ?>" class="btn btn-primary">แก้ไข</a>
                <a href="../main/userDelete.php?user_id=<?php echo htmlspecialchars($row['user_id']) ?>" class="btn btn-danger btn-delete-user">ลบ</a>
                <a href="../main/changePassword.php?user_id=<?php echo htmlspecialchars($row['user_id']) ?>" class="btn btn-primary">เปลี่ยนรหัสผ่าน</a>
              </td>
            </tr>
          <?php 
        } ?>
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
      $(".btn-add-user").click(function(){
        window.location = './user.php';
      })
    })
  </script>
</body>
</html>