PHP Tools Class
===============

# PHP Tools Class


## 1.安装
> composer require tinymeng/tools  -vvv


* HTTP请求工具类
* 中英文装换工具类
* 字符串加密解密算法

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

```
<?php

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
<?php
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
```
<?php
use tinymeng\tools\async\AsyncHook;

//异步执行
AsyncHook::hook([CommonService::class, 'sendMsgEmailTinymeng'], [$content,$title,$address]);
```

### 版本修复

2021-07-21 更新以下功能
Tag v1.1.6
```
1.添加file move功能
```

2020-11-12 更新以下功能
Tag v1.1.3
```
1.修改TinymengException异常类
```