<nav id="auto_pagination" aria-label="Page navigation" class="auto-pagination" style="position:fixed; right:10px;">
    <ul class="pagination justify-content-end">
        <?php
        $start_page=($page-3);
        $start_page=($start_page<0)?0:$start_page;
        $end_page=($page+3);
        $end_page=(($end_page-$start_page)<6)?($end_page+(6-($end_page-$start_page))):$end_page;
        $end_page=($end_page>=$pages)?($pages-1):$end_page;
        ?>
        <li>
        <div>
<button  type="button" class="btn btn-primary btn_cut_print" style="margin-right:10px;"> ส่งออก EXCEL </button>
</div>

        </li>
        <?php
    if (isset($rp)) {
?>
        <li class="page-item <?php echo ($page=="0")?"disabled":""; ?>" style="cursor:pointer;">
        <a class="page-link first-pagination-link">|<</a>
        </li>

        <li class="page-item <?php echo ($page=="0")?"disabled":""; ?>" style="cursor:pointer;">
        <a class="page-link previous-pagination-link"><</a>
        </li>
        <?php
        for ($p=$start_page; $p <= $end_page; $p++) { 
            ?>
            <li class="page-item <?php echo ($page==$p)?"active":""; ?>" style="cursor:pointer;"><a class="page-link pagination-link" page="<?php echo $p; ?>"><?php echo $p+1; ?></a></li>
            <?php
        }
        if ($end_page<($pages-1)){
            ?>
            <li class="page-item"><a class="page-link">...</a></li>        
            <?php
        }
        ?>
        <li class="page-item <?php echo ($page==($pages-1))?"disabled":""; ?>" style="cursor:pointer;">
        <a class="page-link next-pagination-link">></a>
        </li>

        <li class="page-item <?php echo ($page==($pages-1))?"disabled":""; ?>" style="cursor:pointer;">
        <a class="page-link last-pagination-link">>|</a>
        </li>
<?php }?>
    </ul>
</nav>
<?php 
$input="";
foreach ($_POST as $key => $value) {
   $input.='<input type="hidden" name="'.$key.'" value="'.urlencode($value).'">';
}
?>
<script>
    $(function(){
        $(".pagination-link").click(function(){
            let page=$(this).attr("page");
            let pageInput='<input type="hidden" name="page" value="'+page+'">';
            var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>" method="post"><?php echo $input; ?>'+pageInput+'</form>');
            $('body').append(form);
            $(form).submit();                
         })

        $(".previous-pagination-link").click(function(){
            let pageInput='<input type="hidden" name="page" value="<?php echo $page-1; ?>">';
            var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>" method="post"><?php echo $input; ?>'+pageInput+'</form>');
            $('body').append(form);
            $(form).submit();  
        })

        $(".next-pagination-link").click(function(){
            let pageInput='<input type="hidden" name="page" value="<?php echo $page+1; ?>">';
            var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>" method="post"><?php echo $input; ?>'+pageInput+'</form>');
            $('body').append(form);
            $(form).submit();  
        })

        $(".first-pagination-link").click(function(){
            let pageInput='<input type="hidden" name="page" value="0">';
            var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>" method="post"><?php echo $input; ?>'+pageInput+'</form>');
            $('body').append(form);
            $(form).submit();  
        })

        $(".last-pagination-link").click(function(){
            let pageInput='<input type="hidden" name="page" value="<?php echo $pages-1; ?>">';
            var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>" method="post"><?php echo $input; ?>'+pageInput+'</form>');
            $('body').append(form);
            $(form).submit();  
        })

    })

</script>
