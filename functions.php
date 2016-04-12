<?php
//整合数组
function getArr($data)
{
	$result = array();
	$result[] = more4($data);
	$result[] = less5($data);
	$result[] = single($data);
	$result[] = double($data);
	$result[] = less2more($data);
	$result[] = single2double($data);
	
	return $result;
}

//最新连续相等的次数
function equal($data, $sort, $cron = false)
{
	global $equal;
	$bool = array(1, 1, 1, 1, 1);
	$mark = array(1, 1, 1, 1, 1);
	$weiArr = array("W", "Q", "B", "S", "G");
	
	for($i = 1; $i < 7; $i++)
	{
		for($j = 0; $j < 5; $j++)
		{
			if($bool[$j] && $data[$i][$j] == $data[$i - 1][$j])
				$mark[$j]++;
			else
				$bool[$j] = 0;
		}
	}
	
	$starcao = "";
	foreach($mark as $k => $v)
	{
		if($cron && $v >= $equal)
			sendemail("476592125@qq.com", "equal.sinaapp.com", $sort." => ".$weiArr[$k]."：".$data[0][$k]." => ".$v);
		$starcao .= $data[0][$k]."@".$v."　";
	}
	
	if(!$cron)
		echo "<br />".$starcao;
}

//单双
function single2double($data)
{
	$bool = array(1, 1, 1, 1, 1);
	$mark = array(1, 1, 1, 1, 1, "sd");

	foreach($data as $k => $v)
	{
		if($k == 0)
			continue;
		for($i = 0; $i < 5; $i++)
		{
			$judge = ($v[$i] + $data[$k - 1][$i])%2;
			if($judge == 1 && $bool[$i])
				$mark[$i]++;
			else
				$bool[$i] = 0;
		}
	}
	return $mark;
}

//大小
function less2more($data)
{
	$bool = array(1, 1, 1, 1, 1);
	$mark = array(1, 1, 1, 1, 1, "lm");
	
	foreach($data as $k => $v)
	{
		if($k == 0)   
			continue;
		for($i = 0; $i < 5; $i++)
		{
			$judge = ($v[$i] - 4.5) * ($data[$k - 1][$i] - 4.5);
			if($judge < 0 && $bool[$i])
				$mark[$i]++;
			else
				$bool[$i] = 0;
		}
	}
	return $mark;
}

//双
function double($data)
{
	$bool = array(1, 1, 1, 1, 1);
	$mark = array(0, 0, 0, 0, 0, "d");

	foreach($data as $k => $v)
	{
		for($i = 0; $i < 5; $i++)
		{
			if($v[$i]%2 == 0 && $bool[$i])
				$mark[$i]++;
			else
				$bool[$i] = 0;
		}
	}
	return $mark;
}

//单
function single($data)
{
	$bool = array(1, 1, 1, 1, 1);
	$mark = array(0, 0, 0, 0, 0, "s");
	
	foreach($data as $k => $v)
	{
		for($i = 0; $i < 5; $i++)
		{
		if($v[$i]%2 && $bool[$i])
			$mark[$i]++;
			else
				$bool[$i] = 0;
		}
	}
	return $mark;
}

//小
function less5($data)
{
	$bool = array(1, 1, 1, 1, 1);
	$mark = array(0, 0, 0, 0, 0, "l");
	
	foreach($data as $k => $v)
	{
		for($i = 0; $i < 5; $i++)
		{
			if($v[$i] < 5 && $bool[$i])
				$mark[$i]++;
			else
				$bool[$i] = 0;
		}
	}
	return $mark;
}

//大
function more4($data)
{
	$bool = array(1, 1, 1, 1, 1);
	$mark = array(0, 0, 0, 0, 0, "m");
	
	foreach($data as $k => $v)
	{
		for($i = 0; $i < 5; $i++)
		{
			if($v[$i] > 4 && $bool[$i])
				$mark[$i]++;
			else
				$bool[$i] = 0;
		}
	}
	return $mark;
}

//获取前n条数据
/*
array(107) {
	[0]=> object(stdClass)#3 (5) {
		["phasetype"]=> string(3) "200"
		["phase"]=> string(11) "20150725115"
		["time_draw"]=> string(19) "2015-07-25 23:36:00"
		["result"]=> object(stdClass)#4 (1) {
			["result"]=> array(1) {
				[0]=> object(stdClass)#5 (2) {
					["key"]=> string(4) "ball"
					["data"]=> array(5) {
						[0]=> string(1) "0"
						[1]=> string(1) "1"
						[2]=> string(1) "2"
						[3]=> string(1) "3"
						[4]=> string(1) "4"
					}
				}
			}
		}
		["ext"]=> object(stdClass)#6 (3) {
			["ten"]=> string(62) "<span class="orange">大</span><span class="orange">双</span>"
			["unit"]=> string(34) "<span class="orange">大</span>单"
			["last"]=> string(6) "组六"
		}
	}
}
*/
function geTop($arr, $top = 15)
{
	if(empty($arr)) return array();
	$result = array();
	foreach($arr as $k => $o)
	{
		if($k < $top)
		{
			$result[$k] = $o->result->result[0]->data;
			$result[$k][] = $o->phase;
			$result[$k][] = $o->time_draw;
		}
	}
	return $result;
}

//将对象转化成数组
function obj2array($o)
{
	$ret = array();
	foreach ($o as $k => $v)
	{
		if (gettype($v) == "array" || gettype($v) == "object")
			$ret[$k] =  obj2array($v);
		else
			$ret[$k] = $v;
	}
	return $ret;
}

function setData($url, $top = 15)
{
	$data = getData($url);
	
	$data = geTop($data, $top);
	$num = count($data);
	if($num < $top)
	{
		$num = $top - $num;
		$preurl = $url."&date=".date("Y-m-d", time()-86400);
		$predata = getData($preurl);
		$predata = geTop($predata, $num);
		$data = array_merge($data, $predata);
	}
	
	return $data;
}

//获取json串
function getData($url)
{
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
	$data = curl_exec($ch);
	curl_close($ch);
	
	$data = json_decode($data);
	if($data = $data->data)
		$data = $data->data;
	else
		$data = array();
	
	return $data;
}

//新疆
function setXJHtml($url, $top = 15)
{
	$dom = new DomDocument();
	@$dom->loadHTMLFile($url);

	$table = $dom->getElementsByTagName('table')->item(1);
	$trs = $table->getElementsByTagName('tr');
	$table->removeChild($trs->item(0));

	$data = array();
	for($i = 0; $i < $top && $i < $trs->length; $i++)
	{
		$tds = $trs->item($i)->getElementsByTagName('td');
		$no = $tds->item(2)->nodeValue;
		for($j = 0; $j < 5; $j++)
		{
			$data[$i][] = $no[$j];
		}
		$data[$i][] = $tds->item(0)->nodeValue;
		$data[$i][] = $tds->item(1)->nodeValue;
	}

	return $data;
}
function setXJXml($url, $top = 15)
{
	$dom = new DomDocument();
	@$dom->load($url);
	
	$lists = $dom->getElementsByTagName('drawList')->item(0);
	$data = array();
	for($i = 0; $i < $top; $i++)
	{
		$no = $lists->getElementsByTagName('code'.$i)->item(0)->textContent;
		$data[$i] = explode("|", $no);
		$data[$i][] = $lists->getElementsByTagName('term'.$i)->item(0)->textContent;
		$data[$i][] = $lists->getElementsByTagName('drawOpenDate'.$i)->item(0)->textContent;
	}
	
	return $data;
}

function disPlay($type, $arr, $series = 12, $total = 12, $cron = 0)
{
	$weiArr = array(0 => "W", 1 => 'Q', 2 => 'B', 3 => 'S', 4 => 'G');
	$starcao = "<span style=\"width: 60px; display: block; float: left;\">（{$arr[5]}）</span><span style=\"display: block; float: left;\">";
	for($i = 0; $i < 5; $i++)
	{
		if($arr[$i] >= $series)
			$starcao .= "{$weiArr[$i]}：{$arr[$i]}　　";
		
		if($cron && $arr[$i] >= $total)
		{
			$body = "{$type}：{$weiArr[$i]} => {$arr[$i]}（{$arr[5]}）";
			sendemail("476592125@qq.com", "number.sinaapp.com", $body);
		}
	}
	
	return $starcao."</span>";
}

//新疆total
function xinTotal($url, $numTotal = 50, $cron = 0)
{
	$weiArr = array(0 => "W", 1 => 'Q', 2 => 'B', 3 => 'S', 4 => 'G');
	$dom = new DomDocument();
	@$dom->loadHTMLFile($url);

	$table = $dom->getElementsByTagName('table')->item(1);
	$trs = $table->getElementsByTagName('tr')->item(1);

	$data = array();
	for($i = 0; $i < 5; $i++)
	{
		$tb = $trs->getElementsByTagName('table')->item($i);
		$num = (int)$tb->getElementsByTagName('div')->item(0)->nodeValue;
		$total = (int)$tb->getElementsByTagName('span')->item(0)->nodeValue;

		if($cron && $total >= $numTotal)
			sendemail("476592125@qq.com", "total.sinaapp.com", "Third ".$weiArr[$i].": {$num} => {$total}");

		if(!$cron)
			echo $weiArr[$i].": {$num} => {$total} \t";
	}
}