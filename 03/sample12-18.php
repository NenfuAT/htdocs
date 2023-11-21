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
        print $_POST['inputdata'] . "<br><br>";

        //
        print stripcslashes($_POST['inputdata']) . "<br><br>";

    }

?>
テキストボックスに値を入力して[送信]ボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="post">
    <input size="40" type="text" name="inputdata">    
    <input type="submit" name="btnExec" value="送信">
</form>
</body>
</html>
