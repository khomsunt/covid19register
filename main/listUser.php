<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
include('../include/functions.php');
            
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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

      th,
      td {
        max-width: 25px;
      }
      
      .phone {
        width: 9em;
      }

      .line-token{
        width: 11em; 
        word-wrap: break-word;
      }

      #btn-add-user {
        width: 40px;
        height: 40px;
      }
    </style>

</head>
<body>
  <?php
  include("./header.php");
  ?>
  <main role="main" style="margin-top:90px;">

    <h5>แสดงข้อมูลผู้ใช้งาน</h5>
    <a href="../main/user.php"><svg id="btn-add-user" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="a" gradientTransform="matrix(1 0 0 -1 0 -20854)" gradientUnits="userSpaceOnUse" x1="0" x2="512" y1="-21110" y2="-21110"><stop offset="0" stop-color="#00f1ff"/><stop offset=".231" stop-color="#00d8ff"/><stop offset=".5138" stop-color="#00c0ff"/><stop offset=".7773" stop-color="#00b2ff"/><stop offset="1" stop-color="#00adff"/></linearGradient><path d="m512 256c0 141.386719-114.613281 256-256 256s-256-114.613281-256-256 114.613281-256 256-256 256 114.613281 256 256zm0 0" fill="url(#a)"/><g fill="#fff"><path d="m291.007812 375.996094h-169.074218c-5.335938 0-8.550782-2.976563-9.996094-4.75-2.496094-3.066406-3.460938-7.066406-2.648438-10.964844 14.132813-67.894531 74.046876-117.476562 143.214844-119.101562 1.160156.042968 2.324219.074218 3.496094.074218 1.144531 0 2.28125-.03125 3.414062-.070312 21.265626.46875 41.71875 5.292968 60.839844 14.382812 7.480469 3.558594 16.429688.375 19.984375-7.105468 3.558594-7.480469.375-16.429688-7.105469-19.984376-6.074218-2.890624-12.261718-5.417968-18.546874-7.589843 21.9375-17.347657 36.042968-44.1875 36.042968-74.261719 0-52.175781-42.449218-94.625-94.628906-94.625-52.175781 0-94.625 42.449219-94.625 94.625 0 30.109375 14.136719 56.980469 36.121094 74.324219-20.148438 6.929687-39.058594 17.40625-55.683594 31.078125-31.613281 26.007812-53.59375 62.28125-61.894531 102.140625-2.660157 12.777343.527343 25.902343 8.746093 36.007812 8.175782 10.054688 20.304688 15.824219 33.269532 15.824219h169.074218c8.285157 0 15-6.71875 15-15 0-8.285156-6.714843-15.003906-15-15.003906zm-99.636718-229.371094c0-35.636719 28.992187-64.628906 64.628906-64.628906s64.628906 28.992187 64.628906 64.628906c0 34.648438-27.414062 63.011719-61.691406 64.554688-.980469-.015626-1.957031-.042969-2.9375-.042969-1.050781 0-2.101562.015625-3.148438.035156-34.179687-1.648437-61.480468-29.96875-61.480468-64.546875zm0 0"/><path d="m418 324.515625h-36.484375v-36.484375c0-8.28125-6.714844-15-15-15-8.28125 0-15 6.71875-15 15v36.484375h-36.480469c-8.285156 0-15 6.714844-15 15s6.714844 15 15 15h36.480469v36.480469c0 8.285156 6.71875 15 15 15 8.285156 0 15-6.714844 15-15v-36.480469h36.484375c8.285156 0 15-6.714844 15-15s-6.714844-15-15-15zm0 0"/></g></svg></a>
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th>ลำดับ</th>
          <th>Username</th>
          <th>คำนำหน้าชื่อ</th>
          <th>ชื่อ</th>
          <th>สกุล</th>
          <th class="phone">เบอร์โทร</th>
          <th>หน่วยงาน</th>
          <th class="line-token">Line_Token</th>
          <th>สิทธิ์การใช้งาน</th>
          <th>สถานะ</th>
          <th>วันที่ลงทะเบียน</th>
          <th data-card-footer></th>
        </tr>
      </thead>

      <tbody>
        <?php
        // print_r($rows);
        $i = 0;
        foreach ($rows as $key => $row) {
          ?>
          <div>
            <tr>
              <td><?php echo ++$i; ?></td>
              <td><?php echo htmlspecialchars($row['user_login']) ?></td>
              <td><?php echo htmlspecialchars($row['prename_name']) ?></td>
              <td><?php echo htmlspecialchars($row['fname']) ?></td>
              <td><?php echo htmlspecialchars($row['lname']) ?></td>
              <td class="phone"><?php echo htmlspecialchars($row['phone']) ?></td>
              <td><?php echo htmlspecialchars($row['office_name']) ?></td>
              <td class="line-token"><?php echo htmlspecialchars($row['line_token']) ?></td>
              <td><?php echo htmlspecialchars($row['group_name']) ?></td>
              <td><?php echo htmlspecialchars($row['status_name']) ?></td>
              <td><?php echo htmlspecialchars(thailongdate($row['date_register'])) ?></td>
              <td>
                <a href="../main/userEdit.php?user_id=<?php echo htmlspecialchars($row['user_id']) ?>" class="btn btn-primary">แก้ไข</a>
                <a href="../main/userDelete.php?user_id=<?php echo htmlspecialchars($row['user_id']) ?>" class="btn btn-danger btn-delete-user">ลบ</a>
                <a href="../main/changePassword.php?user_id=<?php echo htmlspecialchars($row['user_id']) ?>" class="btn btn-warning">เปลี่ยนรหัสผ่าน</a>
                
              </td>
            </tr>
            </div>
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
</body>
</html>