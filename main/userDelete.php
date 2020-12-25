<?php 
    include('../include/config.php');
// echo "<br>config=";
// print_r($configs);
?>

<?php
// $_GET["user_id"]
    $sql="DELETE from `user` WHERE user_id=".$_GET['user_id'];
    $obj=$connect->prepare($sql);
    $obj->execute();
    // $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    // print_r($rows);
?>
<meta http-equiv="refresh" content="0;url=http://localhost/covid19register/main/listUser.php">

<script>
    const listUserPage = function() {
        window.location="listUser.php";
    };
</script>