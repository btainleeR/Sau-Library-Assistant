<center><img src="https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=2177129568,1664756007&fm=58" /></center>
<h2>沈阳航空航天大学图书馆API 列表</h2><hr>

- 1  预约系统登录接口（Cookies获取接口）  
<b>http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/login.aspx</b><br> ,POST方式提交，参数有(id,pwd,act)，分别对应位(学号,密码,行为),act参数的值指定位<code>login</code>.

- 2  预约座位接口(自修室)  
<b>http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/reserve.aspx</b>,  
GET方式提，注意url参数的url编码问题。<font color="red">通过Cookies识别用户身份，无Cookies禁止调用</font>

<h5>参数列表:</h5>  

```javascript
{
            'dev_id'    =>  '', // 座位唯一编号(在获取座位编号接口获取)
            'lab_id'    =>  '', //留空
            'kind_id'   =>  '', //留空
            'room_id'   =>  '', //留空
            'type'      =>  'dev', //默认dev
            'prop'      =>  '', //留空
            'test_id'   =>  '', //留空
            'term'      =>  '', //留空
            'test_name' =>  '', //留空
            'start'     =>  '2017-12-23 12:00', //类似如此时间格式
            'end'       =>  '2017-12-23 14:00', //类似如此时间格式
            'start_time'=>  '1200', //与start参数时间相对应
            'end_time'  =>  '1400', //与end参数时间相对应
            'up_file'   =>  '', //留空
            'memo'      =>  '', //留空
            'act'       =>  'set_resv', //固定值
            '_'         =>  time().rand(111,999), //毫秒级时间戳
}
```

- 3  座位唯一编号接口
<b>http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/device.aspx</b>  
<code>GET</code>方式获取。需要携带Cookies,无Cookie无法调用。
<h4>参数列表:</h4>

```javascript
{
    'byType'=>'devcls',
    'classkind'=>'8',
    'display'=>'fp',
    'md'=>'d',
    'room_id'=>'100456538', //房间号id,每个屋子有唯一的编号，通过教室编号对应表获得
    'purpose'=>'',
    'cld_name'=>'default',
    'date'=> '2017-12-21',  //查询日期，返回令人惊喜的数据
    'fr_start'=>'15:40',    //格式相同且合法
    'fr_end'=>'16:40',      //格式相同且合法
    'act'=>'get_rsv_sta',
    '_'=>'1514014834075',   //毫秒级时间戳
 }
```
 <h5>屋子编号对应表:</h5>
 
```javascript
{
    '701'   =>      '107396184',
    '702'   =>      '100457241',
    '634'   =>      '100456540',
    '637'   =>      '100456542',
    '643'   =>      '100456544',
    '648'   =>      '100456546',
    '652'   =>      '100456548',
    '655'   =>      '100456550',
    '620'   =>      '100456448',
    '623'   =>      '100456530',
    '626'   =>      '100456532',
    '629'   =>      '100456534',
    '630'   =>      '100456536',
    '631'   =>      '100456538',
    //更多待续。。
}
```

- 4 更具精确姓名搜索信息
<b>http://libreserve.sau.edu.cn/ClientWeb/pro/ajax/data/searchAccount.aspx</b>
<code>GET</code>方式获取。需要携带Cookies,无Cookies无法调用。
<h4>参数说明:</h4>

```javascript
{
    'type'  => '',
    'term'  =>'***',    //用户姓名
    '_'     => time().rand(111,999),
}
```


