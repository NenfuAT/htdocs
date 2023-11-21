<?php

    if(isset($_POST['btnExec'])){
        //送信ボタンがクリックされたとき
        $name = $_POST['username'];
        $address = $_POST['useraddress'];
        //データをクッキーに保存
        setcookie("mycookiedata", "ck_name=$name&ck_address=$address",
                    time() + (3600 * 24 * 7));
        print "送信されたデータは<br>";
        print "名前→" . $name . "<br>";
        print "住所→" . $address . "<br>";
        print "<br><br>";
    } else {
        //初めて呼び出された時
        if(isset($_COOKIE['mycookiedata'])){
            //クッキーにデータが保存されている時
            $data = $_COOKIE['mycookiedata'];
            parse_str($data, $output);
            //分解後のデータをフォームで使う変数に代入
            $name = $output['ck_name'];
            $address = $output['ck_address'];
        } else {
            $name = null;
            $address = null;
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF=8">
    <title></title>
</head>
<body>
    名前と住所を入力して[送信]ボタンをクリックしてください。
    <form action="<?php $_SERVER['SCRIPT_NAME']?>" method="POST">
        名前：<input size="40" type="text" name="username" value="<?php echo $name?>"><br>
        住所：<input size="40" type="text" name="useraddress" value="<?php echo $address?>">
        <input type="submit" name="btnExec" value="送信">
    </form>
</body>
</html>
