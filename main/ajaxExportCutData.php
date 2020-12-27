<?php
include('../include/config.php');

$status="";

// $sql=" select * from covid_register where cid=:cid ";
$sql=" select * from covid_register limit 10 ";
$obj=$connect->prepare($sql);
// $execute_status=$obj->execute([ 'cid' => $_POST['cid'] ]);
$execute_status=$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
<tr>
<td>ชื่อ</td>
<td>สกุล</td>
</tr>
<?php
for ($i=0;$i<count($rows);$i=$i+1) {
    echo "<tr>";
    echo "<td>".$rows[$i]["fname"]."</td>";
    echo "<td>".$rows[$i]["lname"]."</td>";
    echo "</tr>";
}
?>
</table>
<?php
// if ($execute_status==true) {
//     $status="success";
// }
// else {
//     $status="fail";
// }

// $s=$sql;
// // $s="";
// $x=array("sql"=>$s, "data"=>array("status"=>$status, "query_data"=>$rows));
// echo json_encode($x, JSON_UNESCAPED_UNICODE);
?>
