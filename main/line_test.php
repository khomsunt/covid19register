<?php
include('../include/config.php');

$sql=" insert into covid_register ( ". 
" prename_id,fname,lname,cid,tel ".
" ,house_out_no,moo_out_code,tambon_out_code,ampur_out_code,changwat_out_code ". 
" ,occupation_id,occupation_other,foreign_worker,nation_id,date_to_sakonnakhon ". 
" ,house_in_no,moo_in_code,tambon_in_code,ampur_in_code,changwat_in_code ". 
" ,q1_enter_risk_area,q2_quarantine_work_place,q3_touch_patient,q4_health_officer,q5_enter_patient_area,q6_sick_closer ".
" ,symptom_fever,symptom_cough,symptom_nasal_mucus,symptom_sore_throat,symptom_dyspnea,symptom_not_smell,symptom_not_taste,symptom_date ". 
" ,evaluate_level ". 
" ) ".
" value ( ".
"'".$_POST['prename_id']."' ".
",'".$_POST['fname']."' ".
",'".$_POST['lname']."' ".
",'".$_POST['cid']."' ".
",'".$_POST['tel']."' ".
",'".$_POST['house_out_no']."' ".
",'".$_POST['moo_out_code']."' ".
",'".$_POST['tambon_out_code']."' ".
",'".$_POST['ampur_out_code']."' ".
",'".$_POST['changwat_out_code']."' ".
",'".$_POST['occupation_id']."' ".
",'".$_POST['occupation_other']."' ".
",'".$_POST['foreign_worker']."' ".
",'".$_POST['nation_id']."' ".
",'".$_POST['date_to_sakonnakhon']."' ".
",'".$_POST['house_in_no']."' ".
",'".$_POST['moo_in_code']."' ".
",'".$_POST['tambon_in_code']."' ".
",'".$_POST['ampur_in_code']."' ".
",'".$_POST['changwat_in_code']."' ".
",'".$_POST['q1_enter_risk_area']."' ".
",'".$_POST['q2_quarantine_work_place']."' ".
",'".$_POST['q3_touch_patient']."' ".
",'".$_POST['q4_health_officer']."' ".
",'".$_POST['q5_enter_patient_area']."' ".
",'".$_POST['q6_sick_closer']."' ".
",'".$_POST['symptom_fever']."' ".
",'".$_POST['symptom_cough']."' ".
",'".$_POST['symptom_nasal_mucus']."' ".
",'".$_POST['symptom_sore_throat']."' ".
",'".$_POST['symptom_dyspnea']."' ".
",'".$_POST['symptom_not_smell']."' ".
",'".$_POST['symptom_not_taste']."' ".
",'".$_POST['symptom_date']."' ".
",'".$_POST['evaluate_level']."' ".
" ) ";

$obj=$connect->prepare($sql);
$execute_status=$obj->execute();
$registerLastInsertId=$connect->lastInsertId();

$risk_area=$_POST['risk_area'];
$risk_arrray=explode(",",$risk_area);
$data="|";
for ($i=0;$i<count($risk_arrray);$i=$i+1) {
    $data.=",(".$registerLastInsertId.",".$risk_arrray[$i].")";
}
$data=str_replace("|,","",$data);

$sql2=" insert into covid_register_risk_area (covid_register_id,risk_area_id) value ".$data;
$obj2=$connect->prepare($sql2);
$obj2->execute();


if ($execute_status==true) {
    $status="success";
}
else {
    $status="fail";
}

$s=$sql2;
// $s="";
$x=array("sql"=>$s,"data"=>array("status"=>$status,"registerLastInsertId"=>$registerLastInsertId));


    echo json_encode($x, JSON_UNESCAPED_UNICODE);
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	date_default_timezone_set("Asia/Bangkok");

	$Token = "uG2wE5dQrmwUq1JjjGqKmUBCPjAmcCHA5172p47EiGz";
	//$Message = "เครื่อง server มีการ back up ไม่สำเร็จ <a href='http://www.google.com'> มาแล้ว </a>";
    $Message = 'test covid';
    $Message = "พบบุคลที่มีความเสี่ยงสูง(แดง) ชื่อ ".$_POST['prename_id']." ".$_POST['fname']. " " .$_POST['lname']."  \r\n\r\n
                ".$_POST['cid']." \r\n\r\n 
                บ้านเลขที่ ".$_POST['house_in_no']." หมู่ ".$_POST['moo_in_code']." ตำบล ".$_POST['tambon_in_code']." \r\n\r\n  
                อำเภอ ".$_POST['ampur_in_code']." \r\n\r\n
                โทร ".$_POST['tel']." \r\n\r\n
                ";

	
	$chOne = curl_init(); 
	curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
	curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt( $chOne, CURLOPT_POST, 1); 
	curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$Message); 
	$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$Token.'', );
	curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	$result = curl_exec( $chOne ); 

	//Result error 
	if(curl_error($chOne)) 
	{ 
		echo 'error:' . curl_error($chOne); 
	} 
	else { 
		$result_ = json_decode($result, true); 
		echo "status : ".$result_['status'] ."   ". "message : ". $result_['message'];
	} 
	curl_close( $chOne );   

?>
