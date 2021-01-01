<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$obj=$connect->prepare('SELECT u.user_id,u.user_login,u.fname,u.lname,u.group_id,o.office_id,o.office_code,o.office_name,a.node_id,o.ampur_code FROM user u left join office o on u.office_id=o.office_id left join ampur47 a on o.ampur_code=a.ampur_code WHERE u.user_login = :user_login and u.user_password=md5(:user_password) limit 1');
$obj->execute([ 'user_login' => $_POST['user_login'], 'user_password' => $_POST['user_password'] ]);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
if (count($rows)==1){
    $_SESSION["user_id"] = $rows[0]['user_id'];
    $_SESSION["node_id"] = $rows[0]['node_id'];
    $_SESSION["group_id"] = $rows[0]['group_id'];
    $_SESSION["office_id"] = $rows[0]['office_id'];
    $_SESSION["office_code"] = $rows[0]['office_code'];
    $_SESSION["ampur_code"] = $rows[0]['ampur_code'];
}else{
    $_SESSION["user_id"] = "";
    $_SESSION["node_id"] = "";
    $_SESSION["group_id"] = "";
    $_SESSION["office_id"] = "";
    $_SESSION["office_code"] = "";
    $_SESSION["ampur_code"] = "";
}

echo json_encode($rows, JSON_UNESCAPED_UNICODE);

?>