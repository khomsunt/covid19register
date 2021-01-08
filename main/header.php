<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
?>
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="./index.php"><?php echo $projectTitle; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <!-- <li class="nav-item active">
          <a class="nav-link" href="./index.php">หน้าแรก<span class="sr-only">(current)</span></a>
        </li> -->
        <li class="nav-item active">
          <a class="nav-link" href="./register.php">แจ้งเข้าพื้นที่<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="./evaluation_risk.php">เกณฑ์การประเมิน<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="./ampur_rate.php">การบันทึกข้อมูลของหน่วยบริการ<span class="sr-only">(current)</span></a>
        </li>
        <?php
        if ($_SESSION['group_id']=='1' or $_SESSION['group_id']=='2'){
          ?>
          <li class="nav-item active">
            <a class="nav-link" href="./pre_cut_data_detail.php">ตัดข้อมูล</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./cut_data.php">ประวัติการตัดข้อมูล</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./listUser.php">ผู้ใช้งาน</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./changwat_risk.php">พื้นที่เสี่ยง</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="./report_risk_ampur.php">กลุ่มเสี่ยงรายอำเภอ</a>
            </li>
            
          <?php
        } ?>
        <li class="nav-item active">
            <a class="nav-link" href="./report_in_date.php">แยกรายวัน</a>
              
            </li>

            <li class="nav-item active">
            <a class="nav-link" href="./report_risk_area.php">จำนวนผู้เดินทางเข้าสกล</a>
              
            </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item active">
          <?php
          if ($_SESSION['user_id']==""){
            ?>
            <a class="nav-link" href="./login.php">Login</a>
            <?php
          }else{
            ?>
            <a class="nav-link" href="./logout.php">Logout</a>
            <?php
          } ?>
        </li>
      </ul>
    </div>
  </nav>
</header>
