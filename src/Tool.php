<?php
namespace tinymeng\tools;

/**
 * Name: Tool.php.
 * Author: JiaMeng <666@majiameng.com>
 * Date: 2018/8/17 14:20
 * Description: Tool.php.
 */

class Tool{

    /**
     * Description:  对象到数组转换
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param $obj
     * @return array
     */
    private function objectToArray($obj){
        if(!is_object($obj) && !is_array($obj)) {
            return $obj;
        }
        $arr = array();
        foreach($obj as $k => $v){
            $arr[$k] = $this->objectToArray($v);
        }
        return $arr;
    }

    /**
     * Description:  获取ip
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @return string
     */
    public static function getIp(){
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }else if(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }else{
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);

        return $cip;
    }


    /**
     * Description:  是否是移动端
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @return bool
     */
    public static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientKeyWords = array(
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientKeyWords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Description:  判断是否微信内置浏览器访问
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @return bool
     */
    public static function isWeiXin() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Description:  判断是否支付宝内置浏览器访问
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @return bool
     */
    public static function isAliPay() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Alipay') !== false) {
            return true;
        }
        return false;
    }

    /**
     * Description:  获取菜单树结构
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param array $list 数据list
     * @param string $filed 主键字段
     * @param string $parent_filed 父节点字段
     * @param int $parent_id 父id值
     * @return array
     */
    public static function getTreeStructure($list,$filed='id',$parent_filed='pid',$parent_id=0){
        $result = array();
        if(!empty($list)){
            foreach($list as $key=>$val){
                if($val[$parent_filed] == $parent_id){
                    $val['child'] = self::getTreeStructure($list,$filed,$parent_filed,$val[$filed]);
                    if(empty($val['child'])){
                        unset($val['child']);
                    }
                    $result[] = $val;
                }
            }
        }
        return $result;
    }

    /**
     * 空数组转为object
     * 给安卓出接口时部分要求[]返回{}(数组返回字典类型)
     * @Author: TinyMeng <666@majiameng.com>
     * @param $data
     */
    static public function nullArrayToObject(&$data){
        foreach ($data as $key=>&$val){
            if(is_array($val)){
                if(empty($val)){
                    settype($val,'object');
                }else{
                    self::nullArrayToObject($val);
                }
            }
        }
    }

}
