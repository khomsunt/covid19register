<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script>
        function getAmphur(amphur_code){
            $.ajax({
                method: "POST",
                url: "ajaxTest.php",
                data: { query_table: "campur", query_where: "changwatcode='"+amphur_code+"'" }
            })
            .done(function( msg ) {
                console.log('msg=');
                console.log(msg);
                $.ajax({
                    method: "POST",
                    url: "ajaxTest.php",
                    data: { query_table: "user", query_where: "" }
                })
                .done(function( msg2 ) {
                    console.log(msg2)
                });

            });
        }

        getAmphur('47');


    
    </script>
</head>
<body>
    
</body>
</html>