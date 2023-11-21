<?php
error_reporting(E_ALL);
ini_set("display_errors", "Off");
$file_contents = @file("data/todo.txt");
if ($file_contents == false) {
    echo("data/todo.txtを読み込め間せんでした");
    exit();
}


$todo_over_list=array();
$todo_upcoming_list = array();
$today_date = date("Y/m/d");

foreach ($file_contents as $line) {
    $line = mb_convert_encoding($line, "UTF-8", "utf-8,sjis");
    list($todo_date_str, $todo_title) = explode("\t", $line);
    $todo_date = date("Y/m/d", strtotime($todo_date_str));
    if ($todo_date < $today_date) {
        $todo_over_list[] = array("title" => $todo_title, "date" => $todo_date);
    } else {
        $todo_upcoming_list[] = array("title" => $todo_title, "date" => $todo_date);
    }
}

require_once("smarty/Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = "templates";
$smarty->compile_dir = "templates_c";
$smarty->assign("todo_over_list", $todo_over_list);
$smarty->assign("todo_upcoming_list", $todo_upcoming_list);
$smarty->display("todo.html");
