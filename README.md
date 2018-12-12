PHP Tools Class
===============

# PHP Tools Class


## 1.安装
> composer require tinymeng/tools dev-master


* HTTP请求工具类
* 中英文装换工具类

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
    //Curl Post Request
    $response = HttpRequest::httpPost($url,$data);
    //Curl GET Request
    $response = HttpRequest::httpGet($url);

```

#### 2.2.ChineseChar Class

> 中文转拼音类库

```php

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


