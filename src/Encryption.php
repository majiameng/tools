<?php

namespace tinymeng;
/**
 * Name: Doc.php.
 * Author: JiaMeng <666@majiameng.com>
 * Date: 2017/8/20 17:20
 * Description: Doc.php.
 */
class Encryption
{
    private $encryptMethod = 'aes-256-cbc';//openssl加密算法

    /**
     * Description:  getIv
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @return string
     * @throws \Exception
     */
    private function getIv()
    {
        return '123456';
        $ivLength = openssl_cipher_iv_length($this->encryptMethod);
        $iv = openssl_random_pseudo_bytes($ivLength, $isStrong);
        if (false === $iv && false === $isStrong) {
            throw new \Exception('IV generate failed');
        }
        return $iv;
    }

    /**
     * Description:  openssl加密
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $string 需要加密的字串
     * @param string $key 加密EKY
     * @return string
     */
    public function sslEncrypt($string = '', $key = 'tinymeng')
    {
        $iv = $this->getIv();
        return openssl_encrypt($string, $this->encryptMethod, $key, 0, $iv);
    }

    /**
     * Description:  openssl解密
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $string 需要加密的字串
     * @param string $key 加密EKY
     * @return string
     */
    public function sslDecrypt($string = '', $key = 'tinymeng')
    {
        $iv = $this->getIv();
        return openssl_decrypt($string, $this->encryptMethod, $key, 0, $iv);
    }

    /**
     * 简单对称加密算法之加密
     * @param String $string 需要加密的字串
     * @param String $skey 加密EKY
     * @return String
     */
    public static function encode($string = '', $skey = 'tinymeng')
    {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value) {
            $key < $strCount && $strArr[$key] .= $value;
        }
        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
    }

    /**
     * 简单对称加密算法之解密
     * @param String $string 需要解密的字串
     * @param String $skey 解密KEY
     * @return String
     */
    public static function decode($string = '', $skey = 'tinymeng')
    {
        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value) {
            $key <= $strCount && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        }
        return base64_decode(join('', $strArr));
    }
}