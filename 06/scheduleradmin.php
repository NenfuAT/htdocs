<?php
// ================================================
//　オンラインリンク　管理者向けスクリプト
// ================================================

//セッションの開始
session_cache_limiter("public");
session_start();

//　設定ファイルインクルード
require "config.php";

// ================================================
// パラメータの取得
// ================================================
// フォームデータ変換
$prmarray = cnv_formstr($_POST);
// 表示ページ
if(!chk_auth($prmarray)) {
	$act = DEFSCR;
}elseif(isset($prmarray["act"])) {
	$act = $prmarray["act"];
}else {
	$act = DEFSCR;
}

//　処理日時
$dt = date("Y-m-d H:i:s");
// ===================================================
// 処理開始
// ===================================================

?>
<?php $conn = db_conn(); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?=ADMINAPPNAME?></title>
</head>
<body>
	<div align="center">
	<?php
		//画面表示ルーチンの呼び出し
		call_user_func("screen_" . $act, $prmarray);
	?>
	</div>
</body>
</html>
<?php db_close($conn); ?>
<?php

// ==========================
// ログイン画面
// ==========================
function screen_log($array){
?>
	<h3>ログイン画面</h3>
	<!-- ログインフォーム -->
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<table border="1">
			<tr>
				<td>ログインID</td>
				<td><input type="text" name="s_id"></td>
			</tr>
			<tr>
				<td>パスワード</td>
				<td><input type="password" name="s_pass"></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="ログイン" name="sub1"></td>
			</tr>
		</table>
		<input type="hidden" name="act" value="src">
	</form>
<?php
}

// ==========================
//表示画面
// ==========================
function screen_src($array){
	//検索キーワード
	$key = (isset($array["key"])) ? $array["key"] : "";
	//曜日検索用
	$week = isset($_POST["week"]) ? $_POST["week"] : null;
	//週の割り出し
	$weeks = isset($_POST["weeks"]) ? $_POST["weeks"] : 1;
	//月の割り出し
	$currentMonths = date("m");
	$months = isset($_POST["months"]) ? $_POST["months"] : $currentMonths;
	//
	$currentYear = date("Y");
	$years = isset($_POST["years"]) ? $_POST["years"] : $currentYear;
	//表示方法
	$mode = isset($_POST["mode"]) ? $_POST["mode"] : null;
	//表示するページ
	$p = (isset($array["p"])) ? intval($array["p"]) : 1;
	$p = ($p < 1) ? 1 : $p;
?>
	<!-- メニュー -->
	<?php disp_menu(); ?>

	<!-- 検索フォーム --> 
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<table border="0">
			<tr>
				<td><input type="text" name="key" value="<?=$key?>"></td>
			</tr>
		</table>
		<table border="0">
			<tr>
			<?php if ($mode==null) { ?>
				<td><label for="week">曜日:</label>
					<select name="week">
					<option value="" <?= ($week == null) ? 'selected' : '' ?>>すべて</option>
					<option value="2" <?= ($week == 2) ? 'selected' : '' ?>>月曜日</option>
					<option value="3" <?= ($week == 3) ? 'selected' : '' ?>>火曜日</option>
					<option value="4" <?= ($week == 4) ? 'selected' : '' ?>>水曜日</option>
					<option value="5" <?= ($week == 5) ? 'selected' : '' ?>>木曜日</option>
					<option value="6" <?= ($week == 6) ? 'selected' : '' ?>>金曜日</option>
					<option value="7" <?= ($week == 7) ? 'selected' : '' ?>>土曜日</option>
					<option value="1" <?= ($week == 1) ? 'selected' : '' ?>>日曜日</option>
					</select>
					<td><input type="submit" value="検索" name="sub1"></td>
				</td>
			<?php } ?>
			<?php if ($mode==2) { ?>
				<td>
					<label for="years">年:</label>
					<select name="years">
					<?php
					// 現在の年から前後5年までの範囲を表示
					for ($i = $currentYear-5; $i <= $currentYear +5; $i++) {
						$selected = ($years == $i) ? 'selected' : '';
						echo "<option value=\"$i\" $selected>{$i}年</option>";
					}
					?>
					</select>

				
				
					<label for="months">月:</label>
					<select name="months">
					<?php
					// 1~12月の範囲を表示
					for ($i = 1; $i <= 12; $i++) {
						$formattedMonth = str_pad($i, 2, "0", STR_PAD_LEFT);
						$selected = ($months == $formattedMonth) ? 'selected' : '';
						echo "<option value=\"$formattedMonth\" $selected>{$i}月</option>";
					}
					?>
					</select>
					<td><input type="submit" value="検索" name="sub1"></td>
				</td>
			<?php } ?>
			</tr>
		</table>
		<input type="hidden" name="act" value="src">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="weeks" value="<?=$weeks?>">
	</form>

	<!-- 検索結果 --> 
	<?php 
	if($mode==null){
		disp_alldata($key, $p, $week); 
	}
	elseif($mode==1){
		disp_weekdata($key,$p,$weeks);
	}
	elseif($mode==2){
		echo $years;
		echo $months;
		disp_monthsdata($key,$p,$years,$months);
	}
	?>

	<!-- 表示切り替え --> 
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<table border="0">
			<tr>
				<td><label for="mode">表示方法:</label>
					<select name="mode">
					<option value="" <?= ($mode == null) ? 'selected' : '' ?>>全件表示</option>
					<option value="1" <?= ($mode == 1) ? 'selected' : '' ?>>週間表示</option>
					<option value="2" <?= ($mode == 2) ? 'selected' : '' ?>>月間表示</option>
					</select>
				</td>
				<td><input type="submit" value="切り替え" name="sub1"></td>
			</tr>
		</table>
		<input type="hidden" name="act" value="src">
	</form>
<?php	
}

// ==========================
// 登録画面
// ==========================
function screen_ent(){
?>
	<!-- メニュー -->
	<?php disp_menu(); ?>
	<h3>登録画面</h3>

	<!-- 登録フォーム --> 
	<form method="POST" action="<?= $_SERVER["SCRIPT_NAME"] ?>">
    <table border="1">
        <tr>
            <td>内容</td>
            <td><input type="text" name="s_content" size="100"></td>
        </tr>
        <tr>
            <td>場所</td>
            <td><input type="text" name="s_place" size="100"></td>
        </tr>
        <tr>
            <td>開始日時</td>
            <td><input type="datetime-local" name="s_begin"></td>
        </tr>
        <tr>
            <td>終了日時</td>
            <td><input type="datetime-local" name="s_end"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="登録画面" name="sub1"></td>
        </tr>
    </table>
    <input type="hidden" name="act" value="entconf">
</form>

<?php
}
// ========================
// 登録確認画面
// ========================
function screen_entconf($array){
	if(!chk_data($array)){return; }
	extract($array);
?>
	<!-- メニュー -->
	<?php disp_menu(); ?>
	<h3>登録確認画面</h3>

	<!-- 登録データ確認表示　-->
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<table border="1">
			<tr>
				<td>内容</td>
				<td><?=$s_content?></td>
			</tr>
			<tr>
				<td>場所</td>
				<td><?=$s_place?></td>
			</tr>
			<tr>
				<td>開始日時</td>
				<td><?=$s_begin=str_replace("T", " ", $s_begin)?></td>
			</tr>
			<tr>
				<td>終了日時</td>
				<td><?=$s_end=str_replace("T", " ", $s_end)?></td>
			</tr>
			<tr>
				<td> </td>
				<td><input type="submit" name="登録実行" name="sub1"></td>
			</tr>
		</table>
		<input type="hidden" name="s_begin" value="<?=$s_begin?>">
		<input type="hidden" name="s_end" value="<?=$s_end?>">
		<input type="hidden" name="s_content" value="<?=$s_content?>">
		<input type="hidden" name="s_place" value="<?=$s_place?>">
		<input type="hidden" name="act" value="dojob">
		<input type="hidden" name="kbn" value="ent">
	</form>
<?php
}

// ======================
// 更新画面
// ======================
function screen_upd($array){
	if(!isset($array["id"])){ return; }
	$row = get_data($array["id"]);
?>
	<!-- メニュー -->
	<?php disp_menu(); ?>
	<h3>更新画面</h3>

	<!--　更新フォーム --> 
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<table border="1">
			<tr>
				<td>id</td>
				<td><?=$row["id"]?></td>
			</tr>
			<tr>
				<td>内容</td>
				<td><input type="text" name="s_content" value="<?=$row["s_content"]?>" size="100"></td>
			</tr>
			<tr>
				<td>場所</td>
				<td><input type="text" name="s_place" value="<?=$row["s_place"]?>" size="50"></td>
			</tr>
			<tr>
				<td>開始日時</td>
				<td><input type="datetime-local" name="s_begin" value="<?=$row["s_begin"]?>">
			</tr>
			<tr>
				<td>終了日時</td>
				<td><input type="datetime-local" name="s_end" value="<?=$row["s_end"]?>">
			</tr>
			<tr>
				<td> </td>
				<td><input type="submit" value="更新確認" name="sub1"></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?=$row["id"]?>">
		<input type="hidden" name="act" value="updconf">
	</form>
<?php
}

// =======================
// 更新確認画面
// =======================
function screen_updconf($row){
	if(!chk_data($row)) { return ;}
?>
	<!-- メニュー -->
	<?php disp_menu(); ?>
	<h3>更新確認画面</h3>

	<!-- 更新データ確認表示 -->
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<table border="1">
			<tr>
				<td>内容</td>
				<td><?=$row["s_content"]?></td>
			</tr>
			<tr>
				<td>場所</td>
				<td><?=$row["s_place"]?></td>
			</tr>
			<tr>
				<td>開始日時</td>
				<td><?=$row["s_begin"]=str_replace("T", " ", $row["s_begin"])?></td>
			</tr>
			<tr>
				<td>終了日時</td>
				<td><?=$row["s_end"]=str_replace("T", " ", $row["s_end"])?></td>
			</tr>
			<tr>
				<td> </td>
				<td><input type="submit" value="更新実行" name="sub1"></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?=$row["id"]?>">
		<input type="hidden" name="s_begin" value="<?=$row["s_begin"]?>">
		<input type="hidden" name="s_end" value="<?=$row["s_end"]?>">
		<input type="hidden" name="s_content" value="<?=$row["s_content"]?>">
		<input type="hidden" name="s_place" value="<?=$row["s_place"]?>">
		<input type="hidden" name="act" value="dojob">
		<input type="hidden" name="kbn" value="upd">
	</form>
<?php
}

// ===================
// 削除確認画面
// ====================
function screen_delconf($array){
	if(!isset($array["id"])){return; }
	$row = get_data($array["id"]);
?>
	<!-- メニュー　-->
	<?php disp_menu(); ?>
	<h3>削除確認画面</h3>

	<!-- 削除データ確認画面 -->
	<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
		<table border="1">
			<tr>
				<td>id</td>
				<td><?=$row["id"]?></td>
			</tr>
			<tr>
				<td>内容</td>
				<td><?=cnv_dispstr($row["s_content"])?></td>
			</tr>
			<tr>
				<td>場所</td>
				<td><?=cnv_dispstr($row["s_place"])?></td>
			</tr>
			<tr>
				<td>開始日時</td>
				<td><?=$row["s_begin"]?></td>
			</tr>
			<tr>
				<td>終了日時</td>
				<td><?=$row["s_end"]?></td>
			</tr>
			<tr>
				<td> </td>
				<td><input type="submit" value="削除実行実行" name="sub1"></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?=$row["id"]?>">
		<input type="hidden" name="act" value="dojob">
		<input type="hidden" name="kbn" value="del">
	</form>
<?php
}

// ===================
// 処理完了画面
// ===================
function screen_dojob($array){
	$res_mes = db_update($array);
?>
	<!-- メニュー -->
	<p><?php disp_menu(); ?>
	<h3>処理完了画面</h3>
	<!-- 処理結果表示 -->
	<table border="0" bgcolor="pink">
		<tr>
			<td>処理結果</td>
			<td><?=$res_mes; ?></td>
		</tr>
	</table>
<?php
}

// =======================
// ユーザー権限チェック
// =======================
function chk_auth($array){
	if(isset($_POST["s_id"]) and isset($_POST["s_pass"])) {
		if($_POST["s_id"] == LOGINID and $_POST["s_pass"] == LOGINPASS) {
			$_SESSION["auth"] = AUTHADMIN;
			return TRUE;
		} else {
			return FALSE;
		}
	} else {
		if(!isset($_SESSION["auth"])) {
			return FALSE;
		} else {
			if($_SESSION["auth"] == AUTHADMIN) {
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
}

// =====================
// 登録データチェック
// =====================
function chk_data($array) {

	$strerr = "";
	if($array["s_begin"] == "") {
		echo "<p>開始日時が入力されていません";
		$strerr = "1";
	}
	if($array["s_end"] == "") {
		echo "<p>終了日時が入力されていません";
		$strerr = "1";
	}
	if($array["s_content"] == "") {
		echo "<p>内容が入力されていません";
		$strerr = "1";
	}
	if($array["s_place"] == "") {
		echo "<p>場所が入力されていません";
		$strerr = "1";
	}
	if($strerr == "1"){
		return FALSE;
	} else {
		return TRUE;
	}
}

// =================
// 配列データを一括変換
// =================
/*
使えねーよカス
function cnv_formstr($array){
	foreach($array as $k => $v){
		//「magic_quotes_gpc = On」の時はエスケープ解除
		if(get_magic_quotes_gpc()) {
			$v = stripslashes($v);
		}
		$v = htmlspecialchars($v);
		$array[$k] = $v;
	}
	return $array;
}
*/
function cnv_formstr($array){
    foreach($array as $k => $v){
        // マジッククォートが有効であればエスケープ解除
        if (ini_get('magic_quotes_gpc')) {
            $v = stripslashes($v);
        }
        $v = htmlspecialchars($v);
        $array[$k] = $v;
    }
    return $array;
}

// =======================
// データをSQL用に変換
// =======================
function cnv_sqlstr($string) {
	// 文字コードを変換する
	$det_enc = mb_detect_encoding($string, "UTF-8, EUC_JP, SJIS");
	if($det_enc and $det_enc != ENCDB){
		$string = mb_convert_encoding($string, ENCDB, $det_enc);
	}
	//バックスラッシュを付加する
	$string = addslashes($string);
	return $string;
}

// =====================
// 表示する文字コードに変換
// =====================
function cnv_dispstr($string) {
	//文字コードを変換する
	$det_enc = mb_detect_encoding($string, "UTF-8, EUC-JP, SJIS");
	if($det_enc and $det_enc != ENCDISP){
		return mb_convert_encoding($string, ENCDISP, $det_enc);
	} else {
		return $string;
	}
}


// ================================
// 指定データ抽出
// ================================
function get_data($id){
	global $conn;

	//指定データ数を抽出する
	$sql = "SELECT * FROM scheduledata";
	$sql .= " WHERE (id = ".cnv_sqlstr($id).")";
	$res = db_query($sql, $conn);
	$row = $res->fetch_array(MYSQLI_ASSOC);

	return $row;
}

// ====================
// データ一覧表示
// ====================
function disp_alldata($key, $p ,$week) {
	global $conn;

	//表示するデータの位置
	$st = ($p - 1) * intval(ADMINPAGESIZE);
		//データ抽出SQL作成
		$sql = "SELECT * FROM scheduledata";
		if (strlen($key) > 0) {
				$sql .= " WHERE (s_content LIKE '%" . cnv_sqlstr($key) . "%')";
			// 曜日での絞り込み条件を追加
			if ($week!=null) {
				$sql .= " AND DAYOFWEEK(s_begin) = " . intval($week);
			}
		}
		// 曜日での絞り込み
		else if (strlen($key) == 0&&$week!=null) {
			$sql .= " WHERE DAYOFWEEK(s_begin) = " . intval($week);
		}

	$sql .= " ORDER BY s_begin ASC LIMIT $st, " . intval(ADMINPAGESIZE);
		//データ抽出
		$res = db_query($sql, $conn);
		if($res->num_rows <= 0) {
			echo "<p>データは登録されていません";
			return;
		}




?>
	<table border="1">
		<tr>
			<td> </td>
			<td>内容</td>
			<td>場所</td>
			<td>開始日時</td>
			<td>終了日時</td>
		</tr>
		<?php while($row = $res->fetch_array(MYSQLI_ASSOC)) { ?>
		<tr>
			<td>
				<table>
					<tr>
						<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
						<td><input type="submit" value="更新"></td>
						<!-- 管理項目 --> 
						<input type="hidden" name="act" value="upd">
						<!-- キー　-->
						<input type="hidden" name="id" value="<?=$row["id"]?>">
						</form>
						<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
						<td width="50%"><input type="submit" value="削除"></td>
						<!-- 管理項目 -->
						<input type="hidden" name="act" value="delconf">
						<!-- キー -->
						<input type="hidden" name="id" value="<?=$row["id"]?>">
						</form>
					</tr>
				</table>
			</td>
			<td><?=cnv_dispstr($row["s_content"])?></td>
			<td><?=cnv_dispstr($row["s_place"])?></td>
			<td><?=date("Y/m/d H:i", strtotime($row["s_begin"]))?></td>
			<td><?=date("Y/m/d H:i", strtotime($row["s_end"]))?></td>
		</tr>
		<?php } ?>
	</table>
	<!-- 前後ページへのリンク　-->
	<?php disp_pagenav($key, $p); ?>
<?php
}

function disp_weekdata($key, $p ,$weeks) {
	global $conn;
	global $mode;
	
	if($weeks==null){
		$weeks=0;
	}
	//表示するデータの位置
	$st = ($p - 1) * intval(ADMINPAGESIZE);
	$tmp = "SELECT
            CURDATE() + INTERVAL ($weeks * 7) - WEEKDAY(CURDATE()) - 1 DAY as sunday,
            CURDATE() + INTERVAL ($weeks * 7) - WEEKDAY(CURDATE()) + 5 DAY as saturday,
            YEAR(CURDATE() + INTERVAL ($weeks * 7) - WEEKDAY(CURDATE()) - 1 DAY) as selected_year";
	$stof = mysqli_fetch_assoc(db_query($tmp, $conn));
	$sql = "SELECT * FROM scheduledata WHERE s_begin BETWEEN '{$stof['sunday']}' AND DATE_ADD('{$stof['saturday']}', INTERVAL 1 DAY)";
		if (strlen($key) > 0) {
				$sql .= " AND (s_content LIKE '%" . cnv_sqlstr($key) . "%')";
		}
	$sql .= " ORDER BY s_begin ASC LIMIT $st, " . intval(ADMINPAGESIZE);
		//データ抽出
		$res = db_query($sql, $conn);
		echo $stof['sunday'] . "~" . $stof['saturday'];
		if($res->num_rows <= 0) {
			echo "<p>データは登録されていません";
		}
?>
<?php if($res->num_rows > 0) {?>
	<table border="1">
		<tr>
			<td> </td>
			<td>内容</td>
			<td>場所</td>
			<td>開始日時</td>
			<td>終了日時</td>
		</tr>
		<?php while($row = $res->fetch_array(MYSQLI_ASSOC)) { ?>
		<tr>
			<td>
				<table>
					<tr>
						<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
						<td><input type="submit" value="更新"></td>
						<!-- 管理項目 --> 
						<input type="hidden" name="act" value="upd">
						<!-- キー　-->
						<input type="hidden" name="id" value="<?=$row["id"]?>">
						</form>
						<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
						<td width="50%"><input type="submit" value="削除"></td>
						<!-- 管理項目 -->
						<input type="hidden" name="act" value="delconf">
						<!-- キー -->
						<input type="hidden" name="id" value="<?=$row["id"]?>">
						</form>
					</tr>
				</table>
			</td>
			<td><?=cnv_dispstr($row["s_content"])?></td>
			<td><?=cnv_dispstr($row["s_place"])?></td>
			<td><?=date("Y/m/d H:i", strtotime($row["s_begin"]))?></td>
			<td><?=date("Y/m/d H:i", strtotime($row["s_end"]))?></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
	<!-- 前後ページへのリンク　-->
	<?php disp_weekpagenav($key, $p); ?>
	<table>
		<tr>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="<<前の週"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="weeks" value="<?=$weeks-1?>">
				<input type="hidden" name="mode" value="<?=$mode=1?>">
				</form>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="今週"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="weeks" value="0">
				<input type="hidden" name="mode" value="<?=$mode=1?>">
				</form>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="次の週>>"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="weeks" value="<?=$weeks+1?>">
				<input type="hidden" name="mode" value="<?=$mode=1?>">
				</form>
				
				
		</tr>
	</table>
<?php
}

function disp_monthsdata($key, $p ,$years,$months) {
	global $conn;
	global $mode;
	
	if($months==null){
		$months=0;
	}
	//表示するデータの位置
	$st = ($p - 1) * intval(ADMINPAGESIZE);
	
	$sql = "SELECT * FROM scheduledata WHERE YEAR(s_begin) = $years AND MONTH(s_begin) = $months";
	$sql .= " ORDER BY s_begin ASC LIMIT $st, " . intval(ADMINPAGESIZE);
		//データ抽出
		$res = db_query($sql, $conn);
		if($res->num_rows <= 0) {
			echo "<p>データは登録されていません";
		}
?>
<?php if($res->num_rows > 0) {?>
	<table border="1">
		<tr>
			<td> </td>
			<td>内容</td>
			<td>場所</td>
			<td>開始日時</td>
			<td>終了日時</td>
		</tr>
		<?php while($row = $res->fetch_array(MYSQLI_ASSOC)) { ?>
		<tr>
			<td>
				<table>
					<tr>
						<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
						<td><input type="submit" value="更新"></td>
						<!-- 管理項目 --> 
						<input type="hidden" name="act" value="upd">
						<!-- キー　-->
						<input type="hidden" name="id" value="<?=$row["id"]?>">
						</form>
						<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
						<td width="50%"><input type="submit" value="削除"></td>
						<!-- 管理項目 -->
						<input type="hidden" name="act" value="delconf">
						<!-- キー -->
						<input type="hidden" name="id" value="<?=$row["id"]?>">
						</form>
					</tr>
				</table>
			</td>
			<td><?=cnv_dispstr($row["s_content"])?></td>
			<td><?=cnv_dispstr($row["s_place"])?></td>
			<td><?=date("Y/m/d H:i", strtotime($row["s_begin"]))?></td>
			<td><?=date("Y/m/d H:i", strtotime($row["s_end"]))?></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
<!-- 前後ページへのリンク　-->
<?php disp_monthpagenav($key, $p); ?>
	<table>
		<tr>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="<<前の週"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="weeks" value="<?=$weeks-1?>">
				<input type="hidden" name="mode" value="<?=$mode=1?>">
				</form>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="今週"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="weeks" value="0">
				<input type="hidden" name="mode" value="<?=$mode=1?>">
				</form>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="次の週>>"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="weeks" value="<?=$weeks+1?>">
				<input type="hidden" name="mode" value="<?=$mode=1?>">
				</form>
				
				
		</tr>
	</table>
<?php
}

// ========================
// メニュー表示
// ========================
function disp_menu() {
?>
	<table>
		<tr>
			<td><b><?=ADMINAPPNAME?></b></td>
			<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
			<td><input type="submit" value="登録画面へ"></td>
			<input type="hidden" name="act" value="ent">
			</form>
			<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
			<td><input type="submit" value="検索画面へ"></td>
			<input type="hidden" name="act" value="src">
			</form>
		</tr>
	</table>
<?php
}

// =======================
// 前後ページへのリンク表示
// =======================
function disp_pagenav($key, $p = 1) {
	global $conn;
	global $week;
	global $mode;
	//前後ページ番号を取得
	$prev = $p - 1;
	$prev = ($prev < 1) ? : $prev;
	$next = $p + 1;

	//全データ数を取得する
	$sql = "SELECT COUNT(*) AS cnt FROM scheduledata";
	if (strlen($key) > 0) {
		$sql .= " WHERE (s_content LIKE '%" . cnv_sqlstr($key) . "%')";
		// 曜日での絞り込み条件を追加
		if ($week!=null) {
			$sql .= " AND DAYOFWEEK(s_begin) = " . intval($week);
		}
	}	
	// 曜日での絞り込み
	else if (strlen($key) == 0&&$week!=null) {
		$sql .= " WHERE DAYOFWEEK(s_begin) = " . intval($week);
	}
	$res = db_query($sql, $conn) or die("データ抽出エラー");
	$row = $res->fetch_array(MYSQLI_ASSOC);
	$recordcount = $row["cnt"];
?>
	<table>
		<tr>
			<?php if ($p > 1) { ?>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="<< 前"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="p" value="<?=$prev?>">
				<input type="hidden" name="key" value="<?=$key?>">
				<input type="hidden" name="mode" value="<?=$mode?>">
				</form>
			<?php } ?>
			<?php if($recordcount > ($next - 1) * intval(ADMINPAGESIZE)) { ?>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td width="50%"><input type="submit" value="次 >>"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="p" value="<?=$next?>">
				<input type="hidden" name="key" value="<?=$key?>">
				<input type="hidden" name="mode" value="<?=$mode?>">
				</form>
			<?php } ?>
		</tr>
	</table>
<?php
}

function disp_weekpagenav($key, $p = 1) {
	global $conn;
	global $weeks;
	global $mode;
	if($weeks==null){
		$weeks=0;
	}
	//前後ページ番号を取得
	$w_prev = $p - 1;
	$w_prev = ($w_prev < 1) ? : $w_prev;
	$w_next = $p + 1;

	//全データ数を取得する
	$sql = "SELECT COUNT(*) AS cnt FROM scheduledata WHERE s_begin >= CURDATE()+($weeks*7) - INTERVAL WEEKDAY(CURDATE()+($weeks*7))+1 DAY AND s_begin < DATE_ADD(CURDATE()+($weeks*7) - INTERVAL WEEKDAY(CURDATE()+($weeks*7))+1 DAY, INTERVAL 1 WEEK)";
	if(isset($key)) {
		if(strlen($key) > 0) {
			$sql .= " AND (s_content LIKE '%" . cnv_sqlstr($key) . "%')";
		}
	}
	$res = db_query($sql, $conn) or die("データ抽出エラー");
	$row = $res->fetch_array(MYSQLI_ASSOC);
	$recordcount = $row["cnt"];
?>
	<table>
		<tr>
			<?php if ($p > 1) { ?>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td><input type="submit" value="<< 前"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="p" value="<?=$w_prev?>">
				<input type="hidden" name="key" value="<?=$key?>">
				<input type="hidden" name="mode" value="<?=$mode?>">
				</form>
			<?php } ?>
			<?php if($recordcount > ($w_next - 1) * intval(ADMINPAGESIZE)) { ?>
				<form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
				<td width="50%"><input type="submit" value="次 >>"></td>
				<input type="hidden" name="act" value="src">
				<input type="hidden" name="p" value="<?=$w_next?>">
				<input type="hidden" name="key" value="<?=$key?>">
				<input type="hidden" name="mode" value="<?=$mode?>">
				</form>
			<?php } ?>
		</tr>
	</table>
<?php
}


// =====================\
// db接続
// ========================
function db_conn(){
	$conn = new mysqli(DBSV, DBUSER, DBPASS, DBNAME);
	if($conn->connect_error){
		error_log($conn->connect_error);
		exit;
	}
	$conn->set_charset("utf8mb4");
	return $conn;
}

// ============
// SQL実行
// ==============
function db_query($sql, $conn){
	$res = $conn->query($sql);
	return $res;
}

// =====================
// db更新
// ======================
function db_update($array) {
	global $conn;
	global $dt;
	if(!isset($array["kbn"])) { return "パラメータエラー"; }
	if($array["kbn"] != "del") {
		if(!chk_data($array)) { return "パラメータエラー"; }
	}
	if($array["kbn"] != "ent") {
		if(!isset($array["id"])) { return "パラメータエラー"; }
	}

	extract($array);

	//データ追加
	if($kbn == "ent") {
		$sql = "INSERT INTO scheduledata (";
		$sql .= "s_begin, ";
		$sql .= "s_end, ";
		$sql .= "s_content, ";
		$sql .= "s_place";
		$sql .= ") VALUES (";
		$sql .= "'" . cnv_sqlstr($s_begin) . "',";
		$sql .= "'" . cnv_sqlstr($s_end) . "',";
		$sql .= "'" . cnv_sqlstr($s_content) . "',";
		$sql .= "'" . cnv_sqlstr($s_place) . "'";
		$sql .= ")";

		$res = db_query($sql, $conn);
		if($res) {
			return "登録完了";
		} else {
			return "登録失敗";
		}
	}

	//データ変更
	if($kbn == "upd"){
		$sql = "UPDATE scheduledata SET ";
		$sql .= " s_begin = '" . cnv_sqlstr($s_begin) . "',";
		$sql .= " s_end = '" . cnv_sqlstr($s_end) . "',";
		$sql .= " s_content = '" . cnv_sqlstr($s_content) . "',";
		$sql .= " s_place = '" . cnv_sqlstr($s_place) . "'";
		$sql .= " WHERE id = " . cnv_sqlstr($id);

		$res = db_query($sql, $conn);
		if($res) {
			return "更新完了";
		} else {
			return "更新失敗";
		}
	}

	//データ削除
	if($kbn == "del") {
		$sql = "DELETE FROM scheduledata ";
		$sql .= "WHERE id = " . cnv_sqlstr($id);

		$res = db_query($sql, $conn);
		if($res){
			return "削除完了";
		} else {
			return "削除失敗";
		}
	}
}

//　=======================
// db接続解除
// =======================
function db_close($conn) {
	//接続を解除する
	$conn->close();
}
?>
