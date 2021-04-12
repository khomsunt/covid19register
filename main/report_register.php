<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['group_id']<=0){
  header("Location: ./login.php");
}
include_once('../include/config.php');
include_once('../include/functions.php');

$sql="select c.covid_register_id as `l|c||รหัส` ,
CONCAT(IF(p.prename_name,p.prename_name,''),'',c.fname,' ',c.lname) as `l|c||ชื่อ` ,
c.cid as `l|c||เลขบัตร`,
CONCAT('ต.',IF(t.tambon_name<>'',t.tambon_name,'') ,' ','อ.',if(a.ampur_name<>'',a.ampur_name,''),' ','จ.',if(cw.changwat_name<>'',cw.changwat_name,'')) as `l|c||ที่อยู่ก่อนเข้าสกลนคร`,
CONCAT('ต.',IF(t2.tambon_name<>'',t2.tambon_name,'') ,' ','อ.',if(a2.ampur_name<>'',a2.ampur_name,''),' ','จ.',if(cw2.changwat_name<>'',cw2.changwat_name,'')) as `l|c||ที่ทำงาน`,
CONCAT('ที่อยู่ ',IF(c.house_in_no<>'',c.house_in_no,'') ,' ','หมู่ ',IF(c.moo_in_code<>'',c.moo_in_code,'') ,' ','ต.',IF(t47.tambon_name<>'',t47.tambon_name,'') ,' ','อ.',if(a47.ampur_name<>'',a47.ampur_name,'')) as `l|c||มาที่`,
o.occupation_name as `l|c||อาชีพ`,
c.tel as `l|c||เบอร์โทร`,
r2.risk_level_long_name as `l|c||สถานะ`,
of.office_name as `l|c||ชื่อด่านตรวจ`
from from_real_risk c 
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
left join risk_level r2 on c.real_risk=r2.risk_level_id
left join prename p on c.prename_id=p.prename_id
left join office of on c.checkpoint_id = of.office_id
";
$where = " where c.cut_status_id=1 ";
$sql.=$where;

$rp=10; //rows per page
$sql_count="select count(c.covid_register_id) as count_all from from_real_risk c";
include("./autoPaginationFunction.php");

//echo "<br><br><br><br>".$rows_count;
//print_r($rows_count);
$obj=$connect->prepare($sql);
$obj->execute($params);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

$title="รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนคร";
include("./autoTable.php");
?>
