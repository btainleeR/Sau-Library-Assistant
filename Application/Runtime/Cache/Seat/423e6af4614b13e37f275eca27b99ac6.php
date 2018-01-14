<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIUBIUBIU</title>
    <script src="/seat/Public/jquery-2.2.1.js"></script>
    <script type="text/javascript" src="/seat/Public/echarts.simple.min.js"></script>
    <script type="text/javascript" src="/seat/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/seat/Public/bootstrap-3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form  class="form-inline" id="location">
                    <div class="form-group">
                        <label for="when">时间</label>
                        <select name="whern" id="when" class="form-control">
                            <option value="1">今天</option>
                            <option value="2">明天</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room">选择教室</label>
                        <select name="room" id="room" class="form-control">
                            <?php if(is_array($rooms)): foreach($rooms as $key=>$room): ?><option value="<?php echo ($room['number']); ?>"><?php echo ($room['name']); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>

                </form>
                <button class="btn btn-primary" onclick="javascript:find()">查询</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3" id="content">
                <table class="table table-bordered table-hover" id="itable">
                    <tr>
                        <td>seat_name</td>
                        <td>start</td>
                        <td>end</td>
                        <td>state</td>
                        <td>name</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div style="width:600px;height:400px;margin: 0 auto;" id="pie">

    </div>

    <script type="text/javascript">
        $('#room').change(function(){
            $('#seat').remove();
           var roomId = $('#room').val();
           $.ajax({
               type:"POST",
               url:"<?php echo U('Seat/Explore/ajax_getSeats');?>",
               data:{
                    roomId:roomId
               },
               success:function(data){
                    $('#room').after(data.data);
               }
           });
        });
        function find()
        {
            var seat = $('#seat').val();
            var when = $('#when').val();
            $.ajax({
                type:"POST",
                url:"<?php echo U('Seat/Explore/ajax_who');?>",
                data:{
                    seatid:seat,
                    when:when
                },
                success:function(data){
                    $('.add').remove();
                    //循环生成表格
                    console.log(data.ownerInfo);
                    var ihtml = '';
                    $.each(data.ownerInfo.info,function(i,e){
                        tmp = '<tr class="add"><td>'+data.ownerInfo.seat_name+'</td><td>'+e.start+'</td><td>'+e.end+'</td><td>'+e.state+'</td><td>'+e.owner+'</td></tr>';
                        ihtml += tmp;
                    });

                    $('#itable').append(ihtml);
                }
            });
            return false;
        }

    </script>
    <script type="text/javascript">

    </script>
</body>
</html>