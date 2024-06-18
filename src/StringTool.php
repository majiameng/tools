<?php
namespace tinymeng\tools;
/**
 * Class 字符串类
 * @package tinymeng\tools
 * @Author: TinyMeng <666@majiameng.com>
 * @Created: 2018/11/26
 */
class StringTool
{
    /**
     * Function Name: 手写字母大写
     * @param $str
     * @return string
     * @author Tinymeng <666@majiameng.com>
     * @date: 2019/9/26 10:19
     */
    static public function uFirst($str):string{
        return ucfirst(strtolower($str));
    }

    /**
     * Name: 生成随机字符串
     * Author: Tinymeng <666@majiameng.com>
     * @param int $length 字符串长度
     * @return string
     */
    public static function generateRandomString($length = 10):string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($characters), 0, $length);
    }


    /**
     * 获取唯一设备号
     * @Author: TinyMeng <666@majiameng.com>
     * @param string $namespace
     * @return string
     */
    static public function createChannelId($namespace = ''):string {
        static $guid = '';
        $uid = uniqid("", true);
        $data = $namespace. md5(time() . mt_rand(1,1000000)).uniqid();
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash, 0, 8) .
            '-' .
            substr($hash, 8, 4) .
            '-' .
            substr($hash, 12, 4) .
            '-' .
            substr($hash, 16, 4) .
            '-' .
            substr($hash, 20, 12);
        return $guid;
    }

    /**
     * 获取md5中16位小写
     * 实现java的 MD516.Bit16
     * @Author: TinyMeng <666@majiameng.com>
     * @param $str
     * @return string
     */
    static public function md5Bit16($str):string {
        return strtoupper(substr(md5($str),8,16));
    }

    /**
     * 获取时间戳(13位精确到豪妙)
     * @Author: TinyMeng <666@majiameng.com>
     * @param null|int $time
     * @return int
     */
    static public function millisecond($time = null) :int{
        if(empty($time)){
            list($msec, $sec) = explode(' ', microtime());
            $millisecond = (int)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        }elseif(is_numeric($time) && strlen((string)$time)==10){
            $millisecond = (string)$time."000";
        }else{
            $millisecond = strtotime($time)."000";
        }
        return (int)$millisecond;
    }

    /**
     * Name: 是否包含中文
     * Author: Tinymeng <666@majiameng.com>
     * @param string $string
     * @return bool
     */
    public static function isContainChinese($string=''):bool {
        $result = preg_match('/[\x{4e00}-\x{9fa5}]/u', $string);
        return $result == 0 ? false : true;
    }

    /**
     * Name: 是否全是中文
     * Author: Tinymeng <666@majiameng.com>
     * @param string $string
     * @return bool
     */
    public static function isAllChinese($string=''):bool {
        $result = preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $string);
        return $result == 0 ? false : true;
    }

    /**
     * 判断手机号码
     * Author : MYL <ixiaomu@qq.com>
     * Updater：
     * @param string $string
     * @return bool
     */
    public static function isMobile($string=''):bool {
        if (!preg_match("/(^1[3|4|5|7|8][0-9]{9}$)/", $string)) {
            return false;
        }
        return true;
    }

    /**
     * Description:  科学计数法转化正常数值输出
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $num 科学计数法字符串  如 2.1E-5
     * @param int $double   小数点保留位数 默认3位
     * @return string
     */
    public static function sctonum($num, $double = 3){
        if(false !== stripos($num, "e")){
            $a = explode("e",strtolower($num));
            return bcmul($a[0], bcpow(10, $a[1], $double), $double);
        }
        return $num;
    }

    /**
     * Name: 自动转换字符集 支持数组转换
     * Author: Tinymeng <666@majiameng.com>
     * @param $string
     * @param string $from
     * @param string $to
     * @return array|false|string|string[]|null
     */
    public static function autoCharset($string, $from='gbk', $to='utf-8') {
        $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
        $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
        if (strtoupper($from) === strtoupper($to) || empty($string) || (is_scalar($string) && !is_string($string))) {
            //如果编码相同或者非字符串标量则不转换
            return $string;
        }
        if (is_string($string)) {
            if (function_exists('mb_convert_encoding')) {
                return mb_convert_encoding($string, $to, $from);
            } elseif (function_exists('iconv')) {
                return iconv($from, $to, $string);
            } else {
                return $string;
            }
        } elseif (is_array($string)) {
            foreach ($string as $key => $val) {
                $_key = self::autoCharset($key, $from, $to);
                $string[$_key] = self::autoCharset($val, $from, $to);
                if ($key != $_key)
                    unset($string[$key]);
            }
            return $string;
        }
        else {
            return $string;
        }
    }

    /**
     * Description:  过滤html里a标签
     * Author: song <53804059@qq.com>
     * Updater:
     * @param $html
     * @return string
     */
    public static function filterATag($html=''):string {
        return preg_replace("#<a[^>]*>(.*?)</a>#is", "$1", $html);
    }

    /**
     * Description:  删除html里a标签及内容
     * Author: song <53804059@qq.com>
     * Updater:
     * @param $html
     * @return string
     */
    public static function deleteATag($html=''):string {
        return preg_replace("#<a[^>]*>(.*?)</a>#is", "", $html);
    }

    /**
     * Description:  时间转换
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $date 时间
     * @param bool $is_timestamp   是否是时间戳
     * @return string
     */
    public static function getTime($date,$is_timestamp=false):string {
        if($is_timestamp === true){
            $time = $date;
        }else{
            $time = strtotime($date);//时间转换为时间戳
        }

        if($time >= time()){
            return '刚刚';
        }
        $seconds = time() - $time;
        if($seconds <= 60){
            return '刚刚';
        }
        $minutes = intval($seconds / 60);
        if($minutes <= 60){
            return $minutes.'分钟前';
        }
        $hours = intval($minutes / 60);
        if($hours <= 24){
            return $hours.'小时前';
        }
        $days = intval($hours / 24);
        if($days <= 3){
            return $days.'天前';
        }
        if($days <= 365){
            return date('m-d',/** @scrutinizer ignore-type */ $time);
        }
        return date('Y-m-d',$time);
    }

    /**
     * Name: 压缩html代码
     * Author: Tinymeng <666@majiameng.com>
     * @param string $html_source
     * @return string
     */
    static public function compressHtml($html_source):string {
        $chunks   = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
        $compress = '';
        foreach ($chunks as $c) {
            if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
                $c        = substr($c, 19, strlen($c) - 19 - 20);
                $compress .= $c;
                continue;
            } elseif (strtolower(substr($c, 0, 12)) == '<nocompress>') {
                $c        = substr($c, 12, strlen($c) - 12 - 13);
                $compress .= $c;
                continue;
            } elseif (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
                $compress .= $c;
                continue;
            } elseif (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) { // JS代码，包含“//”注释的，单行代码不处理
                $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
                $c    = '';
                foreach ($tmps as $tmp) {
                    if (strpos($tmp, '//') !== false) { // 对含有“//”的行做处理
                        if (substr(trim($tmp), 0, 2) == '//') { // 开头是“//”的就是注释
                            continue;
                        }
                        $chars   = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                        $is_quot = $is_apos = false;
                        foreach ($chars as $key => $char) {
                            if ($char == '"' && !$is_apos && $key > 0 && $chars[$key - 1] != '\\') {
                                $is_quot = !$is_quot;
                            } elseif ($char == '\'' && !$is_quot && $key > 0 && $chars[$key - 1] != '\\') {
                                $is_apos = !$is_apos;
                            } elseif ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                                $tmp = substr($tmp, 0, $key); // 不是字符串内的就是注释
                                break;
                            }
                        }
                    }
                    $c .= $tmp;
                }
            }
            $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c); // 清除换行符，清除制表符
            $c = preg_replace('/\\s{2,}/', ' ', $c); // 清除额外的空格
            $c = preg_replace('/>\\s</', '> <', $c); // 清除标签间的空格
            $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c); // 清除 CSS & JS 的注释
            $c = preg_replace('/<!--[^!]*-->/', '', $c); // 清除 HTML 的注释
            $compress .= $c;
        }
        return $compress;
    }

    /**
     * Description:  html标签替换成特定小程序标签
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $content
     * @return mixed
     */
    static public function htmlReplaceXcx(string $content):string {
        $content = str_replace("\r\n","",$content);//出除回车和换行符
        $content = preg_replace("/style=\".*?\"/si",'',$content);//style样式
        $content = preg_replace(["/<strong.*?>/si", "/<\/strong>/si"],['<text class="wx-strong">','</text>'],$content);//strong
        $content = preg_replace(["/<p.*?>/si", "/<\/p>/si"],['<view class="wx-p">','</view>'],$content);//p
        $content = preg_replace(["/<a.*?>/si", "/<\/a>/si"],['<text class="wx-a">','</text>'],$content);//a
        $content = preg_replace(["/<span.*?>/si", "/<\/span>/si"],['<text class="wx-span">','</text>'],$content);//span
        $content = preg_replace(["/<h[1-6].*?>/si", "/<\/h[1-6]>/si"],['<view class="wx-h">','</view>'],$content);//h
        $content = preg_replace("/<img.*?/si",'<image class="wx-img"',$content);//img
        return $content;
    }

    /**
     * Description:  html P标签替换成特定Span标签(安卓app使用)
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $content
     * @return string
     */
    static public function pReplaceSpan(string $content):string {
        $content = str_replace(["\r","\n","\t"],'',$content);
        $content = preg_replace(["/<p/si", "/<\/p>/si"],['<span','</span><br>'],$content);//p
        return $content;
    }

    /**
     * Description:  过滤标点符号
     * @author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param  string $keyword
     * @return string
     */
    static public function filterPunctuation($keyword){
        $keyword = str_replace(["\r\n", "\r", "\n"," ","　"], "", trim($keyword));//删除空格
        $keyword = preg_replace('# #','',$keyword);
        $keyword = preg_replace("/[ '.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",'',$keyword);
        return $keyword;
    }

    /**
     * Description:  过滤html标签
     * @author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param $content
     * @param string $allowable_tags
     * @return string
     */
    static public function stripTags($content,$allowable_tags = '<font>'){
        $content = strip_tags($content,$allowable_tags);//替换标签
        $content = str_replace(["\r\n", "\r", "\n","　"], "", trim($content));//删除空格
        return $content;
    }

}