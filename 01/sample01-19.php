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
        //変数が５以下なら⚫︎マークを、
        //そうでなければ▼マークを追加
        print ($cnt <= 5) ? "⚫︎" : "▼";
        print "<br>";
    }

?>
</body>
</html>