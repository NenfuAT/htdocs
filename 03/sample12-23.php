<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    if (isset($_GET['btnExec'])){
        //

        //
        print $_SERVER['QUERY_STRING'] . "<br><br>";

        //
        print urldecode($_SERVER['QUERY_STRING']) . "<br><br>";

        //
        print $_GET['inputdata'] . "<br>";
        print $_GET['btnExec'] . "<br><br>";

    }

?>
テキストボックスに値を入力して[送信]ボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="GET">
    <input size="40" type="text" name="inputdata">
    <input type="submit" name="btnExec" value="送信">
</form>
</body>
</html>
