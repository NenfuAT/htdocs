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
        else if ($cnt <= 8) {
            //５以下ではないが８以下なら◼︎マークを追加
            print "◼︎";
        }
        else {
            //いずれの条件にも一致しない場合
            print "▼";
        }
        print "<br>";
    }

?>
</body>
</html>