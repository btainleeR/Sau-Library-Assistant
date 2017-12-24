<?php

//  Author: Btainlee
//  Func:   优雅选座
//  Time: 2017/12/23


class getSeat
{
    protected $id = '';    //学号
    protected $passwd = '';       //密码
    protected $startTime = '';    // 开始时间 '2017-12-23 12:00',
    protected $endTime = '';        //结束时间
    protected $devId = '';          //座位编号
    protected $start_time = '';     // 开始时间  '1400',
    protected $end_time = '';       //结束时间

    private $getCookieUrl = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/login.aspx';
    private $getSeatUrl = 'http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/reserve.aspx';

   public $CookieFile = __DIR__.'/sauCookie.txt';
    
    public function __construct($id,$pwd,$data,$startTime,$endTime,$devId)
    {
        $this->id = $id;
        $this->passwd = $pwd;
        $this->startTime = $data .' '.substr($startTime,0,2).':'.substr($endTime,-2,2);
        $this->endTime = $data . ' '.substr($endTime,0,2).':'.substr($endTime,-2,2);
        $this->start_time = $startTime;
        $this->end_time = $endTime;
        $this->devId = $devId;
        var_dump($this->id,$this->passwd,$this->startTime,$this->endTime,$this->start_time,$this->end_time);
       
    }

    /**
     *  @ parm url   登录地址
     *  @ parm cookie   cookie文件保存位置
     *  @ parm post     提交的数据
     */
    public function getCookie()
    {
        $postData = array(
            'id'    =>  $this->id,
            'pwd'   =>  $this->passwd,
            'act'   =>  'login',
        );
        //get Cookie
        $curl = curl_init();    
        curl_setopt($curl,CURLOPT_URL,$this->getCookieUrl);
        curl_setopt($curl,CURLOPT_HEADER,0);    //hide header infomation
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,0);    // put return infomation into file
        curl_setopt($curl,CURLOPT_COOKIEJAR,$this->CookieFile);   // file location
        curl_setopt($curl,CURLOPT_POST,1);              //post method 
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($postData));  //post data infomation
        curl_exec($curl);   //run
        curl_close($curl);  //close
    }

    /**
     *  @ parm url      抢座地址
     *  @ parm cookie   cookie文件位置
     *  @ parm post     提交的数据
     *  @ FUNC          优雅选座
     */
    public function getSeat()
    {

        $getData = array(

            'dev_id'    =>  $this->devId,
            'lab_id'    =>  '',
            'kind_id'   =>  '',
            'room_id'   =>  '',
            'type'      =>  'dev',
            'prop'      =>  '',
            'test_id'   =>  '',
            'term'      =>  '',
            'test_name' =>  '',
            'start'     =>  $this->startTime,
            'end'       =>  $this->endTime,
            'start_time'=>  $this->start_time,
            'end_time'  =>  $this->end_time,
            'up_file'   =>  '',
            'memo'      =>  '',
            'act'       =>  'set_resv',
            '_'         =>  time().rand(111,999),
        );
        $baseUrl = $this->getSeatUrl.'?';
        $curl = curl_init();
        foreach($getData as $k=>$v)
        {
            if($v != '')
            {
                $v = curl_escape($curl,$v);
            }
                $baseUrl .= $k.'='.$v.'&';
        }
        $url = substr($baseUrl,0,-1);

        echo $url;
        
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);  
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->CookieFile); 
        echo "<br>";
        curl_exec($curl);
        curl_close($curl);
    }

    public function run()
    {
        $this->getCookie();
        $this->getSeat();
    }
    
}




