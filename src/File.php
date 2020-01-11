<?php
namespace tinymeng\tools;
/**
 * 文件操作类
 */
class File
{

    /**
     * Name: writeLog
     * Author: Tinymeng <666@majiameng.com>
     * @param string $message 日志信息
     * @param string $file_name 文件名称
     * @param bool $echo 是否输出
     * @param \Exception|null $exception
     * @return bool
     */
    static public function writeLog($message, $file_name='error', $echo = false,\Exception $exception = null){
        if(!is_string($message)){
            $message = json_encode($message);
        }
        $message = date('Y-m-d H:i:s').' : '.$message.PHP_EOL;
        if($exception && $exception instanceof \Exception){
            $message .= ' File: '.$exception->getFile().' ,Line: '.$exception->getLine().' ,Message: '.$exception->getMessage();
        }
        if($echo){
            echo $message;
        }
        $path = dirname(dirname(dirname(dirname(__DIR__)))).'/storage/writeLog/';
        if (!is_dir($path)) {
            if(!mkdir($path, 0755, true)){
                die('创建缓存文件夹"'.$path.'"失败!');
            }
        }

        $file_name = $path.$file_name;
        self::filePutContents($file_name."-".date('Ymd',time()).".log",$message,true);
        return true;
    }

    /**
     * Name: 写入文件
     * Author: Tinymeng <666@majiameng.com>
     * @param $file_name 文件名称
     * @param $content 文件内容
     * @param bool $file_append 内容是否追加
     * http://blog.majiameng.com/article/2724.html
     */
    static public function filePutContents($file_name,$content,$file_append = false){
        if(strrpos($file_name,'/')){
            //获取文件夹路径
            $dir_name = substr($file_name,0,strrpos($file_name,'/'));
            //创建文件夹
            self::mkdir($dir_name);
        }

        if($file_append === false){
            file_put_contents($file_name,$content);
        }else{
//            $handle = fopen($file_name, 'a+');
//            fwrite($handle, $content);
//            fclose($handle);
            file_put_contents($file_name,$content,FILE_APPEND);
        }
    }

    /**
     * Name: 创建文件夹
     * Author: Tinymeng <666@majiameng.com>
     * @param $dir_name
     * @return bool
     */
    static public function mkdir($dir_name){
        if (!is_dir($dir_name)) {
            if(!mkdir($dir_name, 0755, true)){
                die('创建缓存文件夹"'.$dir_name.'"失败!');
            }
        }
        return true;
    }

    /**
     * Name: 删除文件夹或文件
     * Author: Tinymeng <666@majiameng.com>
     * @param $dir
     * @return bool
     */
    static public function delDir($dir) {
        if(!file_exists($dir)){//文件不存在
            return true;
        }
        if (!is_dir($dir)) {
            unlink($dir);
            return true;
        }

        //先删除目录下的文件
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if($file != "." && $file!="..") {
                $full_path = $dir."/".$file;
                if(!is_dir($full_path)) {
                    unlink($full_path);
                } else {
                    self::delDir($full_path);
                }
            }
        }
        closedir($dh);

        //删除当前文件夹：
        if(rmdir($dir)) {
            return true;
        } else {
            return false;
        }
    }
}
