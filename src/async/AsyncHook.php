<?php
namespace tinymeng\tools\async;

class AsyncHook{

    /**
     * @var array
     */
    private static $hook_list = array();
    /**
     * @var bool
     */
    private static $hooked = false;


    /**
     * hook函数 fastcgi_finish_request执行
     * @param callback $callback
     * @param array $params
     */
    public static function hook(callable $callback, $params) {
        self::$hook_list[] = array('callback' => $callback, 'params' => $params);
        if(self::$hooked == false) {
            self::$hooked = true;
            //注册一个callback当前在脚本执行完后执行
            register_shutdown_function(array(__CLASS__, '__run'));
        }
    }

    /**
     * 由系统调用
     * @return void
     */
    private static function __run() {
        fastcgi_finish_request();
        if(empty(self::$hook_list)) {
            return;
        }
        foreach(self::$hook_list as $hook) {
            $callback = $hook['callback'];
            $params = $hook['params'];
            call_user_func_array($callback, $params);
        }
    }

}