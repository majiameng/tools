<?php

namespace tinymeng\tools;

/**
 * 使用openssl实现非对称加密
 * Author: JiaMeng <666@majiameng.com>
 * Class Rsa
 */
class Rsa
{

    private $rsaPath = './';//公钥证书路径

    /**
     * Author: JiaMeng <666@majiameng.com>
     * @var null|string 私钥密码
     */
    private $privkeypass = null;
    /**
     * Author: JiaMeng <666@majiameng.com>
     * @var string 私钥
     */
    private $_privKey;

    /**
     * Author: JiaMeng <666@majiameng.com>
     * @var string 公钥
     */
    private $_pubKey;


    /**
     * Rsa constructor.
     * @param string $path 指定密钥文件地址
     * @param null $privkeypass
     * @throws \Exception
     */
    public function __construct($path = '', $privkeypass = null)
    {
        if ($path == '') {
            $path = $this->rsaPath;
        }
        if (empty($path) || !is_dir($path)) {
            throw new \Exception('请指定密钥文件地址目录');
        }
        $this->rsaPath = $path;
        $this->privkeypass = $privkeypass;
    }

    /**
     * 创建公钥和私钥
     *
     */
    public function createKey()
    {
        $config = [
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        // 生成私钥
        $rsa = openssl_pkey_new($config);
        openssl_pkey_export($rsa, $privKey, $this->privkeypass, $config);
        file_put_contents($this->rsaPath . DIRECTORY_SEPARATOR . 'priv.key', $privKey);
        // 生成公钥
        $rsaPri = openssl_pkey_get_details($rsa);
        $pubKey = $rsaPri['key'];
        file_put_contents($this->rsaPath . DIRECTORY_SEPARATOR . 'pub.key', $pubKey);
    }

    /**
     * 设置私钥
     *
     */
    public function setupPrivKey()
    {
        $file = $this->rsaPath . DIRECTORY_SEPARATOR . 'priv.key';
        $privKey = file_get_contents($file);
        $this->_privKey = openssl_pkey_get_private($privKey, $this->privkeypass);
        return true;
    }

    /**
     * 设置公钥
     *
     */
    public function setupPubKey()
    {
        $file = $this->rsaPath . DIRECTORY_SEPARATOR . 'pub.key';
        $pubKey = file_get_contents($file);
        $this->_pubKey = openssl_pkey_get_public($pubKey);
        return true;
    }

    /**
     * 用私钥加密
     *
     */
    public function privEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $this->setupPrivKey();
        $result = openssl_private_encrypt($data, $encrypted, $this->_privKey);
        if ($result) {
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * 私钥解密
     *
     */
    public function privDecrypt($encrypted)
    {
        if (!is_string($encrypted)) {
            return null;
        }
        $this->setupPrivKey();
        $encrypted = base64_decode($encrypted);
        $result = openssl_private_decrypt($encrypted, $decrypted, $this->_privKey);
        if ($result) {
            return $decrypted;
        }
        return null;
    }

    /**
     * 公钥加密
     *
     */
    public function pubEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $this->setupPubKey();
        $result = openssl_public_encrypt($data, $encrypted, $this->_pubKey);
        if ($result) {
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * Description:  公钥解密
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param $crypted
     * @return null
     */
    public function pubDecrypt($crypted)
    {
        if (!is_string($crypted)) {
            return null;
        }
        $this->setupPubKey();
        $crypted = base64_decode($crypted);
        $result = openssl_public_decrypt($crypted, $decrypted, $this->_pubKey);
        if ($result) {
            return $decrypted;
        }
        return null;
    }

}

/**
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
 */