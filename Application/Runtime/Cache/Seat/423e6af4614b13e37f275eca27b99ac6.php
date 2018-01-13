<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BIUBIUBIU</title>
    <script src="https://cdn.bootcss.com/jquery/2.2.1/jquery.js"></script>
    <script type="text/javascript" src="/seat/Public/bootstrap-3.3.7/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/seat/Public/bootstrap-3.3.7/css/bootstrap.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form  class="form-inline" id="location">
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
                <table class="table" id="itable">
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
            $.ajax({
                type:"POST",
                url:"<?php echo U('Seat/Explore/ajax_who');?>",
                data:{
                    seatid:seat
                },
                success:function(data){
                    //循环生成表格

                }
            });
            return false;
        }
    </script>
</body>
</html>