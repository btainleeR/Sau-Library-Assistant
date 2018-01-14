<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/7
 * Time: 18:24
 */
namespace Seat\Model;

use Think\Model;

class RoomIdModel extends Model
{
    public function getAll()
    {
        $data = $this->select();
        return $data;
    }

    /**
     * @param $number ClassRoome number
     * @return Model ClassRoom Name
     */
    public function getRoomName($number)
    {
        $name = $this->where(['number'=>$number])->field('name')->find();
        return $name;
    }

    /**
     * @param $name Room Name
     * @return mixed   data['name'] = '701'
     */
    public function getRoomNumber($name)
    {
        $number = $this->where(['name'=>$name])->field('number')->find();
        return $number;
    }

    /**
     * @return array [0]=>'12332',[1]=>'7787'
     */
    public function getAllNum()
    {
        $data = $this->field('number')->select();
        $info = array();
        foreach($data as $v)
        {
            array_push($info,$v['number']);
        }
        return $info;
    }
}