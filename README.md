<h1 align="center">tinymeng/tools</h1>
<p align="center">
<a href="https://scrutinizer-ci.com/g/majiameng/tools/?branch=master"><img src="https://scrutinizer-ci.com/g/majiameng/tools/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/majiameng/tools/build-status/master"><img src="https://scrutinizer-ci.com/g/majiameng/tools/badges/build.png?b=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/tinymeng/tools"><img src="https://poser.pugx.org/tinymeng/tools/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/tinymeng/tools"><img src="https://poser.pugx.org/tinymeng/tools/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/tinymeng/tools"><img src="https://poser.pugx.org/tinymeng/tools/v/unstable" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/tinymeng/tools"><img src="https://poser.pugx.org/tinymeng/tools/license" alt="License"></a>
</p>

为自己其他组件创造共有的轮子，一些简单使用的小工具。

欢迎 Star，欢迎 PR！

> 大家如果有问题要交流，就发在这里吧： [Tools](https://github.com/majiameng/tools/issues/1) 交流 或发邮件 666@majiameng.com



# PHP Tools Class


## 1.安装
> composer require tinymeng/tools  -vvv


* 2.1 HTTP请求工具类
* 2.2 中英文装换工具类
* 2.3 字符串加密解密算法
* 2.4 异步执行
* 2.5 :date: 中国农历（阴历）与阳历（公历）转换与查询工具
* 文件日志读写
* 字符串处理
* 递归数组处理

#### 2.1.HttpRequest Class
> Use curl implementation request,Support uploading pictures and custom header !

```php
<?php
use tinymeng\tools\HttpRequest;

    $data = array(
        'username'=>'majiameng',
        'password'=>'majiameng',
    );
    $url = 'http://majiameng.com/login';
    //1.Curl Post Request
    $response = HttpRequest::httpPost($url,$data);
    //2.Curl Post File Request
    //<input name="file" type="file">
    $data = array(
        'file' => new \CURLFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name']),
    );
    $response = HttpRequest::httpPost($url,$data);
    //3.Curl Get Request
    $response = HttpRequest::httpGet($url,$data);

```

#### 2.2.ChineseChar Class

> 中文转拼音类库

```php

use tinymeng\tools\ChineseChar;
    /**
     * Description:  获取字符串的首字母
     * 例如：getChineseFirstChar('我是作者') 首字符全部字母+小写
     * return "wo"
     *
     * 例如：getChineseFirstChar('我是作者',true) 首字符首字母+小写
     * return "w"
     *
     * 例如：getChineseFirstChar('我是作者',true,true) 首字符首字母+大写
     * return "W"
     *
     * 例如：getChineseFirstChar('我是作者',false,true) 首字符全部字母+大写
     * return "WO"
     */
    $str = '我是作者';
    ChineseChar::getChineseFirstChar($str);
    
    
    /**
     * Description:  将字符串转换成拼音字符串
     * 例如：getChineseChar('我是作者'); 全部字符串+小写
     * return "wo shi zuo zhe"
     *
     * 例如：getChineseChar('我是作者',true); 首字母+小写
     * return "w s z z"
     *
     * 例如：getChineseChar('我是作者',true,true); 首字母+大写
     * return "W S Z Z"
     *
     * 例如：getChineseChar('我是作者',false,true); 首字母+大写
     * return "WO SHI ZUO ZHE"
     */
    $str = '我是作者';
    ChineseChar::getChineseChar($str);

```


#### 2.3.Encryption Class

> 字符串加密解密算法 String Encryption and Decryption Algorithms

```php
use tinymeng\tools\Encryption;
$key = 'tinymeng';//secret key                    

//1.encode
$content = "hellow word!";//Content to be encrypted
$content = Encryption::authcode($content,'encode',$key);
var_dump($content);//Encrypted content
//$content = 5797GYDPx0tBkgEV8Dnk183p43qX0HIkjiklLv7Os78tDWxnwpbmGDo

//2.decode
$string = Encryption::authcode($content,'decode',$key);
var_dump($string);//Decrypted content
//$string = hellow word!

```


#### 2.4 异步执行
```php
use tinymeng\tools\async\AsyncHook;

//异步执行
AsyncHook::hook([CommonService::class, 'sendMsgEmailTinymeng'], [$content,$title,$address]);
```


#### 2.5 :date: 中国农历（阴历）与阳历（公历）转换与查询工具

- 详细文档请查看 [国农历（阴历）与阳历（公历）转换](https://github.com/majiameng/tools/blob/master/Chinese_Calendar_README.md)  

```php
use tinymeng\tools\Calendar;

date_default_timezone_set('PRC'); 

$calendar = new Calendar();

$result = $calendar->solar(2017, 5, 5); // 阳历
$result = $calendar->lunar(2017, 4, 10); // 阴历
$result = $calendar->solar(2017, 5, 5, 23) // 阳历，带 $hour 参数
```

#### 查看 [tools升级日志](https://github.com/majiameng/tools/blob/master/Update_README.md)


> 大家如果有问题要交流，就发在这里吧： [Tools](https://github.com/majiameng/tools/issues/1) 交流 或发邮件 666@majiameng.com
