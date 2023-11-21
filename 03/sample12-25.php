<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php

    if (isset($_POST['btnExec'])){
        //
        $errmsg = "";
        
        if(strlen($_FILES['uploadfile']['name']) > 0 ) {
            //

            //
            $fileinfo = pathinfo($_FILES['uploadfile']['name']);
            //
            $fileext = strtoupper($fileinfo['extension']);

            if ($_FILES['uploadfile']['size'] > 102400) {
                //
                $errmsg .= "ファイルサイズが大きすぎます！　100KB以下にしてください。<br>";
            }
            elseif ($_FILES['uploadfile']['size'] == 0) {
                //
                $errmsg .= "ファイルが存在しないか空のファイルです！<br>";
            }
            elseif ($fileext != "GIF" and $fileext != "JPG" ) {
                //
                $errmsg >= "対象ファイルはGIFまたはJPGのみです！<br>";
            }
            else{
                //
                //
                $movetofile = "images/upf_" . $_FILES['uploadfile']['name'];
                //
                if (! move_uploaded_file($_FILES['uploadfile']['tmp_name'], $movetofile)){
                    $errmsg.= "ファイルのアップロードに失敗しました。<br>";
                }
            }

            if ($errmsg == "") {
                //
                print $_FILES['uploadfile']['name'] . "<br>";
                print "<img src='$movetofile'><br><br><br>";
            }
            else{
                //
                //
                print $errmsg . "<br><br><br>";
                //
                @unlink($_FILES['uploadfile']['tmp_name']);
            }

        }

        else {
            print "アップロードするファイルが選択されていません！<br><br><br>";
        }

    }

?>
アップロードする画像ファイルを指定して[実行]ボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="uploadfile" size="60">
    <br><br> 
    <input type="submit" name="btnExec" value="実行">
</form>
</body>
</html>
