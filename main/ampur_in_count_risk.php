<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include('../include/config.php');
    $today=date("Y-m-d");
    if (!isset($_POST['register_datetime'])){
        $_POST['register_datetime']=$today;
    }
    $sql_changwat_red="select 
        a.changwat_code,
        c.changwat_name 
        from ampur a 
        left join changwat c on a.changwat_code=c.changwat_code 
        where a.risk_status_id=3 
        group by a.changwat_code";
    $obj=$connect->prepare($sql_changwat_red);
    $obj->execute();
    $rows_changwat_red=$obj->fetchAll(PDO::FETCH_ASSOC);

    $sql="SELECT
        `f`.`ampur_in_code` AS `l|c||รหัสอำเภอ`,
        a.ampur_name as `l|c|รวม|ชื่ออำเภอ`,
        sum(if( f.ampur_in_code
        AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' )
        ,1,0)        
         ) AS `r|n|s|รวม`,";
    $a_changwat_red=[];
    foreach ($rows_changwat_red as $key => $value) {
        $sql_risk_3="sum(
            IF
                (
                    `f`.`real_risk` = 3 
                    AND `f`.`real_risk_area_changwat` = '".$value['changwat_code']."' 
                    AND `f`.`real_date_to_sakonnakhon` > concat( '".$_POST['register_datetime']."' - INTERVAL 1 DAY, ' ', '14' )
                    AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' ),
                    1,
                    0 
                )) AS `r|n|s|พื้นที่ควบคุมสูงสุด(สีแดง)_".$value['changwat_name']."_ใหม่`,
            sum(
            IF
                (
                    `f`.`real_risk` = 3 
                    AND `f`.`real_risk_area_changwat` = '".$value['changwat_code']."'
                    AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' ),
                    1,
                    0 
                )) AS `r|n|s|พื้นที่ควบคุมสูงสุด(สีแดง)_".$value['changwat_name']."_สะสม`";
        array_push($a_changwat_red,$sql_risk_3);
    }
    $sql_risk_3=implode(",",$a_changwat_red);
    $sql_risk=",sum(
        IF
            (
                `f`.`real_risk` = 3 
                AND `f`.`real_date_to_sakonnakhon` > concat( '".$_POST['register_datetime']."' - INTERVAL 1 DAY, ' ', '14' )
                AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' ),
                1,
                0 
            )) AS `r|n|s|พื้นที่ควบคุมสูงสุด__ใหม่`,
        sum(
        IF
        ( `f`.`real_risk` = 3
        AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' )        
        , 1, 0 )) AS `r|n|s|พื้นที่ควบคุมสูงสุด__สะสม`,
        sum(
        IF
            (
                `f`.`real_risk` = 2 
                AND `f`.`real_date_to_sakonnakhon` > concat( '".$_POST['register_datetime']."' - INTERVAL 1 DAY, ' ', '14' )
                AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' ),
                1,
                0 
            )) AS `r|n|s|พื้นที่ควบคุม__ใหม่`,
        sum(
        IF
        ( `f`.`real_risk` = 2
        AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' )        
        , 1, 0 )) AS `r|n|s|พื้นที่ควบคุม__สะสม`,
        sum(
        IF
            (
                `f`.`real_risk` = 1 
                AND `f`.`real_date_to_sakonnakhon` > concat( '".$_POST['register_datetime']."' - INTERVAL 1 DAY, ' ', '14' )
                AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' ),
                1,
                0 
            )) AS `r|n|s|พื้นที่เฝ้าระวังสูงสุด__ใหม่`,
        sum(
        IF
        ( `f`.`real_risk` = 1
        AND `f`.`real_date_to_sakonnakhon` <= concat( '".$_POST['register_datetime']."', ' ', '14' )
        , 1, 0 )) AS `r|n|s|พื้นที่เฝ้าระวังสูงสุด__สะสม`,
        sum(if(f.real_risk=98,1,0)) as `r|n|s|พ้นระยะกักตัว`
        
    FROM
        `from_real_risk` `f` 
        left join ampur47 a on f.ampur_in_code=a.ampur_code
        left join changwat c on f.real_risk_area_changwat = c.changwat_code
    GROUP BY
        `f`.`ampur_in_code`
    ORDER BY a.ampur_code";  
    $sql=$sql.$sql_risk_3.$sql_risk;
    // echo "<br><br><br>".$sql;
    $obj=$connect->prepare($sql);
    $obj->execute();
    $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form id="search" method="post">
        <div class="form-group"  style="margin-top:60px;">
            <label for="exampleFormControlInput1">วันที่เดินทางเข้าถึงสกลนคร </label>
            <div class="input-group mb-3">
            <input name="register_datetime" class="form-control datepicker" id="register_datetime" onkeydown="return false" value="<?php echo $_POST['register_datetime']; ?>"/>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary btn-search" type="button">ค้นหา</button>
            </div>
            </div>
        </div>
    </form>
    <?php
    $title="จำนวนผู้แจ้งเดินทางเข้าสกลนคร วันที่ ".$_POST['register_datetime'];
    include("./autoTable.php");
?>
  <link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>
    <style>
        .cursor-hand{
            cursor:hand;
        }
    </style>
<script>
    $(function(){
        $(".ชื่ออำเภอ").addClass("cursor-hand");
        $(".ชื่ออำเภอ").click(function(){
            let ampur_code=$(this).parent().parent().children().find("div").html().trim();
            console.log(ampur_code,"<?php echo $_POST['register_datetime']; ?>");
        })
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: false,
            language: 'th',//เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true, //Set เป็นปี พ.ศ.
            autoclose: true,
        });
        $(".btn-search").click(function(){
            $("#search").submit();
        })
    })
</script>