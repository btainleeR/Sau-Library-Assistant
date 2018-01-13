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

    public function getRoomNumber($name)
    {
        $number = $this->where(['name'=>$name])->field('number')->find();
        return $number;
    }
}