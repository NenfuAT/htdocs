<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    //１〜１０までのループ
    for ($cnt = 1; $cnt <= 10; $cnt++) {
        print $cnt;
        if ($cnt <= 5) {
            //変数値が５以下なら⚫︎マークを追加
            print "⚫︎";
        }
        else{
            //変数値が５を超えたらスクリプト終了
            exit();
        }
        print "<br>";
    }
    print "ループ終了！";

?>
</body>
</html>