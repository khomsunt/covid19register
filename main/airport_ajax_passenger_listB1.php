<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
include_once('../include/config.php');
include_once('../include/functions.php');

$where=" and airport_screen_A1_datetime>'".$_POST['datetime_query']."' ";
if ($_POST['office_id']!='') {
  $where.=" and c.checkpoint_id =".$_POST['office_id']." ";
}
else {
  $where.=" and c.checkpoint_id in (407,408,409,410) ";
}

$sql="select now() datetime_query,c.*,of.office_code flight
,CONCAT('อ.',if(a.ampur_name<>'',a.ampur_name,''),' ','จ.',if(cw.changwat_name<>'',cw.changwat_name,'')) addr_home
,CONCAT('อ.',if(a2.ampur_name<>'',a2.ampur_name,''),' ','จ.',if(cw2.changwat_name<>'',cw2.changwat_name,'')) addr_work
from covid_register c 
left join changwat cw on c.changwat_out_code=cw.changwat_code 
left join ampur a on c.changwat_out_code=a.changwat_code and c.ampur_out_code=a.ampur_code
left join tambon t on c.changwat_out_code=t.changwat_code and c.ampur_out_code=t.ampur_code and c.tambon_out_code=t.tambon_code
left join changwat cw2 on c.changwat_work_code=cw2.changwat_code 
left join ampur a2 on c.changwat_work_code=a2.changwat_code and c.ampur_work_code=a2.ampur_code
left join tambon t2 on c.changwat_work_code=t2.changwat_code and c.ampur_work_code=t2.ampur_code and c.tambon_work_code=t2.tambon_code
left join ampur47 a47 on c.ampur_in_code=a47.ampur_code
left join tambon47 t47 on c.changwat_in_code=t47.changwat_code and c.ampur_in_code=t47.ampur_code and c.tambon_in_code=t47.tambon_code
left join coccupation o on c.occupation_id=o.occupation_id
left join cut_status r on c.cut_status_id=r.cut_status_id
left join office of on c.checkpoint_id = of.office_id 
where c.cut_status_id not in (2,3)  
and date_to_sakonnakhon = left(now(),10) and airport_screen_A1_datetime is not null and airport_screen_B1_datetime is null
".$where."
order by date_to_sakonnakhon,of.office_code,CONVERT(fname USING tis620),CONVERT(lname USING tis620)
";

$obj=$connect->prepare($sql);
$obj->execute();
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// echo $sql;
echo json_encode($rows);
?>