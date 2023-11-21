<?php

    //セッションを開始
    session_start();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    //現在のセッション名を表示
    print "【現在のセッション名】<br>";
    print session_name() . "<br><br>";

    //セッション名は session_start() の前に設定する必要が
    //あるので以下はエラーになる
    session_name("ORIGINALSESSION");

    //セッション名を表示
    print "【新しいセッション名】<br>";
    print session_name() . "<br><br>";

?>
</body>
</html>