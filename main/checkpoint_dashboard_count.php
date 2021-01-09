<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../include/config.php');
include('../include/functions.php');

$sql="SELECT
	c.changwat_name,
	c.risk_status_id,
	r.area_level_name,
	r.background_color,
	r.color,
	count(*) AS count_all,
	sum(if(f.ampur_in_code='01',1,0)) as count_01,
	sum(if(f.ampur_in_code='02',1,0)) as count_02,
	sum(if(f.ampur_in_code='03',1,0)) as count_03,
	sum(if(f.ampur_in_code='04',1,0)) as count_04,
	sum(if(f.ampur_in_code='05',1,0)) as count_05,
	sum(if(f.ampur_in_code='06',1,0)) as count_06,
	sum(if(f.ampur_in_code='07',1,0)) as count_07,
	sum(if(f.ampur_in_code='08',1,0)) as count_08,
	sum(if(f.ampur_in_code='09',1,0)) as count_09,
	sum(if(f.ampur_in_code='10',1,0)) as count_10,
	sum(if(f.ampur_in_code='11',1,0)) as count_11,
	sum(if(f.ampur_in_code='12',1,0)) as count_12,
	sum(if(f.ampur_in_code='13',1,0)) as count_13,
	sum(if(f.ampur_in_code='14',1,0)) as count_14,
	sum(if(f.ampur_in_code='15',1,0)) as count_15,
	sum(if(f.ampur_in_code='16',1,0)) as count_16,
	sum(if(f.ampur_in_code='17',1,0)) as count_17,
	sum(if(f.ampur_in_code='18',1,0)) as count_18
FROM
	from_real_risk f
	LEFT JOIN changwat_risk c ON f.real_risk_area_changwat = c.changwat_code
	LEFT JOIN risk_level r ON c.risk_status_id = r.risk_level_id 
	left join ampur47 a on f.ampur_in_code = a.ampur_code_full
WHERE
	LEFT ( f.register_datetime, 10 )= curdate() 
	AND f.checkpoint_id = ".$_SESSION['office_id']." 
GROUP BY
	f.real_risk_area_changwat
ORDER BY
	r.order_id desc
    ;";
echo "<br><br><br>";
echo $sql;
$obj=$connect->prepare($sql);
$obj->execute($params);
$rows=$obj->fetchAll(PDO::FETCH_ASSOC);
print_r($rows)
?>