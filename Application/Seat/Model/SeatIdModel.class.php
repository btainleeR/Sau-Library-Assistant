<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/7
 * Time: 20:04
 */
namespace Seat\Model;
use Think\Model;

class SeatIdModel extends Model
{
    /**
     * @param $name Pre Room Name
     * @return mixed All Seats in this room
     */
    public function getSeatsLikeName($name)
    {
        $map['name'] = array('LIKE',$name.'%');
        $data = $this->where($map)->select();
        return $data;
    }


    /**
     * @param array $seats  Array of seats number
     * @return array        Array of seats name
     */
    public function getSeatsName(array $seats)
    {
        foreach($seats as $k=>$v)
        {
            $seats[$k]  = $this->where(['number'=>$v])->field('name')->find()['name'];
        }
        return $seats;
    }
}