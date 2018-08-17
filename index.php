<?php
/**
 *wechatphptest
 */
//echo$_GET["echostr"];//万能打通
//截取(得到)微信服务器发过来的xml消息
$comtent = file_get_contents('php://input');
//把截取的消息保存到content.xml文件中，以便调试
file_put_contents('content.xml', $comtent);
//获取微信服务器传过来的xml的消息转化为对象
$xmls = simplexml_load_string($comtent);
//取值赋值
$toUserName = $xmls->ToUserName;//公众号ID
$fromUserName = $xmls->FromUserName;//客户端发送ID
$content = $xmls->Content;//发送过来的内容


//定义图片信息
$girls = [
    ["title" => "景甜",
        "description" => "小可耐",
        "url" => "https://image.baidu.com/search/index?tn=baiduimage&ct=201326592&lm=-1&cl=2&ie=gb18030&word=%BE%B0%CC%F0&fr=ala&ala=1&alatpl=star&pos=0&hs=2&xthttps=111111",
        "picUrl" => "https://gss1.bdstatic.com/-vo3dSag_xI4khGkpoWK1HF6hhy/baike/s%3D500/sign=e02b14da7af082022992913f7bfafb8a/060828381f30e924f5f96cc845086e061c95f7ee.jpg",
    ],

    ["title" => "最美景甜",
        "description" => "小清新",
        "url" => "https://baike.baidu.com/item/%E6%99%AF%E7%94%9C/844141?fr=aladdin",
        "picUrl" => "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1534526608591&di=3bc484560912206dc5d7d0324e5121c9&imgtype=0&src=http%3A%2F%2Fs15.sinaimg.cn%2Fmiddle%2F77b5656bga866bdbc769e%26690",
    ],

];
//天气
//郑州
$weathers = file_get_contents('http://flash.weather.com.cn/wmaps/xml/xinxiang.xml');//获取html
$weathers = simplexml_load_string($weathers);
//重庆
$weaths = file_get_contents('http://flash.weather.com.cn/wmaps/xml/chongqing.xml');//获取html
$weaths = simplexml_load_string($weaths);

$citys = [];
$detail = [];
foreach ($weaths as $k => $weath) {
    $citys[] = (string)$weath['cityname'];

    $detail[(string)$weath['cityname']] = (string)$weath['stateDetailed'] . "，气温：" . (string)$weath['tem1'] . "-" . (string)$weath['tem2'];

}

foreach ($weathers as $k => $weather) {
    $citys[] = (string)$weather['cityname'];

    $detail[(string)$weather['cityname']] = (string)$weather['stateDetailed'] . ",气温:" . (string)$weather['tem1'] . "-" . (string)$weather['tem2'];

}
//开启ob缓存
ob_start();

if ($content == "美女") {
    //包含回复图片的模板
    include_once("./image.xml");
} elseif (in_array($content, $citys)) {
    //包含天气预报
    include_once("./weather.xml");
} else {
    //包含回复消息的模板
    include_once("./message.xml");
}

//取出缓存消息
$send = ob_get_contents();
//把错误信息存入error.xml文件中
file_put_contents('error.xml', $send);





