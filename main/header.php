<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="./index.php">Covid-19 register</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
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
