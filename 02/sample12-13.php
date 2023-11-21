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
        if (strlen($_POST['inputdata']) > 0) {
            print "テキスト領域に入力されたデータは 「" . $_POST['inputdata'] . "」です！";
        }
        else {
            print "テキスト領域は空欄です！";
        }
        print "<BR><BR><BR>";
    }

?>
メッセージを入力して[送信]ボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="post">
    <textarea rows="6" cols="40" name="inputdata">ここにメッセージを入力してください</textarea>
    <input type="submit" name="btnExec" value="送信">
</form>
</body>
</html>
