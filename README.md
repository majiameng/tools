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
* 2.6 文件日志读写
* 2.7 字符串处理
* 2.8 递归数组处理
* 2.9 使用openssl实现非对称加密


# Documentation

## You can find the tinymeng/tools documentation on the website. Check out the Getting Started page for a quick overview.

* [Wiki Home](https://github.com/majiameng/tools/wiki)
* [中文文档](https://github.com/majiameng/OAuth2/wiki/zh-cn-Home)

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

#### 2.6 文件日志读写

```php
use tinymeng\tools\File;

$data = [
    'name'=>'111'
];
File::writeLog($data);
File::writeLog("this is word","log");
```

error-20210822.log
```
2021-08-22 16:23:43 : {"name":"111"}
```

log-20210822.log
```
2021-08-22 16:23:43 : this is word
```

#### 2.7 字符串处理

* 手写字母大写 uFirst
* 生成随机字符串 generateRandomString
* 获取唯一设备号 createChannelId
* 获取md5中16位小写 md5Bit16
* 获取时间戳(13位精确到豪妙) millisecond
* 是否包含中文 isContainChinese
* 是否全是中文 isAllChinese
* 判断手机号码 isMobile
* 科学计数法转化正常数值输出（如 2.1E-5） sctonum
* 自动转换字符集 支持数组转换 autoCharset
* 压缩html代码 compressHtml
* html标签替换成特定小程序标签 htmlReplaceXcx
* 过滤标点符号 filterPunctuation
* 过滤html标签 stripTags

#### 2.8 递归数组处理
```
use tinymeng\tools\Tool;

$result = [
    [
        'id'=>1,
        'pid'=>0,
        'name'=>"账户管理",
    ],
    [
        'id'=>2,
        'pid'=>1,
        'name'=>"管理员管理",
    ],
    [
        'id'=>3,
        'pid'=>1,
        'name'=>"用户管理",
    ],
    [
        'id'=>4,
        'pid'=>2,
        'name'=>"添加管理员",
    ],
    [
        'id'=>5,
        'pid'=>2,
        'name'=>"删除管理员",
    ],
];
$result = Tool::getTreeStructure($result,'id','pid');
var_dump($result);
```
打印结果
```
array(1) {
  [0]=>
  array(4) {
    ["id"]=>
    int(1)
    ["pid"]=>
    int(0)
    ["name"]=>
    string(12) "账户管理"
    ["child"]=>
    array(2) {
      [0]=>
      array(4) {
        ["id"]=>
        int(2)
        ["pid"]=>
        int(1)
        ["name"]=>
        string(15) "管理员管理"
        ["child"]=>
        array(2) {
          [0]=>
          array(3) {
            ["id"]=>
            int(4)
            ["pid"]=>
            int(2)
            ["name"]=>
            string(15) "添加管理员"
          }
          [1]=>
          array(3) {
            ["id"]=>
            int(5)
            ["pid"]=>
            int(2)
            ["name"]=>
            string(15) "删除管理员"
          }
        }
      }
      [1]=>
      array(3) {
        ["id"]=>
        int(3)
        ["pid"]=>
        int(1)
        ["name"]=>
        string(12) "用户管理"
      }
    }
  }
}
```

#### 2.9.使用openssl实现非对称加密
```
$privkeypass = '95920180927';//私钥密码
$rsa = new Rsa('/data/majiameng.com/public/rsa/',$privkeypass);

//私钥加密，公钥解密
echo "待加密数据：segmentfault.com\n";
$pre = $rsa->privEncrypt("segmentfault.com");
echo "加密后的密文:\n" . $pre . "\n";
$pud = $rsa->pubDecrypt($pre);
echo "解密后数据:" . $pud . "\n";


//公钥加密，私钥解密
echo "待加密数据：segmentfault.com\n";
$pue = $rsa->pubEncrypt("segmentfault.com");
echo "加密后的密文:\n" . $pue . "\n";
$prd = $rsa->privDecrypt($pue);
echo "解密后数据:" . $prd;
```


#### 查看 [tools升级日志](https://github.com/majiameng/tools/blob/master/Update_README.md)


> 大家如果有问题要交流，就发在这里吧： [Tools](https://github.com/majiameng/tools/issues/1) 交流 或发邮件 666@majiameng.com


#### [PHP Oauth2登录](https://github.com/majiameng/OAuth2)

集成了许多第三方登录界面，包括QQ登录、微信登录、新浪登录、github登录、支付宝登录、百度登录、抖音登录、GitLab、Naver、Line、codeing、csdn、gitee等，陆续增加ing
