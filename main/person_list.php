<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../include/config.php');
include_once('../include/functions.php');
$sql="select c.covid_register_id as `l|c||รหัส` ,
c.fname as `l|c||ชื่อ` ,
c.lname as `l|c||นามสกุล` ,
c.cid as `l|c||เลขบัตร`,
p.prename_name as `l|c||คำนำหน้าชื่อ`,
cw.changwat_name  as `l|c||จังหวัดที่มา`,
a.ampur_name as  `l|c||อำเภอที่มา`,
t.tambon_name as `l|c||ตำบลที่มา`,
cw2.changwat_name as `l|c||จังหวัดที่ทำงาน`,
a2.ampur_name as `l|c||อำเภอที่ทำงาน`,
t2.tambon_name as `l|c||ตำบลที่ทำงาน`,
a47.ampur_name as `l|c||อยู่ที่อำเภอ`,
t47.tambon_name as `l|c||อยู่ที่ตำบล`,
o.occupation_name as `l|c||อาชีพ`,
r.cut_status_name as `l|c||สถานะข้อมูล`,
c.tel as `l|c||เบอร์โทร`,
r2.risk_level_long_name as `l|c||สถานะ`,
c.checkpoint_id as `l|c||รหัสด่านตรวจ`,
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
where checkpoint_id is not null";





$obj=$connect->prepare($sql);
$obj->execute($params);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);

$title="รายงานข้อมูลกลุ่มเสี่ยงที่เดินทางถึงสกลนคร  ".$_SESSION['office_name'];
include("./autoTable.php");



?>
<script>
