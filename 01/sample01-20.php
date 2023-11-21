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
        if ($cnt == 5) {
            //変数値が５以下なら⚫︎マークを追加
            print "⚫︎";
        }
        if ($cnt > 5) {
            //変数値が５より大きければ▼マークを追加
            print "▼";
        }
        if ($cnt >= 5) {
            //変数値が５以上なら▽マークを追加
            print "▽";
        }
        if ($cnt < 3) {
            //変数値が３より小さければ◼︎マークを追加
            print "◼︎";
        }
        if ($cnt <= 3) {
            //変数値が３以下なら◻︎マークを追加
            print "◻︎";
        }
        if ($cnt <> 7) {
            //変数値が７でなければ★マークを追加
            print "★";
        }
        print "<br>";
    }

?>
</body>
</html>