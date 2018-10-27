<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 18/10/26
 * Time: 上午1:22
 */


class WS{

    public $ws=null;
    public $port=8812;
    public $host="0.0.0.0";

    public function __construct()
    {


        $this->ws=new swoole_websocket_server("0,0,0,0", $this->port);
        $this->ws->set(
            [
                "worker_num"=>2,
                "task_worker_num"=>2
            ]
        );
        $this->ws->on("open",[$this,'onOpen']);
        $this->ws->on("message",[$this,'onMessage']);
        $this->ws->on('task',[$this,'onTask']);
        $this->ws->on('finish',[$this,'onFinish']);
        $this->ws->on("close",[$this,'onClose']);
        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     *
     */
    public function onOpen($ws,$request){
        var_dump($request->fd);

    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws,$frame){

        echo "push-info:{$frame->data}\n";
        //TODO 10s
        $data=[
            'task'=>1,
            'fd'=>$frame->fd,
        ];
        $ws->task($data);
        //推送消息到客户端
        $ws->push($frame->fd, "server:".date("Y-m-d H:i:s",time()));

    }


    /**
     * @param $serv
     * @param $task_id
     * @param $worker_id
     * @param $data
     */
    public function onTask($serv,$task_id,$worker_id,$data){

        print_r($data);
        //耗时的场景
        sleep(10);
        return "on-task-finish";//告诉worker进程执行task异步任务

    }

    /**
     *
     */
    public function onFinish($serv,$task_id,$data){

        echo "task_id:{$task_id}\n";
        echo "finish-data-success:{$data}";
    }


    /**
     * @param $ws
     * @param $fd
     * 监听ws关闭事件
     */
    public function onClose($ws,$fd){

        echo "close-client-id:{$fd}\n";

    }

}

    //实例化ws类
    $obj=new WS();