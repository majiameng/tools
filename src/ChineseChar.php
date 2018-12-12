<?php

namespace tinymeng\tools;
/**
 * Name: Doc.php.
 * Author: JiaMeng <666@majiameng.com>
 * Date: 2017/8/20 17:20
 * Description: Doc.php.
 */
class ChineseChar
{

    static public function getArray()
    {
        return unserialize(file_get_contents('./lib/chinese-char-library.txt'));
    }

    /**
     * Description:  获取字符串的首字母
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $string 要转换的字符串
     * @param bool $isOne 是否取首字母
     * @param bool $upper 是否转换为大写
     * @return bool|mixed|string
     *
     * 例如：getChineseFirstChar('我是作者') 首字符全部字母+小写
     * return "wo"
     *
     * 例如：getChineseFirstChar('我是作者',true) 首字符首字母+小写
     * return "w"
     *
     * 例如：getChineseFirstChar('我是作者',true,true) 首字符首字母+大写
     * return "W"
     *
     * 例如：getChineseFirstChar('我是作者',false,true) 首字符全部字母+大写
     * return "WO"
     */
    static public function getChineseFirstChar($string, $isOne = false, $upper = false)
    {
        $spellArray = self::getArray();
        $str_arr = self::utf8_str_split($string, 1); //将字符串拆分成数组

        if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $str_arr[0])) { //判断是否是汉字
            $chinese = $spellArray[$str_arr[0]];
            $result = $chinese[0];
        } else {
            $result = $str_arr[0];
        }

        $result = $isOne ? substr($result, 0, 1) : $result;

        return $upper ? strtoupper($result) : $result;
    }

    /**
     * Description:  将字符串转换成拼音字符串
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $string 汉字字符串
     * @param bool $isOne 是否大写
     * @param bool $upper 是否大写
     * @return string
     * 例如：getChineseChar('我是作者'); 全部字符串+小写
     * return "wo shi zuo zhe"
     *
     * 例如：getChineseChar('我是作者',true); 首字母+小写
     * return "w s z z"
     *
     * 例如：getChineseChar('我是作者',true,true); 首字母+大写
     * return "W S Z Z"
     *
     * 例如：getChineseChar('我是作者',false,true); 首字母+大写
     * return "WO SHI ZUO ZHE"
     */
    static public function getChineseChar($string, $isOne = false, $upper = false)
    {
        global $spellArray;
        $str_arr = self::utf8_str_split($string, 1); //将字符串拆分成数组
        $result = array();
        foreach ($str_arr as $char) {
            if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $char)) {
                $chinese = $spellArray[$char];
                $chinese = $chinese[0];
            } else {
                $chinese = $char;
            }
            $chinese = $isOne ? substr($chinese, 0, 1) : $chinese;
            $result[] = $upper ? strtoupper($chinese) : $chinese;
        }
        return implode(' ', $result);
    }

    /**
     * Description:  将字符串转换成数组
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param string $str 要转换的字符串
     * @param int $split_len
     * @return array|bool
     */
    private static function utf8_str_split($str, $split_len = 1)
    {
        if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1) {
            return false;
        }

        $len = mb_strlen($str, 'UTF-8');

        if ($len <= $split_len) {
            return array($str);
        }
        preg_match_all('/.{' . $split_len . '}|[^\x00]{1,' . $split_len . '}$/us', $str, $ar);

        return $ar[0];
    }

}