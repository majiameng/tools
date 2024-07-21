<?php
namespace tinymeng\tools;
/**
 * Url
 */
class UrlTool{

    /**
     * 获取url中主域名
     * @param $url
     * @return string
     */
    function getMainDomain($url) {
        $url = strtolower($url);//首先转成小写
        $host = parse_url($url, PHP_URL_HOST); // 获取host部分
        if(empty($host)){
            $url = "https://".$url;
            $host = parse_url($url,PHP_URL_HOST);
        }
        if (!$host) {
            return '';
        }
        if (in_array($host,['127.0.0.1','localhost'])) {
            return '';
        }

        // 假设主域名至少有两个部分（例如：example.com），并且不包含子域名
        $parts = explode('.', $host);
        $count = count($parts);

        /*
         *  通常情况下，主域名由最后两个部分组成
         *  但这可能不适用于所有情况，特别是当TLD是.co.uk这样的
         *  判断是否是双后缀aaa.com.cn
         */
        $preg = '/[\w].+\.(com|net|org|gov|edu)\.cn$/';
        if ($count > 2 && preg_match($preg,$host)){
            //双后缀取后3位
            $host = $parts[$count-3].'.'.$parts[$count-2].'.'.$parts[$count-1];
        } else{
            // 如果只有两个部分，则直接返回整个host作为主域名
            $host = $parts[$count-2].'.'.$parts[$count-1];
        }
        return $host;
    }
}
