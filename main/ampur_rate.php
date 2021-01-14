<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // include('../include/config.php');
    include('../include/functions.php');
    $today=date("Y-m-d");
    if (!isset($_POST['register_datetime'])){
        $_POST['register_datetime']=$today;
    }
    $sql_ampur_rate="SELECT * from ampur_rate";
    $obj=$connect->prepare($sql_ampur_rate);
    $obj->execute();
    $rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    
    $title="รายงานการประเมินความเสี่ยง.";
    include("./autoTable.php");
?>
<script>
    $(function(){
        $(".ชื่ออำเภอ").click(function(){
            let ampur_code=$(this).parent().parent().children().find("span").html().trim();
            console.log(ampur_code,"<?php echo $_POST['register_datetime']; ?>");
            var form = $('<form action="./ampur_pcu_rate.php" method="post"><input type="hidden" name="ampur_code" value="' + ampur_code + '"></input>' + '</form>');
                $('body').append(form);
                $(form).submit();                
        })
        $(".ชื่ออำเภอ").addClass("cursor-hand");

    })
</script>
