<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/14
 * Time: 20:04
 * Func: Get data save into db
 * PrepareTime:2 hour
 */

namespace Seat\Controller;
use GuzzleHttp\Client;
use Seat\Model\RoomIdModel;
use Seat\Model\SeatIdModel;
use Seat\Model\SpiderModel;
use Think\Controller;
/*
 *  每隔一分钟抓取图书馆6-7自修室的使用情况，存入数据库。
 *  每隔一分钟用crontab+shell脚本实现
 *  从早7到晚22
 */
class SpiderController extends Controller
{
    public function run()
    {
        $urls = $this->prepare();
        $data = $this->getData($urls);
        $sqlData = $this->dataProcess($data);
        $result = $this->saveData($sqlData);
        var_dump($result);

    }

    /**
     * @return array 所有的获取房间信息的url地址
     */
    public function prepare()
    {
        //rooms
        $roomModel = new RoomIdModel();
        $roomNums = $roomModel->getAllNum();
        //make urls
        $urls = array();
        $baseUrl = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/device.aspx?';

        foreach($roomNums as $v)
        {
            $getData = array(
                'byType'=>'devcls',
                'classkind'=>'8',
                'display'=>'fp',
                'md'=>'d',
                'room_id'=>$v,
                'purpose'=>'',
                'cld_name'=>'default',
                'date'=> date("Y-m-d",time()),
                'fr_start'=>'15:40',
                'fr_end'=>'16:40',
                'act'=>'get_rsv_sta',
                '_'=>'1514014834075',
            );
            $tmpUrl = $baseUrl;
            foreach($getData as $key=>$val)
            {
                $val = urlencode($val);
                $tmpUrl .= $key.'='.$val.'&';
            }
            $url = substr($tmpUrl,0,-1);
            array_push($urls,$url);
        }

        return $urls;
    }

    /**
     * @param $urls urls
     * @return array raw data->data
     */
    public function getData($urls)
    {
        $data = array();
        $client = new Client();
        foreach($urls as $v)
        {
            $response = $client->request("GET",$v);
            $rawData = json_decode($response->getBody())->data;
            array_push($data,$rawData);
        }
        return $data;
    }

    /**
     * @param $rawData 原始接口返回数据
     * @return array 存入数据库的数据
     */
    public function dataProcess($rawData)
    {
        $sqlData = array();
        foreach($rawData as $value)
        {
            //每个房间
            foreach($value as $val)
            {
                //一个房间每个座位
                $tmparr = array();
                foreach($val->ts as $k=>$v)
                {
                    if($v->state == "doing")
                    {
                        $tmparr = [
                            'room_num'=>$val->labId,
                            'seat_num'=>$val->devId,
                            'start'=>$v->start,
                            'end'=>$v->end,
                            'owner'=>$v->owner,
                            'add_time'=>time(),
                        ];
                        array_push($sqlData,$tmparr);
                    }
                }
            }

        }
        return $sqlData;
    }

    public function saveData($sqlData)
    {
        $i =0;
        $spiderModel = new SpiderModel();
        foreach($sqlData as $v)
        {
            var_dump($v);
            echo '<br>';
            $result = $spiderModel->add($v);
            $i++;
        }

        return $i;
    }

}