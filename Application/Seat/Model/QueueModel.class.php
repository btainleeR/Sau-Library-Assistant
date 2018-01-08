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
    public function getAll()
    {
        $data = $this->select();
        return $data;
    }
}