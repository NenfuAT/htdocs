<?php   

    if(isset($_POST['btnExec'])){
        //送信ボタンがクリックされた時

        //パスワードが正しいかチェック
        if($_POST['password'] == "12345"){
            //セッションを開始
            session_start();
            //セッション変数にユーザーIDを保存
            $_SESSION['sesuserid'] = $_POST['userid'];
            //sample14-09-2.phpへリダイレクト
            header("location: sample14-09-2.php");
            exit();
        } else {
            print "パスワードが間違っています！<br><br>";
        }
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta cahrset="UTF-8">
</head>
<body>
    ユーザーIDとパスワードを入力して[送信]ボタンをクリックしてください。
    <form action="<?php $_SERVER['SCRIPT_NAME']?>" method="POST">
        ユーザーID：<input size="20" type="text" name="userid"><br>
        <br>
        パスワード：<input size="15" type="password" name="password">
        <input type="submit" name="btnExec" value="送信">
    </form>
</body>
</html>