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

    //
    for ($cnt=1;$cnt<=5;$cnt++){
        //
        $imagefile = mt_rand(1,9);
        //
        $imagefile = "image" . $imagefile . ".gif";
        //
        print "<IMG src='images/$imagefile' hspase='2'>";
    }

?>
</body>
</html>