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
        //受け取ったデータをrcv_で始める変数名に展開
        extract($_REQUEST, EXTR_SKIP|EXTR_PREFIX_ALL|EXTR_REFS, "rcv");
        //4つのテキストボックスのループ
        $num = 1;
        foreach ($rcv_inputdata as $data) {
            print "$num ヶ月のテキストボックス→ ";
            print $data . "<br>";
            $num++;
        }
        print "<br><br>";
    }

?>
テキストボックスに値を入力して[送信]ボタンをクリックしてください(複数入力可)。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="post">
    <p><input size="40" type="text" name="inputdata[]"></p>
    <p><input size="40" type="text" name="inputdata[]"></p>
    <p><input size="40" type="text" name="inputdata[]"></p>
    <p><input size="40" type="text" name="inputdata[]"></p>
    <input type="submit" name="btnExec" value="送信">
</form>
</body>
</html>
