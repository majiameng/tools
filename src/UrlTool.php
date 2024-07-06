<?php
namespace tinymeng\tools;
/**
 * Url
 */
class UrlTool{

    /**
     * 获取url中主域名
     * @param $url
     * @return array|int|string
     */
    static function getMainDomain($url) {
        $host = parse_url($url, PHP_URL_HOST); // 获取host部分
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
         */
        if ($count > 2) {
            return implode('.', array_slice($parts, -2)); // 返回最后两个部分的组合
        } elseif ($count == 2) {
            // 如果只有两个部分，则直接返回整个host作为主域名
            return $host;
        } else {
            // 如果少于两个部分，可能不是一个有效的域名
            return '';
        }
    }
}
