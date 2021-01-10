<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../include/config.php');
include_once('../include/functions.php');

foreach ($_GET as $key => $value) {
    $_POST[$key]=$value;
}
// echo "<br><br><br>";
// print_r($_POST);
$a_add_where=[];
if (isset($_POST['register_datetime'])){
    array_push($a_add_where," left(f.register_datetime,10)='".$_POST['register_datetime']."' ");
}
if (isset($_POST['office_name'])){
    array_push($a_add_where," o.office_name='".$_POST['office_name']."' ");
}
if (isset($_POST['changwat_name'])){
    array_push($a_add_where," c.changwat_name='".$_POST['changwat_name']."' ");
}
if (isset($_POST['area_level_name'])){
    array_push($a_add_where," r.area_level_name='".$_POST['area_level_name']."' ");
}
$add_where="";
$add_where=implode(" and ",$a_add_where);
if (count($a_add_where)>0){
    $add_where=" and ".$add_where;
}

$sql="SELECT
    left(f.register_datetime,10) as `l|d||วันที่`,
    o.office_name as `l|c||ด่านตรวจ`,
	c.changwat_name as `l|c|รวม|ชื่อจังหวัด`,
	r.area_level_name as `l|c||พื้นที่เสี่ยง`,
	count(*) AS `c|n|s|รวม`,
	sum(if(f.ampur_in_code='01',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_เมือง`,
	sum(if(f.ampur_in_code='02',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_กุสุมาลย์`,
	sum(if(f.ampur_in_code='03',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_กุดบาก`,
	sum(if(f.ampur_in_code='04',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_พรรณานิคม`,
	sum(if(f.ampur_in_code='05',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_พังโคน`,
	sum(if(f.ampur_in_code='06',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_วาริชภูมิ`,
	sum(if(f.ampur_in_code='07',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_นิคมน้ำอูน`,
	sum(if(f.ampur_in_code='08',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_วานรนิวาส`,
	sum(if(f.ampur_in_code='09',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_คำตากล้า`,
	sum(if(f.ampur_in_code='10',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_บ้านม่วง`,
	sum(if(f.ampur_in_code='11',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_อากาศอำนวย`,
	sum(if(f.ampur_in_code='12',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_สว่างแดนดิน`,
	sum(if(f.ampur_in_code='13',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_ส่องดาว`,
	sum(if(f.ampur_in_code='14',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_เต่างอย`,
	sum(if(f.ampur_in_code='15',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_โคกศรีสุพรรณ`,
	sum(if(f.ampur_in_code='16',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_เจริญศิลป์`,
	sum(if(f.ampur_in_code='17',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_โพนนาแก้ว`,
	sum(if(f.ampur_in_code='18',1,0)) as `c|n|s|แจ้งเข้าอำเภอ_ภูพาน`
FROM
	from_real_risk f
    left join office o on f.checkpoint_id = o.office_id
	LEFT JOIN changwat_risk c ON f.real_risk_area_changwat = c.changwat_code
	LEFT JOIN risk_level r ON c.risk_status_id = r.risk_level_id 
	left join ampur47 a on f.ampur_in_code = a.ampur_code_full
WHERE 
    f.checkpoint_id ".$add_where;
$sql.="    
GROUP BY
    left(f.register_datetime,10),
    f.checkpoint_id,
    f.real_risk_area_changwat
ORDER BY
    left(f.register_datetime,10) desc,
	r.order_id desc
	;";
// echo $sql;

$obj=$connect->prepare($sql);
$obj->execute($params);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
// print_r($rows);

$filter=array("register_datetime"=>"วันที่","changwat_name"=>"ชื่อจังหวัด","office_name"=>"ด่านตรวจ","area_level_name"=>"พื้นที่เสี่ยง");
$title="จำนวนการลงทะเบียนที่ ".$_SESSION['office_name'];
include("./autoTable.php");
?>