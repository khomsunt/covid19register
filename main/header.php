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
        <?php
        if ($_SESSION['group_id']=='1' or $_SESSION['group_id']=='2'){
          ?>
            <li class="nav-item active">
              <a class="nav-link" href="./listUser.php">ผู้ใช้งาน</a>
            </li>
          <?php
        } ?>


        <li class="nav-item active dropdown" style="width:400px;">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            รายงาน
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php
            if ($_SESSION['group_id']=='2'){ ?>
              <a class="nav-link" href="./checkpoint_all_report.php" style="color:black;">จำนวนลงทะเบียนด่าน</a>
              <?php
            }
            if ($_SESSION['group_id']=='11'){ ?>
              <a class="nav-link" href="./checkpoint_summary_report.php" style="color:black;">สรุปลงทะเบียนด่านรายวัน</a>
              <a class="nav-link" href="./checkpoint_report.php" style="color:black;">จำนวนลงทะเบียนด่าน</a>
              <?php
            }else if ($_SESSION['group_id']=='1' or $_SESSION['group_id']=='2'){ ?>
              <a class="nav-link" href="./checkpoint_summary_report.php" style="color:black;">สรุปลงทะเบียนด่านรายวัน</a>
              <a class="nav-link" href="./changwat_risk.php" style="color:black;">รายงานพื้นที่เสี่ยง</a>
              <a class="nav-link" href="./report_risk_ampur.php" style="color:black;">รายงานกลุ่มเสี่ยงรายอำเภอ</a>
            <?php } ?>
              <a class="nav-link" href="./report_in_date.php" style="color:black;">รายงานแยกรายวัน</a>
              <a class="nav-link" href="./report_risk_area.php" style="color:black;">รายงานจำนวนผู้เดินทางเข้าสกล</a>
              <a class="nav-link" href="./ampur_rate.php" style="color:black;">รายงานการบันทึกข้อมูลของหน่วยบริการ</a>
           </div>
        </li>

        
        
      </ul>

      <ul class="navbar-nav">
      <li class="nav-item active">
         <a class="nav-link" href="https://www.skko.moph.go.th/liff_covid/manual.pdf" target="_blank">คู่มือการใช้งาน</a>
         <!-- <a class="nav-link" href="/manual.pdf" target="_blank">คู่มือการใช้งาน</a> -->
      </li>

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
