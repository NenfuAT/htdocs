<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    //乱数ジェネレータを初期化
    mt_srand();

    //1から6までの乱数を5回生成
    for ($cnt = 1;$cnt <= 5; $cnt++) {
        print mt_rand(1, 6);
        print "<br>";
    }

    
?>
</body>
</html>