<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>优雅点~</title>
    <link rel="stylesheet" href="/seat/Public/layui/css/layui.css" >
    <script type="text/javascript" src="/seat/Public/layui/layui.js"></script>
</head>
<body>
<div class="layui-container" style="margin-top: 10%">
    <div class="layui-row">
        <div class="layui-col-md6 layui-col-md-offset3">
            <div class="layui-carousel" id="test1">
                <div carousel-item>
                    <div id="div1">
                        <a href="<?php echo U('/Seat/Queue/index');?>"><img src="/seat/Public/images/pic1.jpg"></a>
                    </div>
                    <div>
                        <a href="<?php echo U('/Seat/Explore/index');?>"><img src="/seat/Public/images/pic2.jpg"></a>
                    </div>
                    <div>条目3</div>
                    <div>条目4</div>
                    <div>条目5</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="layui-carousel" id="test1">
    <div carousel-item>
        <div id="div1">
            <h1>管理选座信息</h1>
        </div>
        <div>条目2</div>
        <div>条目3</div>
        <div>条目4</div>
        <div>条目5</div>
    </div>
</div>
<!-- 条目中可以是任意内容，如：<img src=""> -->

<script>
    layui.use('carousel', function(){
        var carousel = layui.carousel;
        //建造实例
        carousel.render({
            elem: '#test1'
            ,width: '100%' //设置容器宽度
            ,arrow: 'always' //始终显示箭头
            //,anim: 'updown' //切换动画方式
        });
    });
</script>
</body>
</html>