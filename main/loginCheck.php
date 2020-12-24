<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$obj=$connect->prepare('SELECT u.user_id,u.user_login,u.fname,u.lname,o.office_id,o.office_code,o.office_name,o.node_id FROM user u left join office o on u.office_id=o.office_id WHERE u.user_login = :user_login and u.user_password=md5(:user_password) limit 1');
$obj->execute([ 'user_login' => $_POST['user_login'], 'user_password' => $_POST['user_password'] ]);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
if (count($rows)==1){
    $_SESSION["user_id"] = $rows[0]['user_id'];
    $_SESSION["node_id"] = $rows[0]['node_id'];
}else{
    $_SESSION["user_id"] = "";
    $_SESSION["node_id"] = "";
}

echo json_encode($rows, JSON_UNESCAPED_UNICODE);

?>