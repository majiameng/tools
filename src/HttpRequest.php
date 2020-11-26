<?php
namespace tinymeng\tools;

use tinymeng\tools\exception\StatusCode;
use tinymeng\tools\exception\TinymengException;
/**
 * Class HttpRequest
 * @package tinymeng\tools
 * @Author: TinyMeng <666@majiameng.com>
 * @Created: 2020/11/12
 */
class HttpRequest
{
    /**
     * $proxy
     * 例: 127.0.0.1:8080
     *
     * 上传图片请求事例:
    $data = [
    'file' => new \CURLFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name']),
    ];
    \tinymeng\tools\HttpRequest::httpPost($url,$data)
     */

    /**
     * Description: POST 请求
     * Author: JiaMeng <666@majiameng.com>
     * @param string $url 请求链接
     * @param array $param 请求参数
     * @param array $httpHeaders 添加请求头
     * @param string $proxy 代理ip
     * @param int $http_code 相应正确的状态码
     * @return mixed
     * @throws \Exception
     */
    static public function httpPost($url, $param = array(), $httpHeaders = array(),$proxy='', $http_code = 200)
    {
        /** 参数检测,class或者array进行http_build_query */
        if(!empty($param) && is_array($param)){
            $flag = false;
            foreach ($param as $value){
                //判断参数是否是一个类 或者 是一个数组
                if(is_array($value) || (is_string($value) && class_exists($value))){
                    $flag = true;
                    break;
                }
            }
            if($flag == true){
                $param = http_build_query($param);
            }
        }

        $curl = curl_init();

        /** 设置请求链接 */
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        /** 设置请求参数 */
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);

        /** 设置请求headers */
        if(empty($httpHeaders)){
            $httpHeaders = array(
                "UserModel-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36",
            );
        }
        if (is_array($httpHeaders)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        }

        /** 不验证https证书和hosts */
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        }

        /** http代理 */
        if(!empty($proxy)){
            $proxy = explode(':',$proxy);
            curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
            curl_setopt($curl, CURLOPT_PROXY, "$proxy[0]"); //代理服务器地址
            curl_setopt($curl, CURLOPT_PROXYPORT,$proxy[1]); //代理服务器端口
        }

        /** 请求 */
        $content = curl_exec($curl);
        /** 获取请求信息 */
        $info = curl_getinfo($curl);
        /** 关闭请求资源 */
        curl_close($curl);

        /** 验证网络请求状态 */
        if (intval($info["http_code"]) === 0) {
            throw new TinymengException(StatusCode::COMMON_TINYMENG_REQUEST_METHOD,
                '[httpPost]: POST request was aborted ! Request url :' . $url . ' , post request data : ' . var_export($param,true)
            );
        }elseif(intval($info["http_code"]) != $http_code){
            throw new TinymengException(StatusCode::COMMON_TINYMENG_REQUEST_METHOD,
                '[httpPost]: POST request was aborted ! Request url :' . $url . ' , post request data : ' . var_export($param,true).' ,return code : '.$info["http_code"] .' ,return content : '.$content
            );
        } else {
            return $content;
        }
    }

    /**
     * Description:  GET 请求
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $url 请求链接
     * @param array $param 请求参数
     * @param array $httpHeaders 添加请求头
     * @param string $proxy
     * @param int $http_code 相应正确的状态码
     * @return mixed
     * @throws \Exception
     */
    static public function httpGet($url, $param = array(), $httpHeaders = array(),$proxy= '',  $http_code = 200)
    {
        $curl = curl_init();

        /** 设置请求参数 */
        if (!empty($param)) {
            $url = $url . '?' . http_build_query($param);
        }

        /** 设置请求链接 */
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        /** 不验证https证书和hosts */
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
        }

        /** http代理 */
        if(!empty($proxy)){
            $proxy = explode(':',$proxy);
            curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
            curl_setopt($curl, CURLOPT_PROXY, "$proxy[0]"); //代理服务器地址
            curl_setopt($curl, CURLOPT_PROXYPORT,$proxy[1]); //代理服务器端口
        }

        /** 设置请求headers */
        if(empty($httpHeaders)){
            $httpHeaders = array(
                "UserModel-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.89 Safari/537.36",
            );
        }
        if (is_array($httpHeaders)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        }

        /** 请求 */
        $content = curl_exec($curl);
        /** 获取请求信息 */
        $info = curl_getinfo($curl);
        /** 关闭请求资源 */
        curl_close($curl);

        /** 验证网络请求状态 */
        if (intval($info["http_code"]) === 0) {
            throw new TinymengException(StatusCode::COMMON_TINYMENG_REQUEST_METHOD,
                '[httpGet]: GET request was aborted ! Request url :' . $url
            );
        }elseif(intval($info["http_code"]) != $http_code){
            throw new TinymengException(StatusCode::COMMON_TINYMENG_REQUEST_METHOD,
                '[httpGet]: GET request was aborted ! Request url :' . $url .' ,return code : '.$info["http_code"] .' ,return content : '.$content
            );
        } else {
            return $content;
        }
    }

}