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
?>
