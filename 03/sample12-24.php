<?php

    if (isset($_GET['inputdata'])){
        //
        //
        $html = $_GET['inputdata'] . "<br>";
    }
    else{
        //
        //
        $prm = "ピーエッチピーを使ってWebプログラミング！";
        //
        $html = "<a href='" . $_SERVER['PHP_SELF'] . "?inputdata=" . urlencode($prm) . "'>" . 
                "ここをクリックしてください！</a>";
    }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php echo $html?>
</body>
</html>