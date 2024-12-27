<?php
namespace tinymeng\tools;

/**
 * Name: Tool.php.
 * Author: JiaMeng <666@majiameng.com>
 * Date: 2018/8/17 14:20
 * Description: Tool.php.
 */

class ArrayTool{

    /**
     * @param $arr
     * @param $keys
     * @param $type
     * @return array
     */
    static public function arraySort($arr,$keys,$type='asc'){
        $keysValue = $newArray = array();
        foreach ($arr as $k=>$v){
            if(isset($v[$keys])){
                $keysValue[$k] = $v[$keys];
            }
        }
        if($type == 'asc'){
            asort($keysValue);
        }else{
            arsort($keysValue);
        }
        reset($keysValue);
        foreach ($keysValue as $k=>$v){
            $newArray[$k] = $arr[$k];
        }
        return array_values($newArray);
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
     * Description:  对象到数组转换
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param $obj
     * @return array
     */
    public static function objectToArray($obj){
        if(!is_object($obj) && !is_array($obj)) {
            return $obj;
        }
        $arr = array();
        foreach($obj as $k => $v){
            $arr[$k] = self::objectToArray($v);
        }
        return $arr;
    }

    /**
     * 空数组转为object
     * 给安卓出接口时部分要求[]返回{}(数组返回字典类型)
     * @Author: TinyMeng <666@majiameng.com>
     * @param $data
     */
    public static function nullArrayToObject(&$data){
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
