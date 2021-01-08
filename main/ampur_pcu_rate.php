<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include('../include/config.php');
    $today=date("Y-m-d");
    if (!isset($_POST['register_datetime'])){
        $_POST['register_datetime']=$today;
    }
    $sql_ampur_rate="SELECT 
    o.office_code as 'c|c||รหัสสถานบริการ'
    ,o.office_name as 'l|c||ชื่อสถานบริการ'
    ,a.count_all as 'r|n|s|รวม'
    ,a.count_not5999 as 'r|n|s|บันทึกแล้ว'
    ,a.count_5999 as 'r|n|s|ยังไม่บันทึก'
    ,a.percent_not5999 as 'r|f|a|ร้อยละ'
    from office o 
    left join ampur_pcu_rate a on o.office_code=a.hospcode 
    where o.ampur_code='".$_POST['ampur_code']."' and o.have_person=1
    order by percent_not5999 desc, o.office_code";
    $obj=$connect->prepare($sql_ampur_rate);
    $obj->execute();
    $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    echo "<br><br><br><br>";
    //print_r($rows);
    
    $title="รายงานผลงานการบันทึกข้อมูลรายหน่วยบริการ";
    include("./autoTable.php");
?>
