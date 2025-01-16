<?php
namespace tinymeng\tools\core;

/**
 * 单例
 */
trait Singleton
{
    private $config;

    /**
     * @var null
     */
    private static $instance = null;

    public function __construct($config=[]){
        $this->config = $config;
    }

    private function __clone(){}

    public function __sleep(): array
    {
        //重写__sleep方法，将返回置空，防止序列化反序列化获得新的对象
        return [];
    }

    protected static function init($gateway, $config=[])
    {
        if (!self::$instance instanceof static) {
            self::$instance = new static($config);
        }
        return self::$instance;
    }

    /**
     * Description:  __callStatic
     * @param $gateway
     * @param array $config
     * @return Singleton|null
     *@author: JiaMeng <666@majiameng.com>
     * Updater:
     */
    public static function __callStatic($gateway, array $config=[])
    {
        return self::init($gateway, ...$config);
    }

}
