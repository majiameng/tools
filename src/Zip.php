<?php
/**
 * @name: ZipUtil
 * @Created by IntelliJ IDEA
 * @author: tinymeng
 * @file: ReportListUtil.php
 * @Date: 2018/7/4 10:15
 */
namespace tinymeng\tools;

use ZipArchive;

class Zip {


    public $fileName;
    /**
     * @var ZipArchive
     */
    public $client;

    static public function init(){
        $gateway = new self();

        $gateway->client =  new ZipArchive();
        return $gateway;
    }

    /**
     * open
     * @param $filename
     * @return $this|string
     * @author: Tinymeng <666@majiameng.com>
     * @time: 2022/4/27 9:26
     */
    public function open($filename,$Fromfilename=null){
        if (!empty($filename)){
            $this->setFileName($filename);
            if(!$this->client->open($this->fileName, ZipArchive::CREATE))
                return 'File open failed';
        }
        if(!empty($Fromfilename)){
            if(is_dir($Fromfilename)){
                $list_dir = scandir($Fromfilename);
                for($i=2;$i<count($list_dir);$i++){
                    if(is_dir($Fromfilename.'/'.$list_dir[$i])){
                        $this->client->addGlob($Fromfilename.'/'.$list_dir[$i].'/*.*', 0, array('add_path' => $Fromfilename.'/'.$list_dir[$i].'/', 'remove_path' => $Fromfilename.'/'.$list_dir[$i]));
                        $list_chr = scandir($Fromfilename.'/'.$list_dir[$i]);
                        for($j=2;$j<count($list_chr);$j++){
                            if(is_dir($Fromfilename.'/'.$list_dir[$i].'/'.$list_chr[$j])){
                                echo $list_chr[$j];
                                $this->open('',$Fromfilename.'/'.$list_dir[$i].'/'.$list_chr[$j]);
                            }
                        }
                    }
                }
            }else{
                $this->client->addFile ($Fromfilename);
            }
        }
        return $this;
    }

    /**
     * getFileName
     * @param string $filename
     * @return string
     * @author: Tinymeng <666@majiameng.com>
     * @time: 2022/4/27 9:26
     */
    private function setFileName($filename){
        if(!preg_match('/zip/m', $filename)){
            $filename = $filename.'-'.date('Ymd').rand(111,999).'.zip';
        }
        $this->fileName = $filename;
        return $filename;
    }

    /**
     * getFileName
     * @return mixed
     * @author: Tinymeng <666@majiameng.com>
     * @time: 2022/4/27 9:50
     */
    public function getFileName(){
        return $this->fileName;
    }

    /**
     * addFileContent
     * @param $file_name
     * @param $content
     * @return $this
     * @author: Tinymeng <666@majiameng.com>
     * @time: 2022/4/27 9:31
     */
    public function addFileContent($file_name,$content){
        $this->client->addFromString($file_name,$content);
        return $this;
    }

    /**
     * addFile
     * @param $file_name
     * @param $content
     * @return $this
     * @author: Tinymeng <666@majiameng.com>
     * @time: 2022/4/27 9:31
     */
    public function addFile($file_name,$content){
        $this->client->addFromString($file_name,$content);
        return $this;
    }

    /**
     * 文件下载
     * @return void
     */
    public function download(){
        $this->client->finish();
    }

    /**
     * unzip
     * @param  string $filename
     * @param  string $dir      解压缩所到目录
     * @return $this|string           返回错误原因
     * @author: Tinymeng <666@majiameng.com>
     * @time: 2022/4/27 9:38
     */
    public function unzip($filename,$dir){
        if(!file_exists($filename))
            return 'File does not exist';
        if(!$this->client->open($filename))
            return 'File open failed';
        if(!is_dir($dir)){
            mkdir($dir,775);
        }else{
            return 'Dir mk failed';
        }
        if(!$this->client->extractTo($dir))
            return 'File unzip failed';
        return $this;
    }

    /**
     * 文件存储
     * @return bool
     * @author : TinyMeng <666@majiameng.com>
     * @time: 2023-12-07 15:38
     */
    public function save() {
        return $this->client->close();
    }


}
