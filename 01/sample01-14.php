<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    //カウント用の変数を１に初期設定
    $cnt = 1;

    //変数値が１０以下の間ループを繰り返し
    while ($cnt <= 10) {
        print $cnt;
        print ",";
        $cnt++;
    }

?>
</body>
</html>