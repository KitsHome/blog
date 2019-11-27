<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>文章列表</title>
    <meta name="Description" content="基于layUI数据表格操作"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/css/font.css">
    <link rel="stylesheet" href="/static/css/weadmin.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .layui-card{
            margin-left: 20px;
            margin-top: 20px;
            height: 600px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        #box::-webkit-scrollbar {
            display: none;
        }
        .layui-card-header{
            text-align: center;
            color: red;
        }
        .author{
            padding-left:40px;
            font-size: 8px;
            color:black ;
        }
        .pushtime{
            padding-left: 20px;
            font-size: 8px;
            color: #0a628f;
        }
        #test1{
            padding-left: 40px;
            background-color: white;
        }
    </style>
</head>

<body>
<ul class="layui-nav layui-bg-green" lay-filter="">
    <li class="layui-nav-item">
        <a href="javascript:;">欢迎来到sts平台<span class="layui-badge">9</span></a>
    </li>
</ul>
<div class="layui-main">

    <div class="layui-form-item" style="border-bottom:1px solid #009688;padding: 20px 10px;">
        <div class="layui-inline layui-form" style="width:240px;margin-right: 0;">
            <select name="modules" lay-verify="required" lay-search="" id="test_user"  lay-filter="test_user" >
                <option value="0">选择或输入...</option>
            </select>
        </div>
    </div>
    <div class="layui-box" style="margin-top:15px;margin-left: 40px;"  lay-filter="navbreak">
        <span class="layui-breadcrumb" lay-separator="|">
        </span>
    </div>
{{--开始--}}
    <div class="layui-carousel" id="test1">
        <div carousel-item>
            <img src="https://static.runoob.com/images/mix/img_fjords_wide.jpg" alt="">
            <img src="https://static.runoob.com/images/mix/img_nature_wide.jpg" alt="">
            <img src="https://static.runoob.com/images/mix/img_mountains_wide.jpg" alt="">
        </div>
    </div>
{{--    结束--}}
    <div class="layui-container">
        <div class="layui-row articlelist">
{{--            <div class="layui-col-xs6 layui-col-sm6 layui-col-md6">--}}
{{--                <div class="layui-card layui-bg-blue">--}}
{{--                    <div class="layui-card-header">卡片面板 <span class="author">作者</span></div>--}}
{{--                    <div class="layui-card-body">--}}
{{--                        卡片式面板面板通常用于非白色背景色的主体内<br>--}}
{{--                        从而映衬出边框投影--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

        </div>


    </div>
</div>




</body>
<script src="/lib/layui/layui.js" charset="utf-8"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    layui.extend({
        admin: '{/}/static/js/admin'
    });
    layui.use(['admin','layer','element','form', 'carousel'], function(){
        var layer = layui.layer
            admin=layui.admin,
             form = layui.form,
            element = layui.eleme;
        var carousel = layui.carousel;

        carousel.render({
            elem: '#test1'
            ,width: '100%' //设置容器宽度
            ,arrow: 'always' //始终显示箭头
            //,anim: 'updown' //切换动画方式
        });
    });

    $(function(){
        $.extend({
            getlist:function(keyword){
                $.get('/getlist',{'cid':keyword},function(data){
                    if(data.code==0){
                        var data = data.data;
                        var len = data.length;
                        var sel = ''
                        console.log(data);
                        for(var i=0;i<len;i++){
                             sel+='<div class="layui-col-xs6 layui-col-sm6 layui-col-md6">' +
                                 '<div class="layui-card layui-bg-blue">' +
                                 '<div class="layui-card-header">'+data[i]['title']+' <span class="author">作者: '+data[i]['author']+'</span><span class="pushtime">发布时间: '+data[i]['updatetime']+'</span></div>' +
                                 '<div class="layui-card-body">' +data[i]['context'] +

                                 '</div>' +
                                 '</div>' +
                                 '</div>'
                        }
                         $('.articlelist').html('');
                         $('.articlelist').append(sel);
                        // form.render(); //更新全部
                    }
                },'json')
            }
        });
        $.getlist(0);
        $('.layui-box').on('click','.getmorelist',function() {
            $.getlist($(this).attr('values'));
           console.log( $(this).attr('values'));
        })
        //渲染下拉搜索框
        $.get('/getcategory',{},function(data){
            if(data.code==0){
                var data = data.data;
                var len = data.length;
                var sel = '';
                var cate='';
                for(var i=0;i<len;i++){
                    sel+='<option value="'+data[i].cid+'" >'+data[i].title+'</option>'
                    cate+='<a href="javascript:;" class="getmorelist" values="'+data[i].cid+'">'+data[i].title+'</a><span lay-separator="">|</span>'

                }
                $('#test_user').append(sel);
                $('.layui-breadcrumb').append(cate);
                // element.render('navbreak');
                form.render(); //更新全部
            }
            //监听下拉框
            form.on('select(test_user)', function(data){
                var txt = $("#test_user option:selected").text();//获取select选中的值
                $('.test_user').html(txt);
                console.log($("#test_user option:selected").val())
                $.getlist($("#test_user option:selected").val());
            });
        },'json')
    })
</script>
</html>

