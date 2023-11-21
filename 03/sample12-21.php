<?php
    if (!isset($_POST['btnExec'])) {
        //
        //
        $html = "テキストボックスに値を入力して[送信]ボタンをクリックしてください。
                <form action='sample12-21.php' method='POST'>
                    <input size='40' type='text' name='inputdata'>
                    <input type='submit' name='btnExec' value='送信'>
                </form>";
    }else{
        //
        if (strlen($_POST['inputdata']) > 0) {
            print "テキストボックスに入力されたデータは「" .
            $_POST['inputdata'] . 
            "」です！<br><br>
            確定してよろしければ[OK]ボタンをクリックしてください。";
            //
            $html = "<form action='sample12-21-2.php' method='POST'>
                        <input type='hidden' name='inputdata' value=" . $_POST['inputdata'] . ">
                        <input type='submit' name='btnExec' value=' O K '>
                    </form>";
        }else{
            print "テキストボックスは空欄です！再入力してください。<br><br>";
            //
            $html ="<form action='sample12-21.php' method='POST'>
                        <input size='40' type='text' name='inputdata'>
                        <input type='submit' name='btnExec' value='送信'>
                    </form>";
        }
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php echo $html?>
</body>
</html>
