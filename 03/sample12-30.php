<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
<?php
    if (isset($_POST['style'])){
        //送信ボタンがクリックされた時
        $stylenum = $_POST['style'];

        //
        switch ($stylenum) {
            case 1:
                $cssfile = "cssfile_1.css";
                break;
            case 2:
                $cssfile = "cssfile_2.css";
                break;
            case 3:
                $cssfile = "cssfile_3.css";
                break;
        }
    } else {
        //
        $cssfile = "cssfile_1.css";
        $stylenum = 1;
    }
?>
    <link rel="stylesheet" href="<?php echo $cssfile?>">
</head>
<body>
<table border="1">
    <tr>
        <td width="500">インターネットの普及に伴い、その開発環境として、Webサーバ側で動的にコンテンツを生成するサーバーサイドプログラムも一般的なものになりました。Prel、C、Java、ASP、ASP.NETなど、多くの言語や開発環境が登場し、それによって構築されたサイトも相当な数に上っています。検索や投稿、データ編集などの機能を持ったサイトでは、もはや不可欠な存在となっています。
        </td?>
    </tr>
</table>
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="POST" name="myform">
    スタイル:
    <select size="3" name="style" onclick="document.myform.submit();">
        <option value="1"<?php echo ($stylenum==1?" selected":"")?>>スタイル1</option>
        <option value="2"<?php echo ($stylenum==2?" selected":"")?>>スタイル2</option>
        <option value="3"<?php echo ($stylenum==3?" selected":"")?>>スタイル3</option>
    </select>
</form>
</body>
</html>
