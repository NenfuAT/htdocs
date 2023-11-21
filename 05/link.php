<?php
//
//
//
//
require "config.php";

//
//
//
//
$prmarray = cnv_formstr($_POST);

//
//
//

?>
<?php $conn = db_conn(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title><?=APPNAME?></title>
</head>
<body>
<div align="center">
<h3><?=APPNAME?></h3>

<?php
//
$key = (isset($prmarray["key"])) ? $prmarray["key"] : "";

//
$p = (isset($prmarray["p"])) ? intval($prmarray["p"]) : 1;
$p = ($p < 1) ? 1 : $p;
?>

<!-- 検索フォーム -->
<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
	<table border="0">
	<tr>
	<td><input type="text" name="key" value="<?=$key?>"></td>
	<td><input type="submit" value="検索" name="sub1"></td>
	</tr>
	</table>
	<input type="hidden" name="act" value="src">
</form>

<!-- 検索結果 -->
<?php disp_listdata($key,$p); ?>
</div>
</body>
</html>
<?php db_close($conn); ?>
<?php

//
//
//
/*
function cnv_formstr($array) {

	foreach($array as $k => $v){
		//
		if (get_magic_quotes_gpc()) {
			$v = stripslashes($v);
		}
		$v = htmlspecialchars($v);
		$array[$k] = $v;
	}
	return $array;
}
*/

function cnv_formstr($array) {
	foreach($array as $k => $v){
		// マジッククォートが有効であればエスケープ解除
		if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
			$v = stripslashes($v);
		}
		$v = htmlspecialchars($v);
		$array[$k] = $v;
	}
	return $array;
}

//
//
//
function cnv_sqlstr($string) {
	//
	$det_enc = mb_detect_encoding($string, "UTF-8, EUC-JP, SJIS");
	if($det_enc and $det_enc != ENCDB) {
		$string = mb_convert_encoding($string, ENCDB, $det_enc);
	}

	$string = addslashes($string);
	return $string;
}


//
//
//
function cnv_dispstr($string) {
	//
	$det_enc = mb_detect_encoding($string, "UTF-8, EUC-JP, SJIS");
	if($det_enc and $det_enc != ENCDISP) {
		return mb_convert_encoding($string, ENCDISP, $det_enc);
	}
	else{
		return $string;
	}
}

//
//
//
function cnv_link($url, $title) {
	$string = "<a href=\"$url\">".$title."</a>";
	return $string;
}


//
//
//
function disp_listdata($key, $p) {
	global $conn;

	//
	$st = ($p -1) * intval(PAGESIZE);

	//
	$sql = "SELECT * FROM linkdata";
	if (strlen($key) > 0) {
		$sql .= " WHERE (l_url LIKE '%".cnv_sqlstr($key)."%')";
		$sql .= " OR (l_title LIKE '%".cnv_sqlstr($key)."%')";
		$sql .= " OR (l_comment LIKE '%".cnv_sqlstr($key)."%')";
	}
	$sql .= " ORDER BY l_date DESC LIMIT $st,".intval(PAGESIZE);
	//
	$res = db_query($sql, $conn);
	if ($res->num_rows <= 0) {
		echo "<p>データは登録されていません";
		return;
	}

?>
	<table border="0" width="600" style="line-height: 150%">
	<tr>
	<td>
	<ul>
	<?php while ($row = $res->fetch_array(MYSQLI_ASSOC)) { ?>
	<li><?=cnv_link($row["l_url"], cnv_dispstr($row["l_title"]))?>
	--- <?=cnv_dispstr($row["l_comment"])?>
	(<?=date("Y/m/d", strtotime($row["l_date"]))?>)
	<?php } ?>
	</ul>
	</td>
	</tr>
	</table>
	<!-- 前後ページへのリンク -->
	<?php disp_pagenav($key, $p); ?>
<?php
}

//
//
//
function disp_pagenav($key, $p =1) {
	global $conn;

	//
	$prev = $p - 1;
	$prev = ($prev < 1) ? 1 : $prev;
	$next = $p + 1;

	//
	$sql = "SELECT COUNT(*) AS cnt FROM linkdata";
	if (isset($key)) {
		if (strlen($key) > 0) {
			$sql .= " WHERE (l_url LIKE '%".cnv_sqlstr($key)."%')";
			$sql .= " OR (l_title LIKE '%".cnv_sqlstr($key)."%')";
			$sql .= " OR (l_comment LIKE '%".cnv_sqlstr($key)."%')";
		}
	}
	$res = db_query($sql, $conn);
	$row = $res->fetch_array(MYSQLI_ASSOC);
	$recordcount = $row["cnt"];

?>
	<table>
	<tr>
	<?php if ($p > 1) { ?>
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
	<td><input type="submit" value="<<前"></td>
	<input type="hidden" name="act" value="src">
	<input type="hidden" name="p" value="<?=$prev?>">
	<input type="hidden" name="key" value="<?=$key?>">
	</form>
	<?php } ?>
	<?php if ($recordcount > ($next - 1) * intval(PAGESIZE)) { ?>
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
	<td width="50%"><input type="submit" value="次 >>"></td>
	<input type="hidden" name="act" value="src">
	<input type="hidden" name="p" value="<?=$prev?>">
	<input type="hidden" name="key" value="<?=$key?>">
	</form>
	<?php } ?>
	</tr>
	</table>

<?php
}

//
//
//
function db_conn(){
	$conn = new mysqli(DBSV, DBUSER, DBPASS, DBNAME);
	if($conn->connect_error) {
		error_log($conn->connect_error);
		exit;
	}
	$conn->set_charset("utf8mb4");
	return $conn;
}

//
//
//
function db_query($sql, $conn) {
	$res = $conn->query($sql);
	return $res;
}

//
//
//
function db_close($conn) {
	//
	$conn->close();
}
?>
