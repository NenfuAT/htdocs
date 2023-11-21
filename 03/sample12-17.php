<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    if (isset($_POST['btnExec'])){
        //送信ボタンがクリックされた時
        
        //
        print "【そのまま表示】<br>";
        print $_POST['inputdata'] . "<br><br>";

        //
        print "【改行して表示】<br>";
        print nl2br($_POST['inputdata']) . "<br><br>";

    }

?>
メッセージを入力して[送信]ボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="post">
    <textarea rows="6" cols="40" name="inputdata"></textarea>   
    <input type="submit" name="btnExec" value="送信">
</form>
</body>
</html>
