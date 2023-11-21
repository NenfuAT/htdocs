<?php

    if(isset($_GET['id'])){
        //idデータが渡された時
        if($_GET['id'] == 0){
            //id=0が渡された時はカートをクリア
            setcookie("mycart");
            $id = null;
        } else {
            //id=0以外はカートに入れる
            if(isset($_COOKIE['mycart'])){
                //クッキーにデータが保存されている時
                //現在のカートの状態を取得
                $data = $_COOKIE['mycart'];
                parse_str($data, $output);
                $id = $output['ck_id'];
            }
            //現在のカートデータに今回の商品IDをカンマ区切りで追加
            if(isset($id)){
                $id .= "," . $_GET['id'];
            } else {
                $id = $_GET['id'];
            }
            //データをクッキーに保存
            setcookie("mycart", "ck_id=$id");

            //追加したデータを表示
            print "今回カートに入れた商品IDは " .$_GET['id'] . "<br><br>";
        }

        //現在のカート内容を列挙
        print "【現在のカートの状況】<br>";
        if(isset($id)){
            $idarray = explode(",", $id);
            foreach($idarray as $data){
                print $data . "<br>";
            }
        }
        print "<br><br>";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF=8">
    <title></title>
</head>
<body>
    <table border="1">    
        <tr>
            <th>商品ID</th>
            <th>商品名</th>
            <th><br></th>
        </tr>
        <tr>
            <td>1</td>
            <td>冷蔵庫 AB-12345 (H)</td>
            <td>
                <a href="<?php echo $_SERVER['SCRIPT_NAME']."?id=1"?>">カートに入れる</a>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>エアコン AC-99999(W)</td>
            <td>
                <a href="<?php echo $_SERVER['SCRIPT_NAME']."?id=2"?>">カートに入れる</a>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>テレビ TV-A3456K-L23</td>
            <td>
                <a href="<?php echo $_SERVER['SCRIPT_NAME']."?id=3"?>">カートに入れる</a>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>パソコン PC-999999 Win100G</td>
            <td>
                <a href="<?php echo $_SERVER['SCRIPT_NAME']."?id=4"?>">カートに入れる</a>
            </td>
        </tr>
        <tr>
            <td>5</td>
            <td>洗濯機 SK-TK2424 380L</td>
            <td>
                <a href="<?php echo $_SERVER['SCRIPT_NAME']."?id=5"?>">カートに入れる</a>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <a href="<?php echo $_SERVER['SCRIPT_NAME']."?id=0"?>">カートをクリア</a>
            </td>
        </tr>
    </table>
</body>
</html>
