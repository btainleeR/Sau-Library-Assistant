<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/7
 * Time: 16:52
 */
namespace Seat\Controller;
use Seat\Model\QueueModel;
use Seat\Model\RoomIdModel;
use Seat\Model\SeatIdModel;
use Think\Controller;

class QueueController extends Controller
{

    /**
     *  Display index page
     */
    public function index()
    {
        $queueModel = new QueueModel();
        $queues = $queueModel->getAll();
        foreach($queues as $k=>$v)
        {
            $tmp = unserialize($v['seat']);
            $tmp = $this->getSeatNameByNum($tmp);
            $tmpStr = '';
            foreach($tmp as $v){
                $tmpStr .= $v.'<br>';
            }
            $queues[$k]['seat'] = $tmpStr;

        }

        $this->assign('queues',$queues);
        $this->display();
    }

    /**
     * @param array $seats  Array of seats number
     * @return array    Array of seats number
     */
    public function getSeatNameByNum(array $seats)
    {
        $seatModel = new SeatIdModel();
        return $seatModel->getSeatsName($seats);
    }


    /**
     *  Display add queue page
     */
    public function add()
    {
        //获取教室=>编号
       $roomModel = new RoomIdModel();
       $data = $roomModel->getAll();
       $this->assign('rooms',$data);


       $this->display();

    }

    /**
     *  When select a room,creaet seats for user.
     */
    public function ajax_loadSeat()
    {
        $room = I('room');
        $roomModel = new RoomIdModel();
        $name = $roomModel->getRoomName($room);
        //模糊查询
        $seatModel = new SeatIdModel();
        $seats  = $seatModel->getSeatsLikeName($name['name']);
        //因为PHP拼接html比Js简单的多，所以直接在后台拼接。



        $str = '<div class="layui-inline" id="str1"><select name="best_seat" lay-verify="required"><option value="">请选择一个座位</option>';
        $str2 = '<div class="layui-input-block" id="str2"><input type="checkbox" name="other_seats" value="">';
        foreach($seats as $k=>$v)
        {
            //拼接座位下拉
            $tmpStr = '<option value="'.$v['number'].'">'.$v['name'].'</option>';
            $str .=$tmpStr;
            //拼接备选座位
            $str2 .= '<input type="checkbox" name="other_seats" title="'.$v['name'].'" value="'.$v['number'].'" >';
        }
        $str .='</select></div>';
        $str2 .='</div>';
        $data = array(
            'str1'=>$str,
            'str2'=>$str2,
        );
        $this->ajaxReturn($data);
    }


    /**
     * @Type Ajax
     * @Func add a task into queue
     */
    public function ajax_addtask()
    {
       $data = array(
           'nickname'=>I('nickname'),
           'username'=>I('username'),
           'password'=>I('password'),
           'start'=>I('start'),
           'end'=>I('end'),
           'status'=>I('status'),
           'room'=>I('room'),
           'best_seat'=>I('best_seat'),
           'other_seats'=>I('other_seats')
       );
        //status转换为0/1
        if($data['status'] == 'on')
        {
            $data['status'] = 1;
        }else {
            $data['status'] = 0;
        }

        //座位处理
        if(substr($data['other_seats'],0,1) == ',')
        {
            $data['other_seats'] = substr($data['other_seats'],1);
        }
        $data['other_seats'] = substr($data['other_seats'],0,-1);
        $seat = $data['best_seat'].','.$data['other_seats'];
        $seat = explode(',',$seat);
        $seat = serialize($seat);
        //座位处理结束
       $queueModel = new QueueModel();
       $sqlData = array(
           'nickname'=>$data['nickname'],
           'username'=>$data['username'],
           'password'=>$data['password'],
           'start'=>$data['start'],
           'end'=>$data['end'],
           'seat'=>$seat,
           'status'=>$data['status'],
       );
        $result = $queueModel->add($sqlData);
        if($result)
        {
            $apinfo = array(
                'error' => 0,
                'msg' =>   '添加成功',
            );
        }else
        {
            $apinfo = array(
                'error'=>1,
                'msg' =>'添加失败',
            );
        }
        $this->ajaxReturn($apinfo);
    }


    /**
     *  @Type Ajax
     *  @Func Change task status
     */
    public function ajax_changeStatus()
    {
        $id = I('id');
        $queueModel = new QueueModel();
        $status = $queueModel->where(['id'=>$id])->field('status')->find()['status'];
        if($status == 1) {
            $map['status'] = 0;
        } else {
            $map['status'] = 1;
        }

        $result = $queueModel->where(['id'=>$id])->save($map);
        if($result)
        {
            $data = [
                'error' => 0,
            ];
        } else {
            $data = [
                'error' => 1,
            ];
        }

        $this->ajaxReturn($data);
    }

    public function ajax_deleteTask()
    {
        $id = I('id');
        $queueModel = new QueueModel();
        $result = $queueModel->where(['id'=>$id])->delete();
        if($result) {
            $data['error'] = 0;
        } else {
            $data['error'] = 1;
        }

        $this->ajaxReturn($data);
    }
}