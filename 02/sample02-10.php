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

    //全部で10ヶのパスワードを生成するループ
    for ($passcnt = 1;$passcnt <= 10; $passcnt++) {
        $password="";
        //
        for ($cnt = 1; $cnt <=5; $cnt++) {
            $password = $password . mt_rand(1,9);
        }
        //
        for ($cnt = 1; $cnt <=5; $cnt++) {
            $password = $password . chr(mt_rand(65,90));
        }
        print $password;
        print "<br>";
    }

?>
</body>
</html>