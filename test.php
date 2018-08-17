<?php
//调试
//取出存入的消息
$xmls=simplexml_load_file('content.xml');
//赋值
$toUserName=$xmls->ToUserName;
$fromUserName=$xmls->FromUserName;
$content=$xmls->Content;
//包含这个类
//include_once ("./simple_html_dom.php");

//天气
//郑州
$weathers = file_get_contents('http://flash.weather.com.cn/wmaps/xml/xinxiang.xml');//获取html
$weathers = simplexml_load_string($weathers);
//重庆
$weaths=file_get_contents('http://flash.weather.com.cn/wmaps/xml/chongqing.xml');//获取html
$weaths=simplexml_load_string($weaths);
$citys = [];
$detail = [];

foreach ($weaths as $k => $weath) {
    $citys[] = (string)$weath['cityname'];

    $detail[(string)$weath['cityname']] = (string)$weath['stateDetailed'] . ",气温:" . (string)$weath['tem1'] . "-" . (string)$weath['tem2'];

}

foreach ($weathers as $k => $weather) {
    $citys[] = (string)$weather['cityname'];

    $detail[(string)$weather['cityname']] = (string)$weather['stateDetailed'] . ",气温:" . (string)$weather['tem1'] . "-" . (string)$weather['tem2'];

}

var_dump($citys);exit;
var_dump($detail["$content"]);




