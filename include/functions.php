<?php
    include('../include/config.php');

	function thailongdate($date)
    {
        $mon=array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
        $byear=substr(substr($date,0,4)+543,0,4);
        $bmon=substr($date,5,2);
        $bday=substr($date,8,2);
        $xdate= (($bday+0>0)?($bday+0).' ':''). $mon[$bmon-1].' '. $byear;
        $xdate=((is_null($date)) or ($date=="") or ($date=="0000-00-00"))?"&nbsp;":$xdate;
        return $xdate;
    }

    function decodeCode($table,$value,$codeField,$returnField){
        global $connect;
        $sql="select ".$returnField." from ".$table." where ".$codeField."='".$value."'";
        $obj=$connect->prepare($sql);
        $obj->execute();
        $rows=$obj->fetchAll(PDO::FETCH_ASSOC); 
        $_return="";
        if (count($rows)>0){
            $_return=$rows[0][$returnField];
        }
        return $_return;       
        //return $sql;
    }
?>