<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/13
 * Time: 19:26
 */
namespace Seat\Controller;
use Seat\Model\SeatIdModel;
use Think\Controller;

class HtmlController extends Controller
{
    public function exploreIndexSelect($roomname)
    {
        $seatModel = new SeatIdModel();
        $seats = $seatModel->getSeatsLikeName($roomname);
        $this->assign('seats',$seats);
        return $this->fetch('Html/exploreIndexSelect');
    }
}