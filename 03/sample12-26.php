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

        //
        for ($cnt = 0; $cnt < 4; $cnt++) {

            //
            $errmsg = "";

            if(strlen($_FILES['uploadfile']['name'][$cnt]) > 0 ) {
                //
    
                //
                $fileinfo = pathinfo($_FILES['uploadfile']['name'][$cnt]);
                //
                $fileext = strtoupper($fileinfo['extension']);
    
                if ($_FILES['uploadfile']['size'][$cnt] > 102400) {
                    //
                    $errmsg .= "ファイルサイズが大きすぎます！　100KB以下にしてください。<br>";
                } elseif ($_FILES['uploadfile']['size'][$cnt] == 0) {
                    //
                    $errmsg .= "ファイルが存在しないか空のファイルです！<br>";
                } elseif ($fileext != "GIF" and $fileext != "JPG" ) {
                    //
                    $errmsg >= "対象ファイルはGIFまたはJPGのみです！<br>";
                } else{
                    //
                    //
                    $movetofile = "images/upf_" . $_FILES['uploadfile']['name'][$cnt];
                    //
                    if (! move_uploaded_file($_FILES['uploadfile']['tmp_name'][$cnt], $movetofile)){
                        $errmsg.= "ファイルのアップロードに失敗しました。<br>";
                    }
                }
    
                if ($errmsg == "") {
                    //
                    print $_FILES['uploadfile']['name'][$cnt];
                    print "<img src='$movetofile'><br>";
                } else{
                    //
                    //
                    print $errmsg . "<br><br>";
                    //
                    @unlink($_FILES['uploadfile']['tmp_name'][$cnt]);
                }
    
            }

        }
        print "<br><br>";
    }
?>
アップロードする画像ファイルを指定して[実行]ボタンをクリックしてください。
<form action="<?php $_SERVER['SCRIPT_NAME']?>" method="POST" enctype="multipart/form-data">
    <p><input type="file" name="uploadfile[]" size="60"></p>
    <p><input type="file" name="uploadfile[]" size="60"></p>
    <p><input type="file" name="uploadfile[]" size="60"></p>
    <p><input type="file" name="uploadfile[]" size="60"></p>
    <input type="submit" name="btnExec" value="実行">
</form>
</body>
</html>
