<?php
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
?>