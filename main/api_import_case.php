<?php
$response=file_get_contents("https://covid19.th-stat.com/api/open/cases");
// echo "<br>response=".$response;
$rs=json_decode($response);
foreach ($rs as $key => $value) {
    echo "<br>key=".$key;
    echo "<br>value=".$value;
    foreach ($value as $k => $v) {
        $sql="insert into thai_case ";
        $fields=[];
        $values=[];
        foreach ($v as $kv => $vv) {
            array_push($fields,$kv);
            array_push($values,"'".$vv."'");
        }
        $sql.="(".implode(",",$fields).") value (".implode(",".$values).")";
        echo "<br>sql ".$k." = ".$sql;
    }
}
?>