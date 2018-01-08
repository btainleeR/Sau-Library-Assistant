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
    <title>预约管理</title>
</head>
<body>
    <div class="layui-container">
        <div class="layui-row">
            <div class="layui-col-md12" style="margin-top:10%">
                <table class="layui-table layui-table-bordered">
                    <tr>
                        <th>Nick</th>
                        <th>Username</th>
                        <th>PAsswoRd</th>
                        <th>Start</th>
                        <th>EnD</th>
                        <th>Seat</th>
                        <th>Status</th>
                        <th>Operate</th>
                    </tr>
                    <?php if(is_array($queues)): foreach($queues as $key=>$queue): ?><tr>
                            <th><?php echo ($queue['nickname']); ?></th>
                            <th><?php echo ($queue['username']); ?></th>
                            <th><?php echo ($queue['password']); ?></th>
                            <th><?php echo ($queue['start']); ?></th>
                            <th><?php echo ($queue['end']); ?></th>
                            <th><?php echo ($queue['seat']); ?></th>
                            <?php if($queue['status'] == 1 ): ?><th>
                                    <button class="layui-btn layui-btn-default"><i class="layui-icon layui-anim layui-anim-rotate layui-anim-loop">ဂ</i>运行中...</button>
                                    <button class="layui-btn layui-btn-danger" onclick="javascript:changestatus(<?php echo ($queue['id']); ?>);"><i class="layui-icon">停用</i></button>
                                </th>
                            <?php else: ?>
                                <th>
                                    <button class="layui-btn layui-btn-danger"><i class="layui-icon ">&#xe636;</i>已停用...</button>
                                    <button class="layui-btn layui-btn-success"><i class="layui-icon" onclick="javascript:changestatus(<?php echo ($queue['id']); ?>);">启用</i></button>
                                </th><?php endif; ?>
                            <th>
                                <button class="layui-btn layui-btn-danger" onclick="javascript:deletetask(<?php echo ($queue['id']); ?>);"><i class="layui-icon">&#xe640;删掉</i></button>
                            </th>
                        </tr><?php endforeach; endif; ?>
                </table>
                <button class="layui-btn layui-btn-info" id="addnew">添加</button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#addnew').click(function(){
            window.location = "<?php echo U('/Seat/Queue/add');?>";
        });

        function changestatus(id)
        {
            $.ajax({
                type:"POST",
                url: "<?php echo U('/Seat/Queue/ajax_changeStatus');?>",
                data:{
                    'id': id,
                },
                success: function(data) {
                    if(data.error ==0)
                    {
                        window.location = "<?php echo U('/Seat/Queue/index');?>";
                    } else
                    {
                        layer.msg('出错啦！');
                    }

                }
            });
        }

        function deletetask(id)
        {
            $.ajax({
                type:"POST",
                url:"<?php echo U('/Seat/Queue/ajax_deleteTask');?>",
                data:{
                    id:id,
                },
                success:function(data) {
                    if(data.error ==0 ){
                        window.location = "<?php echo U('/Seat/Queue/index');?>";
                    } else
                    {
                        layer.msg('出错啦!');
                    }
                }
            });
        }
    </script>
</body>
</html>