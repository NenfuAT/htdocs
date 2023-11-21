<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    if (isset($_POST['btnExec'])) {
        //
        if (isset($_POST['inputdata'])) {
            print "配信を希望する";
        }
        else {
            print "配信を希望しない";
        }
        print "<br><br><br>";
    }
    
?>
配信を希望する場合はチェックをつけて[送信]ボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="POST">
    <input type="checkbox" name="inputdata">メールによる配信を希望します
    <input type="submit" name="btnExec" value="送信">
</form>
</body>
</html>