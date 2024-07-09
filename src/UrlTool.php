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

        //过滤本地ip形式
        if (!$host || in_array($host,['127.0.0.1','localhost']) || strncmp($host, "192.168.", 8) === 0) {
            return '';
        }

        $parts = explode('.', $host);
        $count = count($parts);
        if ($count > 2) {
            // 假设主域名至少有两个部分（例如：example.com）
            return implode('.', array_slice($parts, -2)); // 是子域名只返回主域名
        } elseif ($count == 2) {
            return $host;
        } else {
            return '';
        }
    }
}
