<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/seat/Public/layui/css/layui.css" >
    <script type="text/javascript" src="/seat/Public/layui/layui.js"></script>
    <script src="https://cdn.bootcss.com/jquery/2.2.0/jquery.js"></script>
    <title>添加预约</title>
</head>
<body>
    <div class="layui-container" style="margin-top: 6%">
        <div class="layui-row">
            <div class="layui-col-md6 layui-col-md-offset3">
                <form class="layui-form" action="">
                    <div class="layui-form-item">
                        <label class="layui-form-label">名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="nickname" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">学号</label>
                        <div class="layui-input-block">
                            <input type="text" name="username" required  lay-verify="required" placeholder="请输入学号" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">网页版密码</label>
                        <div class="layui-input-inline">
                            <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux"><button class="layui-btn layui-btn-sm layui-btn-info">测试账号</button></div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">开始时间</label>
                        <div class="layui-input-inline">
                            <input type="text" name="start" required lay-verify="required" placeholder="形如0730，1230" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">结束时间</label>
                        <div class="layui-input-inline">
                            <input type="text" name="end" required lay-verify="required" placeholder="形如0730，1230" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否启用</label>
                        <div class="layui-input-block">
                            <input type="checkbox" name="status" lay-skin="switch">
                        </div>
                    </div>

                    <div class="layui-form-item" >
                        <label class="layui-form-label">教室座位</label>
                        <div class="layui-form" >
                            <div class="layui-inline" id="seat">
                                <select name="room" lay-verify="required" lay-filter="room">
                                    <option value="">选择一个教室</option>
                                    <?php if(is_array($rooms)): foreach($rooms as $key=>$vo): ?><option value="<?php echo ($vo['number']); ?>"><?php echo ($vo['name']); ?></option><?php endforeach; endif; ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label" id="otherseats">其他座位:</label>

                    </div>


                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form;

            //监听提交
            form.on('submit(formDemo)', function(data){
                    var obj = document.getElementsByName("other_seats");
                    var check_val = [];
                    for(k in obj){
                        if(obj[k].checked)
                            check_val.push(obj[k].value);
                    }
                    var str = '';
                    $.each(check_val,function(i,n){
                         str += n+',';
                    });
                var idata = data.field;
                delete idata.other_seats;
                idata.other_seats = str;
                $.ajax({
                    "type":"POST",
                    "url":"<?php echo U('/Seat/Queue/ajax_addtask');?>",
                    "data":idata,
                    "success":function(data){
                        if(data.error == 0)
                        {
                            layer.msg(data.msg);
                            window.location = "<?php echo U('/Seat/Queue/index');?>";
                        }else
                        {
                            layer.msg(data.msg);
                        }
                    }
                });
                return false;
            });
            //监听下拉room
            form.on('select(room)', function(data){
                var room =  data.value;
                if($('#str1')){
                    $('#str1').remove();
                }
                if($('#str2')){
                    $('#str2').remove();
                }
                //ajax加载座位
                $.ajax({
                    "type":"GET",
                    "url":"<?php echo U('/Seat/Queue/ajax_loadSeat');?>",
                    "data":{
                      "room":room
                    },
                    success:function(data){
                        $('#seat').append(data.str1);
                        $('#otherseats').append(data.str2);
                        var form = layui.form;
                        form.render();
                    }
                });
            });
        });
    </script>

</body>
</html>