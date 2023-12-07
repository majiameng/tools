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

    public function __construct($config=null){
        $this->config = $config;
    }

    private function __clone(){}

    public function __sleep(): array
    {
        //重写__sleep方法，将返回置空，防止序列化反序列化获得新的对象
        return [];
    }

    protected static function init($gateway, $config=null)
    {
        if (!self::$instance instanceof static) {
            self::$instance = new static($config);
        }
        return self::$instance;
    }

    /**
     * Description:  __callStatic
     * @author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param $gateway
     * @param $config
     * @return mixed
     */
    public static function __callStatic($gateway, $config=null)
    {
        return self::init($gateway, ...$config);
    }

}
