#!/usr/bin/php -q
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
$sql_max = "select * from thai_case order by No desc limit 1 ";
$obj=$connect->prepare($sql_max);
$obj->execute();
$rows_max=$obj->fetchAll(PDO::FETCH_ASSOC); //insert

// $sql_changwat="select count(*) as all_changwat , c.changwat_name, t.Province, t.ProvinceEn from thai_case_copy t
// left join  changwat_infection c on t.Province = c.changwat_name
// GROUP BY Province";
// $obj=$connect->prepare($sql_changwat);
// $obj->execute();
// $rows_changwat=$obj->fetchAll(PDO::FETCH_ASSOC); //update
// print_r($rows_changwat);

$max = 0;
if(count($rows_max)>0){
    $max = $rows_max[0]['No'];
}
echo $max ;
$response=file_get_contents("https://covid19.th-stat.com/api/open/cases");
// echo "<br>response=".$response;

$rs=json_decode($response);
foreach ($rs as $key => $value) {
        echo "<br>key=".$key;
        echo "<br>value=".$value;
        foreach ($value as $k => $v) {
            print_r($v);
            if(($v->No>$max) || ($v->No=='')){
                $sql="insert into thai_case ";
                $fields=[];
                $values=[];
                foreach ($v as $kv => $vv) {
                    array_push($fields,$kv);
                    array_push($values,"'".$vv."'");
                }
                $sql.="(".implode(",",$fields).") value (".implode(",",$values).")";
                echo "<br>"."$sql;";
                $obj=$connect->prepare($sql);
                $obj->execute();

                
            }else{
                break;
            }
        }

    //     foreach ($rows_changwat as $ki => $vi) {
    //         $sql_in = "update changwat_infection set infection =".$vi['all_changwat']." where changwat_name  = ".$vi['Province']." ";
    //     echo "<br>"."$sql_in;";
    //     $obj=$connect->prepare($sql_in);
    //     $obj->execute();
    // }
}   
    

?>