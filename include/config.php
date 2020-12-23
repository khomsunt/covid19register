<?php
// return array(
//     'host' => '203.157.177.7',
//     'username' => 'root',
//     'password' => '64127427',
//     'port' => '3306',
//     'db' => 'covid19register'
// );

$host='203.157.177.7';
$username='root';
$password='64127427';
$port='3306';
$db='covid19register';


$query_string="mysql:host=".$host.";dbname=".$db.";port=".$port;
try {
    $connect=new PDO($query_string,$username,$password);    
} catch (Exception $exc) {
    echo $exc->getMessage();
    exit;
}

$sql="SET NAMES utf8";
$obj_sql=$connect->prepare($sql);
try {
    $obj_sql->execute();
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}

?>