<?php
/**
 * Created by PhpStorm.
 * User: Btainlee
 * Date: 2018/1/8
 * Time: 23:27
 */
namespace Seat\Controller;

use Think\Controller;
use GuzzleHttp\Client;


class CoreController extends Controller
{

    protected $apis = array(
        'cookies'=> 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/login.aspx',
        'seats'=>'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/reserve.aspx',
        'roominfo'=>'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/device.aspx',
        'ownerinfo'=>'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/data/searchAccount.aspx',
    );

    /**
     * @param $id 可以从网页版图书馆预约的学号
     * @param $pwd 可以从网页版图书馆预约的密码
     * @return Client 一个带有已认证Cookies的Http客户端。
     */
    public function getClient($id,$pwd)
    {
        $client = new Client(['cookies'=>true]);
        $client->request('POST',$this->apis['cookies'],['form_params'=>['id'=>'','pwd'=>'','act'=>'login']]);
        return $client;
    }

    public function getSeat()
    {

    }
}