<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');

// $risk_level_id  = $_POST['risk_level_id'];
// $type_cut = $_POST['type_cut'];
// $office_code = $_POST['office_code'];

// $sql="select 
//     c.* 
//     from covid_register_copy3 c";
//     if ($risk_level_id >=0){  
//         $sql.=" where c.hospcode='".$office_code."' and c.evaluate_level=".$risk_level_id;
//       }else{
//         $sql.=" where c.hospcode='".$office_code."' ";
//       }
//       // }else{
//       //   $sql.=" where c.risk_level_id=:risk_level_id";
//       // }
//       if ($type_cut =="new"){
//         $sql.=" and c.cut_status_id=0";
//       }else{
//         if ($type_cut =='cutted'){
//           $sql.=" and c.cut_status_id=1";
//         }
//       }
//       echo "sql_update=".$sql;

//       echo '<br>'.$risk_level_id;
//       echo '<br>'.$type_cut;
//       echo '<br>'.$office_code ;
    // $obj=$connect->prepare($sql);
    // $obj->execute();
    // $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    // print_r($rows);
    // $now_date_time=date('Y-m-d H:i:s');
    // foreach ($rows as $rows_i => $row) {
    //     echo "<br><br>";
    //     // print_r($row);
    //     $sql="insert into covid_register_cut ";
    //     $a_row_key=array();
    //     $a_value=array();
    //     foreach ($row as $row_key => $value) {
    //         // echo "<br>key=".$row_key." : ".$value;
    //         array_push($a_row_key,$row_key);
    //         array_push($a_value,"'".$value."'");
    //     }
    //     array_push($a_row_key,'cut_datetime');
    //     array_push($a_value,"'".$now_date_time."'");
    //     array_push($a_row_key,'cut_user_id');
    //     array_push($a_value,"'".$_SESSION['user_id']."'");
    //     $keys=implode(",",$a_row_key);
    //     $values=implode(",",$a_value);
    //     $sql.="(".$keys.") value (".$values.")";
    //     // echo "<br>sql=".$sql;
    //     $obj=$connect->prepare($sql);
    //     $obj->execute();




    $sql_update="update covid_register_copy3 set cut_status_id=1,cut_datetime=".$now_date_time;
    
    //echo "<br>sql_update=".$sql_update;
    // $obj=$connect->prepare($sql_update);
    // $obj->execute();
    //header("Location: ./cut_data.php");

?>
