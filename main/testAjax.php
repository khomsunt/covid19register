<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<script>
    $(function(){

    });
    function getAmphur(amphur_code){
        $.ajax({
            method: "POST",
            url: "ajaxTest.php",
            data: { query_table: "amphur", query_where: "changwatcode='47'" }
        })
        .done(function( msg ) {
            return msg
        });
    }

</script>
</head>
<body>
    
</body>
</html>