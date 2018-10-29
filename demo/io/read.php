<?php

/**
 * swoole异步读取文件
 * author:henry
 * __DIR__当前目录所在文件夹
 * $filename 文件名
 * $content 文件内容
 */


$result=swoole_async_readfile(__DIR__."/1.txt", function($filename, $content) {

    echo "文件名称".$filename.PHP_EOL;
    echo "文件内容".$content.PHP_EOL;

});
var_dump($result).PHP_EOL;
echo "asdsad".PHP_EOL;