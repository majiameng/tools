<?php

namespace tinymeng\tools;

/**
 * HTTP 请求类
 */
class HttpRequest
{

    /**
     * Description: POST 请求
     * Author: JiaMeng <666@majiameng.com>
     * @param string $url 请求链接
     * @param array $param 请求参数
     * @param boolean $postFile 是否文件上传
     * @param string $userAgent 添加请求身份
     * @param array $httpHeaders 添加请求头
     * @param int $http_code 相应正确的状态码
     * @return mixed
     * @throws \Exception
     */
    static public function httpPost($url, $param = [], $postFile = false, $userAgent = '', $httpHeaders = [], $http_code = 200)
    {
        $curl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        }
        if (is_string($param) || $postFile) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $strPOST);

        //在HTTP请求中包含一个"User-Agent: "头的字符串。
        if (strlen($userAgent))
            curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);

        // array('Content-type: text/plain', 'Content-length: 100')
        if (is_array($httpHeaders))
            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);

        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        if (intval($status["http_code"]) == $http_code) {
            return $content;
        } else {
            throw new \Exception('curl , http post request was aborted ! url :' . $url . ' , Request data : ' . $strPOST);
        }
    }

    /**
     * Description:  GET 请求
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $url 请求链接
     * @param array $param 请求参数
     * @param array $httpHeaders 添加请求头
     * @param int $http_code 相应正确的状态码
     * @return mixed
     * @throws \Exception
     */
    static public function httpGet($url, $param = [], $httpHeaders = [], $http_code = 200)
    {
        if (!empty($param)) {
            $url = $url . '?' . http_build_query($param);
        }
        $curl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // array('Content-type: text/plain', 'Content-length: 100')
        if (is_array($httpHeaders))
            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        $content = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
        if (intval($status["http_code"]) == $http_code) {
            return $content;
        } else {
            throw new \Exception('curl , http get request was aborted ! url :' . $url);
        }
    }

}