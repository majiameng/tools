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
     * Description:  获取菜单树结构（递归-性能低）
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param array $list 数据list
     * @param string $filed 主键字段
     * @param string $parentFiled 父节点字段
     * @param int $parentId 父id值
     * @param string $childrenName child
     * @return array
     */
    public static function getTreeStructureRecursion(array $list,string $filed='id',string $parentFiled='pid',int $parentId=0,string $childrenName = 'child')
    {
        $result = array();
        if(!empty($list)){
            foreach($list as $val){
                if($val[$parentFiled] == $parentId){
                    $val[$childrenName] = self::getTreeStructureRecursion($list,$filed,$parentFiled,$val[$filed]);
                    if(empty($val[$childrenName])){
                        unset($val[$childrenName]);
                    }
                    $result[] = $val;
                }
            }
        }
        return $result;
    }

    /**
     * Description:  获取菜单树结构（性能高）
     * Author: JiaMeng <666@majiameng.com>
     * Updater:
     * @param array $list 数据list
     * @param string $filed 主键字段
     * @param string $parentFiled 父节点字段
     * @param string $childrenName child
     * @return array
     */
    public static function getTreeStructure(array $list,string $filed = 'id', string $parentFiled = 'pid', string $childrenName = 'child')
    {
        $result = array();
        foreach ($list as $value) {
            $result[$value[$filed]] = $value;
        }
        static $tree = array(); //格式化好的树
        foreach ($result as $item) {
            if (isset($result[$item[$parentFiled]])) {
                $result[$item[$parentFiled]][$childrenName][] = &$result[$item[$filed]];
            } else {
                $tree[] = &$result[$item[$filed]];
            }
        }
        return $tree;
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
