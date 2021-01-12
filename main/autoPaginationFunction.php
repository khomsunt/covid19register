<?php
$sql_count.=$where;
$obj=$connect->prepare($sql_count);
$obj->execute();
$rows_count=$obj->fetchAll(PDO::FETCH_ASSOC);

$count_all=$rows_count[0]['count_all'];
  $pages=ceil($count_all/$rp);
  $page=(isset($_GET['page']))?$_GET['page']:0;
  $start=$page*$rp;
  $limit=" limit ".$start.",".$rp;
  $sql.=$limit;
  $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  
  $qrystr=$_SERVER['QUERY_STRING'];
  $a_qrystr=explode("&",$qrystr);
  $aa_qrystr=[];
  foreach ($a_qrystr as $key => $value) {
    $a_value=explode("=",$value);
    $aa_qrystr[$a_value[0]]=$a_value[1];
  }
  $a_strqry=[];
  foreach ($aa_qrystr as $key => $value) {
    if ($key=='page'){
    }else{
      array_push($a_strqry,$key."=".$value);
    }
  }
  $have_page=0;
  foreach ($aa_qrystr as $key => $value) {
    if ($key=='page'){
      $have_page++;
      array_push($a_strqry,$key."=");
    }else{
    }
  }
  if ($have_page==0){
    array_push($a_strqry,"page=");
  }
  $strqry=implode("&",$a_strqry);
//   echo "<br>strqry=".$strqry;
  ?>