<?php
/**
 * Created by PhpStorm.
 * User: henry
 * Date: 18/10/25
 * Time: 下午8:15
 * 开启httpserver服务
 */


$http = new swoole_http_server("0.0.0.0", 9501);

$http->set(
    [

    ]
);

$http->on('request', function ($request, $response) {

    //print_r($request->get);
    $response->cookie('henry','wuqian520',time()+1800);
    $response->end("sss".json_encode($request->get));
});

$http->start();