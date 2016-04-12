<?php
header("Content-Type:text/html;charset=UTF-8");
require_once "config.php";
require_once "functions.php";
require_once "Email.php";

echo "First：";
$data = setData($chong, $top);
echo $data[0][5]." => ".$data[0][0],$data[0][1],$data[0][2],$data[0][3],$data[0][4]." => ".$data[0][6];
equal($data, "First");
$data = getArr($data);
$starcao = "";

foreach($data as $k => $v)
{
	$starcao .= disPlay("First", $v, $series, $total)."<br />";
}
echo "<br />".$starcao;

echo "<br /><br />Second：";
$data = setData($jiang, $top);
echo $data[0][5]." => ".$data[0][0],$data[0][1],$data[0][2],$data[0][3],$data[0][4]." => ".$data[0][6];
equal($data, "Second");
$data = getArr($data);
$starcao = "";

foreach($data as $k => $v)
{
	$starcao .= disPlay("Second", $v, $series, $total)."<br />";
}
echo "<br />".$starcao;

echo "<br /><br />Third：";
//$data = setXJHtml($xinHtml, $top);
$data = setXJXml($xinXml, $top);
echo $data[0][5]." => ".$data[0][0],$data[0][1],$data[0][2],$data[0][3],$data[0][4]." => ".$data[0][6];
equal($data, "Third");
$data = getArr($data);
$starcao = "";

foreach($data as $k => $v)
{
	$starcao .= disPlay("Third", $v, $series, $total)."<br />";
}
echo "<br />".$starcao;

xinTotal($xinTotal, $numTotal);