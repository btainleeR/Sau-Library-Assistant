<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/7
 * Time: 16:57
 */

namespace Seat\Model;
use Think\Model;

/**
 * Class QueueModel
 * @package Seat\Model  Operation Table Queue
 */
class QueueModel extends Model
{
    /**
     * @return mixed ALL data in Table queue
     */
    public function getAll()
    {
        $data = $this->select();
        return $data;
    }

    /**
     * @return mixed  All valid Data in Table quque
     */
    public function getValidTasks()
    {
        $data = $this->where(['status'=>1])->select();
        return $data;
    }
}