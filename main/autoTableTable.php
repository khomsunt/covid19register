<?php
    $max_col=0;
    foreach ($rows[0] as $key => $value) {
        $a_key=explode("_",$key);
        $max_col=(count($a_key)>$max_col)?count($a_key):$max_col;
    }
    $a_h=[];
    $t_h=[];
    for ($i=0; $i < $max_col; $i++) { 
        $old_value="";
        $ii=0;
        $iii=0;
        $a_h[$i]=[];
        $t_h[$i]=[];
        foreach ($rows[0] as $k => $v) {
            $a_k=explode("|",$k);
            $a_v=explode("_",$a_k[3]);
            array_push($t_h[$i],$a_v[$i]);
            if ($ii==0){
                array_push($a_h[$i],$a_v[$i]."_1");
                $old_value=$a_v[$i];
            }else{
                if (trim($old_value)==trim($a_v[$i])){
                    $aa_h=explode("_",$a_h[$i][$iii]);
                    $a_h[$i][$iii]=$aa_h[0]."_".($aa_h[1]+1);
                }else{
                    array_push($a_h[$i],$a_v[$i]);
                    $old_value=$a_v[$i];
                    ++$iii;
                }
            }
            ++$ii;
        }
    }
    foreach ($t_h[0] as $k => $v) {
        for ($i=($max_col-1); $i >=0 ; $i--) { 
            $a_t_h=explode("_",$t_h[$i][$k]);
            if ($a_t_h[0]==""){
                if ($i>=0){
                    $last_a_t_h=explode("_",$t_h[$i-1][$k]);
                    $t_h[$i-1][$k]=$last_a_t_h[0]."_".($a_t_h[1]+1);
                }
            }
        }
    }
    foreach ($t_h[0] as $k => $v) {
        for ($i=($max_col-1); $i >=0 ; $i--) { 
            $a_t_h=explode("_",$t_h[$i][$k]);
            $t_h[$i][$k]=$a_t_h[0]."_".($a_t_h[1]+1);
        }
    }
    $a_h=[];
    for ($i=0; $i < $max_col; $i++) { 
        $old_value="";
        $ii=0;
        $iii=0;
        $a_h[$i]=[];
        foreach ($t_h[$i] as $k => $v) {
            $a_v=explode("_",$v);
            if ($ii==0){
                array_push($a_h[$i],$a_v[0]."_".$a_v[1]."_1");
                $old_value=$a_v[0];
            }else{
                if (trim($old_value)==trim($a_v[0])){
                    $aa_h=explode("_",$a_h[$i][$iii]);
                    $a_h[$i][$iii]=$aa_h[0]."_".$aa_h[1]."_".($aa_h[2]+1);
                }else{
                    array_push($a_h[$i],$a_v[0]."_".$a_v[1]."_1");
                    $old_value=$a_v[0];
                    ++$iii;
                }
            }
            ++$ii;
        }
    }
?>
<table class="table" id="myTable" border="1">
    <thead>
        <?php
        for ($i=0; $i < $max_col; $i++) { 
            // echo "<br><br>".$i."<br>";
            // print_r($a_h[$i]);
            ?>
            <tr>
            <?php
            foreach ($a_h[$i] as $k => $v) {
                $aa_h=explode("_",$v);
                if ($aa_h[0]<>""){
                    ?>
                    <th rowspan="<?php echo $aa_h[1]; ?>" colspan="<?php echo $aa_h[2]; ?>" style="text-align:center;vertical-align: middle;">
                        <?php echo $aa_h[0]; ?>
                    </th>
                    <?php
                }
            } ?>
            </tr>
            <?php
        }
        ?>
    </thead>
    <tbody>
        <?php
            $sum=[];
            foreach ($rows as $key => $value) {
                ?>
                <tr class="row_<?php echo $key; ?>">
                    <?php
                        $col=0;
                        foreach ($value as $k => $v) {
                            $a_k=explode("|",$k);
                            switch ($a_k[2]) {
                                case 's':
                                    $sum[$k]+=$v;
                                    break;                    
                                case 'a':
                                    $sum[$k]+=$v;
                                    break;                    
                                default:
                                    $sum[$k]=$a_k[2];
                                    break;
                            }
                            ?>
                            <td style="white-space: nowrap; text-align:<?php echo autoAlign($a_k[0]); ?>" >
                                <div class="col_<?php echo $col; ?> <?php echo $a_k[3]; ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $a_k[3]; ?>">
                                    <?php echo autoFormat($v,$a_k[1]); ?>
                                </div>
                            </td>
                            <?php
                            ++$col;
                        }
                    ?>
                </tr>
                <?php
            }
        ?>
        <tr style="font-weight: bold;">
            <?php
                foreach ($rows[0] as $k => $v) {
                    $a_k=explode("|",$k);
                    switch ($a_k[2]) {
                        case 's':
                            // $sum[$k]+=1;
                            break;
                        case 'a':
                            $sum[$k]=$sum[$k]/count($rows);
                            break;
                        default:
                            $sum[$k]=$a_k[2];
                            break;
                    }
                    ?>
                    <td style="text-align:<?php echo autoAlign($a_k[0]); ?>">
                        <?php echo autoFormat($sum[$k],$a_k[1]); ?>
                    </td>
                    <?php
                }
            ?>
        </tr>
    </tbody>
</table>
<?php
    function autoFormat($v,$f){
        $_return=$v;
        switch ($f) {
            case 'f':
                $_return=number_format($v,2);
                break;
            case 'n':
                $_return=number_format($v);
                break;
            case 'd':
                $_return=thaishortdate($v);
                break;
            default:
                break;
        }
        return $_return;
    }

    function autoAlign($f){
        $_return="left";
        switch ($f) {
            case 'r':
                $_return="right";
                break;
            case 'c':
                $_return="center";
                break;
            default:
                break;
        }
        return $_return;
    }
?>