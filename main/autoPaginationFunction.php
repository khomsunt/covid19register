<?php
$sql_count.=$where;
$obj=$connect->prepare($sql_count);
$obj->execute();
$rows_count=$obj->fetchAll(PDO::FETCH_ASSOC);

$count_all=$rows_count[0]['count_all'];
  $pages=ceil($count_all/$rp);
  $page=(isset($_POST['page']))?$_POST['page']:0;
  $start=$page*$rp;
  $limit=" limit ".$start.",".$rp;
  $sql.=$limit;
  $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
  $qrystr=$_SERVER['QUERY_STRING'];
  $a_qrystr=explode("&",trim($qrystr));
  if ($a_qrystr[0]==''){
    unset($a_qrystr[0]);
  }
  $aa_qrystr=[];
  foreach ($a_qrystr as $key => $value) {
    $a_value=explode("=",$value);
    $aa_qrystr[$a_value[0]]=$a_value[1];
  }
  $a_strqry=[];
  foreach ($aa_qrystr as $key => $value) {
      array_push($a_strqry,$key."=".$value);
  }
  $strqry=implode("&",$a_strqry);
  ?>