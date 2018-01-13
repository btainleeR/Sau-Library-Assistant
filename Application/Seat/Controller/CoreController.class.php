<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/8
 * Time: 23:27
 */
namespace Seat\Controller;

use Psr\Http\Message\ResponseInterface;
use Seat\Model\HistoryModel;
use Think\Controller;
use GuzzleHttp\Client;


class CoreController extends Controller
{

    public function __construct(array $task)
    {
        $this->tasks = $task;
    }
    protected $tasks;
    protected $apis = array(
        'cookies'=> 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/login.aspx?',
        'seats'=>'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/reserve.aspx?',
        'roominfo'=>'libreserve.sau.edu.cn/ClientWeb/pro/ajax/device.aspx?',
        'ownerinfo'=>'libreserve.sau.edu.cn/ClientWeb/pro/ajax/data/searchAccount.aspx?',
    );


    public function run()
    {

        $urls = $this->getUrls();

        $result = $this->sendRequest($urls);

        return $result;
    }


    public function sendRequest($urls)
    {
        $status = 0;
        $Client = new Client(['cookies'=>true]);
        $Client->request('POST',$this->apis['cookies'],['form_params'=>['id'=>$this->tasks['username'],'pwd'=>$this->tasks['password'],'act'=>'login']]);
        $promise = $Client->requestAsync("GET",$urls[0]);

        $promise->then(function(ResponseInterface $res) use ($urls,$Client,$status) {
            echo $this->tasks['username'].':'.$res->getBody();
            echo '\n';
            $body = json_decode($res->getBody());
            if ($body->ret == '1') {
                $status = 1;
                //写入history数据表
                $historyModel = new HistoryModel();
                $data = array(
                    'nickname'=>$this->tasks['nickname'],
                    'username'=>$this->tasks['username'],
                    'date'=>date('Y-m-d',(int)time()+86400),
                    'start'=>$this->tasks['start'],
                    'end'=>$this->tasks['end'],
                    'seat'=>$this->tasks['seat'][0],
                    'comment'=>'Get Best Seat',
                    'add_time'=>time(),
                );
                $historyModel->add($data);
                exit;
            }

            if (isset($urls[1])) {
                for ($i = 1; $i < sizeof($urls); $i++) {
                    $promise = $Client->requestAsync('GET', $urls[$i]);
                    $promise->then(function (ResponseInterface $res) use($status) {
                        echo $this->tasks['username'].':'.$res->getBody();
                        echo '\n';
                        $body = json_decode($res->getBody());
                        if ($body->ret == '1') {
                            $status = 1;
                            //写入history数据表
                            $historyModel = new HistoryModel();
                            $data = array(
                                'nickname'=>$this->tasks['nickname'],
                                'username'=>$this->tasks['usernaem'],
                                'date'=>date('Y-m-d',(int)time()+86400),
                                'start'=>$this->tasks['start'],
                                'end'=>$this->tasks['end'],
                                'seat'=>$this->tasks['seat'][0],
                                'comment'=>'Get Best Seat',
                                'add_time'=>time(),
                            );
                            $historyModel->add($data);
                            exit;
                        }
                    });
                }
            }
        });
        $promise->wait();
        return $status;
    }

    /**
     * @return array  拼接数个请求地址
     */
    public function getURls()
    {
        $urls  =array();
        $baseUri = $this->apis['seats'];
        $params = array();
        foreach($this->tasks['seat'] as $key=>$val)
        {
            if($val != ''){
                $params[$key] = array(
                    'dev_id'=>$val,
                    'type'=>'dev',
                    'start'=>date('Y-m-d',(int)time()+86400).' '.substr($this->tasks['start'],0,2).":".substr($this->tasks['end'],-2,2),
                    'end'=>date('Y-m-d',(int)time()+86400).' '.substr($this->tasks['end'],0,2).":".substr($this->tasks['end'],-2,2),
                    'start_time'=>$this->tasks['start'],
                    'end_time'=>$this->tasks['end'],
                    'act'       =>  'set_resv',
                    '_'         =>  time().rand(111,999)
                );
            }
        }

        foreach($params as $key=>$val)
        {
            $baseUri = $this->apis['seats'];
            foreach($val as $k=>$v)
            {
                if($v !== '')
                {
                    $v = urlencode($v);
                }
                $baseUri .= $k . '=' . $v . '&';
            }
            $urls[$key] = substr($baseUri,0,-1);
        }
        return $urls;
    }
}