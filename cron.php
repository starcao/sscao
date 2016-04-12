<?php
require_once "config.php";
require_once "functions.php";
require_once "Email.php";
$cron = 1;

$data = setData($chong, $top);
equal($data, "First", $cron);
$data = getArr($data);
$starcao = "";
foreach($data as $k => $v)
{
	$starcao .= disPlay("First", $v, $series, $total, $cron)."<br />";
}

$data = setData($jiang, $top);
equal($data, "Second", $cron);
$data = getArr($data);
$starcao = "";
foreach($data as $k => $v)
{
	$starcao .= disPlay("Second", $v, $series, $total, $cron)."<br />";
}

//$data = setXJHtml($xinHtml, $top);
$data = setXJXml($xinXml, $top);
equal($data, "Third", $cron);
$data = getArr($data);
$starcao = "";
foreach($data as $k => $v)
{
	$starcao .= disPlay("Third", $v, $series, $total, $cron)."<br />";
}

xinTotal($xinTotal, $numTotal, $cron);