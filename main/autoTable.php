<html lang="en">
    <head>
        <?php
            header("Cache-Control: private, must-revalidate, max-age=0");
            header("Pragma: no-cache");
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.1.1">
        <title><?php echo $title; ?></title>
        <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/carousel/">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .cursor-hand{
                cursor:hand;
                color: blue;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }
        </style>
        <script src="../js/jquery-3.2.1.min.js" ></script>
        <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/tableToCards.js"></script>
        <script src='../js/table2excel.js'></script>
    </head>
    <body>
        <?php
            include("./header.php");
        ?>
        <div style="padding: 10px; float:left; float:top; position:fixed; z-index:1000; background-color:#D3D3D3; width:100%; " id="auto_table_title">
            <h4><?php echo $title; ?></h4>
        </div>
        <div id="auto_table_data" >
        <?php
            include("./autoTableTable.php");
        ?>
        </div>
        <?php
            // include("./footer.php");
        ?>
        
        <script>
            var headerHeight=0;
            var autoTableTitleHeight=0;
            var autoPaginationHeight=0;
            $(function () {
                headerHeight=$("#topbar_menu").outerHeight();
                $("#auto_table_title").offset({top: headerHeight});
                autoTableTitleHeight=$("#auto_table_title").outerHeight();
                autoPaginationHeight=$("#auto_pagination").outerHeight(true);
                $("#auto_pagination").css("margin-top",-autoPaginationHeight);
                $("#auto_table_data").css("margin-top",(headerHeight+autoTableTitleHeight+autoPaginationHeight+20)+"px");
                $('[data-toggle="tooltip"]').tooltip();
                var file_name="<?php echo thailongdate($datetime_now); ?>";
                file_name=file_name.replaceAll('-','');
                file_name=file_name.replaceAll(' ','');
                file_name=file_name.replaceAll(':','');
                $('.btn_cut_print').on('click', function Export() {
                    $("#myTable").table2excel({
                        filename: '<?php echo $title; ?>_'+file_name+'.xls'
                    });
                });
                <?php
                    if (isset($filter)){
                        foreach ($filter as $fk => $fv) {
                            $$fk=array_unique($$fk);
                            $tt=$fk."_value";
                            $$tt=array_unique($$tt);
                            ?>
                            $("#filter-<?php echo $fk; ?>").append($('<option></option>').val("").html("--กรองข้อมูล--"));
                            <?php
                            foreach ($$fk as $key => $value) {
                                ?>
                                $("#filter-<?php echo $fk; ?>").append($('<option></option>').val("<?php echo $value; ?>").html("<?php echo $value; ?>"));
                                <?php
                            }
                            if (isset($_POST[$fk])){
                                ?>
                                $("#filter-<?php echo $fk; ?>").val("<?php echo $_POST[$fk]; ?>");
                                <?php
                            }
                        }  
                        ?>
                        $(".filter-autotable").on("change",function(){
                            let formData="";
                            $('.filter-autotable').each(function(){
                                if ($(this).val()!=""){
                                    formData=formData+'<input type="hidden" name="'+$(this).attr("filterName")+'" value="' + $(this).val() + '"></input>';
                                    console.log($(this).attr("filterName"),$(this).val());
                                }
                            });


                            var form = $('<form action="" method="post">'+ formData + '</form>');
                            $('body').append(form);
                            $(form).submit();                


                            
                        });
                        <?php      
                    }
                ?>
    })
</script>


    </body>
</html>

