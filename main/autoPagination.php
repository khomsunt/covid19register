<nav aria-label="Page navigation" class="auto-pagination">
    <ul class="pagination justify-content-end">
        <li class="page-item <?php echo ($page=="0")?"disabled":""; ?>" style="cursor:pointer;">
        <a class="page-link previous-pagination-link">Previous</a>
        </li>
        <?php
        for ($p=0; $p < $pages; $p++) { 
        ?>
            <li class="page-item <?php echo ($page==$p)?"active":""; ?>" style="cursor:pointer;"><a class="page-link pagination-link" page="<?php echo $p; ?>"><?php echo $p+1; ?></a></li>
        <?php
        }
        ?>
        <li class="page-item <?php echo ($page==($pages-1))?"disabled":""; ?>" style="cursor:pointer;">
        <a class="page-link next-pagination-link">Next</a>
        </li>
    </ul>
</nav>
<?php print_r($_POST);
$input="";
foreach ($_POST as $key => $value) {
   $input.='<input type="hidden" name="'.$key.'" value="'.urlencode($value).'">';
}
?>
<script>
    $(function(){
        $(".pagination-link").click(function(){
            let page=$(this).attr("page");
            var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>'+page+'" method="post"><?php echo $input; ?></form>');
            $('body').append(form);
            $(form).submit();                
         })

        $(".previous-pagination-link").click(function(){
          let page="<?php echo $page-1; ?>";
          var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>'+page+'" method="post"><?php echo $input; ?></form>');
          $('body').append(form);
          $(form).submit();  
        })

        $(".next-pagination-link").click(function(){
          let page="<?php echo $page+1; ?>";
          var form = $('<form action="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>'+page+'" method="post"><?php echo $input; ?></form>');
          $('body').append(form);
          $(form).submit();  
          //window.location="./<?php echo $curPageName; ?>?<?php echo $strqry; ?>"+page;
        })
    })

</script>
