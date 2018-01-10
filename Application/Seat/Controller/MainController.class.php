<?php
namespace Seat\Controller;
use Seat\Model\QueueModel;
use Think\Controller;

class MainController extends Controller
{
    public function run()
    {

        //get tasks
        $queueModel = new QueueModel();
        $rawData = $queueModel->getValidTasks();
        foreach($rawData as $key=>&$val)
        {
            $val['seat'] = unserialize($val['seat']);
        }
        unset($val);

        //投递任务
            //初始化任务状态数组
        $tasks = array();
            //初始化任务对象数组
        $task = array();
        foreach($rawData as $k=>$v)
        {
            $tasks[$k] = 0;
        }

        foreach($tasks as $k=>&$v){
           if($v=='0'){
              $atask = new CoreController($rawData[$k]);
               array_push($task,$atask);
            }
        }
        unset($v);

        //run
        foreach($task as $v)
        {
            $v->run();
        }
    }
}