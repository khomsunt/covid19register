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
                console.log(msg)
                return msg
            });
        }

    $(function(){
        var ampur=getAmphur('47');
        console.log(ampur);

    })

    
    </script>
</head>
<body>
    


<script>
    $(function(){
        function getAmphur(amphur_code){
            $.ajax({
                method: "POST",
                url: "ajaxTest.php",
                data: { query_table: "campur", query_where: "changwatcode='"+amphur_code+"'" }
            })
            .done(function( msg ) {
                return msg
            });
        }
    });

</script>

</body>
</html>