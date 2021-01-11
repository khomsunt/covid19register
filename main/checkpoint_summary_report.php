<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../include/config.php');
include_once('../include/functions.php');

echo "<br><br><br>";
print_r($_POST);

$sql_changwat_risk="select * from changwat_risk where risk_status_id=5";
$obj=$connect->prepare($sql_changwat_risk);
$obj->execute($params);
$rows_changwat_risk=$obj->fetchAll(PDO::FETCH_ASSOC);

// print_r($rows_changwat_risk);

$sql="select f.real_date_to_sakonnakhon as `l|d||วันที่`,count(*) as `c|n|s|รวม`,";
$a_sql_add=[];
$a_changwat_risk=[];
foreach ($rows_changwat_risk as $key => $value) {
    array_push($a_changwat_risk,"'".$value['changwat_code']."'");
    array_push($a_sql_add,"sum(if(f.real_risk_area_changwat='".$value['changwat_code']."',1,0)) as `c|n|s|".$value['changwat_name']."` ");
}

$sql_add=implode(",",$a_sql_add);
$sql_add.=",sum(if(f.real_risk_area_changwat not in(".implode(",",$a_changwat_risk)."),1,0)) as `c|n|s|อื่นๆ` ";
$sql.=$sql_add;
    if(($_SESSION['group_id']=='11')){
        $sql.=" from from_real_risk f left join changwat c on f.real_risk_area_changwat=c.changwat_code where f.checkpoint_id='".$_SESSION["office_id"]."' group by f.real_date_to_sakonnakhon"; 
    }else{
        $sql.=" from from_real_risk f left join changwat c on f.real_risk_area_changwat=c.changwat_code where f.checkpoint_id group by f.real_date_to_sakonnakhon";
    }
//echo "<br><br><br>sql=".$sql;

$obj=$connect->prepare($sql);
$obj->execute($params);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
    if(($_SESSION['group_id']=='11')){
        $title="จำนวนการลงทะเบียน ผ่าน".$_SESSION['office_name']." รายวัน";
    }else{
        $title="จำนวนการลงทะเบียน ผ่านด่านตรวจ covid-19 จังหวัดสกลนคร";
    }
include("./autoTable.php");
?>
<script>
    $(function(){
        $(".วันที่").addClass("cursor-hand");
        $(".วันที่").on("click",function(){
            console.log($(this).attr("originalValue"));
            let formData="";
            formData=formData+'<input type="hidden" name="condition" value="f.real_date_to_sakonnakhon='+$(this).attr("originalValue")+'"></input>';
            var form = $('<form action="./person_list.php" method="post">'+ formData + '</form>');
            $('body').append(form);
            $(form).submit();                




            // alert('ddddd');
        })
    })
</script>