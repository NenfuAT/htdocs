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
        print "送信ボタンがクリックされました！<br><br>";
    }
    elseif (isset($_POST['btnCancel'])) {
        //
        //
        header("location: index.htm");
        exit();
    }

?>
いずれかのボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="POST">
    <input type="submit" name="btnExec" value="送信">
    <input type="submit" name="btnCansel" value="キャンセル">
</form>
</body>
</html>
