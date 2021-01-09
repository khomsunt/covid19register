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
    </head>
    <body>
        <?php
            include("./header.php");
        ?>
        <main role="main" style="padding-left: 20px;margin-top: 60px;">
            <div style="padding-top: 10px; padding-bottom: 10px;">
                <h4 style="display: inline;"><?php echo $title; ?></h4>
                <button  type="button" style="margin-top: -10px; margin-left: 10px;" class="btn btn-primary btn_cut_print"> ส่งออก EXCEL </button>
            </div>
            <?php
                include("./autoTableTable.php");
            ?>
        </main>
        <?php
            // include("./footer.php");
        ?>
        <script src="../js/jquery-3.2.1.min.js" ></script>
        <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.min.js"><\/script>')</script><script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/tableToCards.js"></script>
        <script src='../js/table2excel.js'></script>
        <script>
            $(function () {
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
            });
        </script>
    </body>
</html>

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