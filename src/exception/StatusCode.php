<?php
/**
 * 公共返回方法
 * Author: JiaMeng <666@majiameng.com>
 * Date: 2017/11/23
 * Time: 17:38
 */
namespace tinymeng\tools\exception;

class StatusCode
{
    /**
     * 公共状态码
     */
    const COMMON_SUCCESS = 200;//成功
    const COMMON_UNKNOWN = 400;//未知错误
    const COMMON_REQUEST_METHOD = 401;//错误请求(请求方式错误)
    const COMMON_HEADER_MISS_PARAM = 402;//缺失头信息
    const COMMON_ACCESS_BARRED = 403;//禁止访问
    const COMMON_NOT_REQUEST = 404;//请求不存在
    const COMMON_TINYMENG_REQUEST_METHOD = 405;//站外链接请求错误

    /**
     * 未授权 420
     */
    const COMMON_TOKEN_INVALID = 421;//token无效
    const COMMON_SIGN_ERROR = 422;//签名错误
    const COMMON_NO_ACCESS = 423;//没有权限

    /**
     * 数据错误 430
     */
    const COMMON_PARAM_INVALID = 431;//参数无效
    const COMMON_PARAM_MISS = 432;//参数缺失
    const COMMON_PARAMS_VERIFY_ERROR = 433;//字段验证失败
    const COMMON_CAPTCHA_INVALID = 434;//验证码错误
    const COMMON_NO_DATA_EXIST = 435;//数据不存在
    const COMMON_DATA_EXIST = 436;//数据已存在
    const COMMON_SAVE_FAILURE = 437;//存储失败

    /**
     * 用户错误码 440
     */
    const COMMON_NOT_ENTERED_PASSWORD = 440;//未输入密码
    const COMMON_PASSWORD_INVALID = 441;//密码错误

    /**
     * 系统状态码 300000
     */
    const USER_STOP_USE = 300105;//用户停止使用
    const USER_SYSTEM_UPDATE = 300109;//系统升级

    public static $status_code = [
        //公共错误码
        self::COMMON_SUCCESS => 'success',
        self::COMMON_UNKNOWN => 'unknown',
        self::COMMON_REQUEST_METHOD => 'request method',
        self::COMMON_HEADER_MISS_PARAM => 'header miss param',
        self::COMMON_ACCESS_BARRED => 'access barred',
        self::COMMON_NOT_REQUEST => 'not request',
        self::COMMON_TINYMENG_REQUEST_METHOD => 'Out of site link request error',

        self::COMMON_TOKEN_INVALID => 'token invalid',
        self::COMMON_SIGN_ERROR => 'sign error',
        self::COMMON_NO_ACCESS => 'no access',

        self::COMMON_PARAM_INVALID => 'param invalid',
        self::COMMON_PARAM_MISS => 'param miss',
        self::COMMON_PARAMS_VERIFY_ERROR => 'params verify error',
        self::COMMON_CAPTCHA_INVALID => 'captcha invalid',
        self::COMMON_NO_DATA_EXIST => 'no data exist',
        self::COMMON_DATA_EXIST => 'data exist',
        self::COMMON_SAVE_FAILURE => 'save failure',

        self::COMMON_NOT_ENTERED_PASSWORD => 'not entered password',
        self::COMMON_PASSWORD_INVALID => 'password invalid',
        self::USER_STOP_USE => 'user stop use',
        self::USER_SYSTEM_UPDATE => 'system update',
    ];

}