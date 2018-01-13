<?php
namespace Seat\Controller;
use GuzzleHttp\Client;
use Seat\Model\RoomIdModel;
use Seat\Model\SeatIdModel;
use THink\Controller;

class ExploreController extends Controller
{
    public function index()
    {
        //查找所有教室
        $roomId = new RoomIdModel();
        $rooms = $roomId->getAll();
        $this->assign('rooms',$rooms);
        $this->display();
    }

    public function ajax_getSeats()
    {
        $roomId = I('roomId');
        $roomModel = new RoomIdModel();
        $roomName = $roomModel->getRoomName($roomId);

        $htmlController = new HtmlController();
        $content  = $htmlController->exploreIndexSelect($roomName['name']);
        //拼接一个select
        $this->ajaxReturn(
            ['data'=>$content]
        );
    }

    public function ajax_who()
    {
        $seatid = I('seatid');

        //获取带Cookies的http客户端
        $client = new Client(['cookies'=>true]);
        $client->request('POST','http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/login.aspx?',['form_params'=>['id'=>'153401040229','pwd'=>'153401040229','act'=>'login']]);
        //获取座位的信息
        $seatModel = new SeatIdModel();
        $seatName = $seatModel->getSeatsName([$seatid]);    //array{[0]=>'701-050'}
        //获取房间的所有的预约信息
        $baseUrl = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/device.aspx?';
        $roomName = substr($seatName[0],0,3);
        $roomModel = new RoomIdModel();
        $roomId = $roomModel->getRoomNumber($roomName)['number'];   //107396184
        $getData = array(
            'byType'=>'devcls',
            'classkind'=>'8',
            'display'=>'fp',
            'md'=>'d',
            'room_id'=>$roomId,
            'purpose'=>'',
            'cld_name'=>'default',
            'date'=> date("Y-m-d",time()),
            'fr_start'=>'15:40',
            'fr_end'=>'16:40',
            'act'=>'get_rsv_sta',
            '_'=>'1514014834075',
        );
        foreach($getData as $k=>$v)
        {
            if($v != ''){
                $v = urlencode($v);
            }
            $baseUrl .= $k.'='.$v.'&';
        }

        $url = substr($baseUrl,0,-1);
        $response = $client->request('GET',$url);

        $roomInfo = json_decode($response->getBody())->data;


        // 人物可信度查询
        $seatInfo = '';
        foreach($roomInfo as $k=>$obj){
            if($obj->devId == $seatid)
            {
                $seatInfo = $obj;
                break;
            }
        }

        //将这个座位的信息组成数组的格式
        $info = array();
        foreach($seatInfo->ts as $k=>$val)
        {
            $tmp = array(
                'start'=>$val->start,
                'end'=>$val->end,
                'state'=>$val->state,
                'owner'=>$val->owner
            );
            array_push($info,$tmp);
        }

        $ownerInfo = array(
            'seat_name'=>$seatName[0],
            'info'=>$info,
        );

        $this->ajaxReturn(['ownerInfo'=>$ownerInfo]);

        //添加可信度
//        $ownerInfo = $this->reliability($ownerInfo,$client);
    }

    public function reliability($ownerInfo,$client)
    {
        $baseUrl = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/data/searchAccount.aspx?';
        //查询全校owner同名的人
        foreach($ownerInfo['info'] as $k=>$v)
        {
            //拼接查询地址
            $name = $v['owner'];
            $nameLength = strlen($name);
            $getData = array(
                'type'  => '',
                'term'  =>$name,
                '_'     => time().rand(111,999),
            );
            foreach($getData as $k=>$v)
            {
                if($v != ''){
                    $v = urlencode($v);
                }
                $baseUrl .= $k.'='.$v.'&';
            }
            $url = substr($baseUrl,0,-1);

            //查询全校同名
            $response = $client->request('GET',$url);

            $result = json_decode($response->getBody());

            foreach($result as $k=>$v)
            {
                echo $v->name;
                echo $nameLength;
                echo strlen($v->name);
                if(strlen($v->name) != $nameLength)
                {
                    unset($result[$k]);
                }
            }
            var_dump($result);
            $ownerInfo['info'][$k]['who'] = $result;
        }

//        var_dump($ownerInfo);
    }
}