<?php

    //閲覧しているブラウザの情報を取得・表示
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    //ブラウザの種類によってリダイレクト先を切り替え
    if(strlen(strpos($useragent, "Chrome")) > 0){
        //Chrome
        header("location: sample12-34/sample12-34_Cr.html");
    } elseif (strlen(strpos($useragent, "Safari")) > 0){
        //Safari
        header("location: sample12-34/sample12-34_Sf.html");
    } elseif (strlen(strpos($useragent, "Mozilla")) > 0){
        //FirefoxやMozilla互換ブラウザ
        header("location: sample12-34/sample12-34_Fr.html");
    } else {
        //その他の環境
        header("location: sample12-34/index.html");
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
</body>
</html>