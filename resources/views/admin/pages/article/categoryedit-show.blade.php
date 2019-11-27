<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>修改分类</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/css/font.css">
    <link rel="stylesheet" href="/static/css/weadmin.css">
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="weadmin-body">

    <form id="form1" class="layui-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
        <input type="hidden" name="id" id="cid" value="{{$cid}}">
        <div class="layui-form-item">
            <label class="layui-form-label">父级分类</label>
            <div class="layui-input-inline">
                <select name="pid" id="pid-select" lay-verify="required" lay-filter="pid-select">

                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">分类名称</label>
            <div class="layui-input-block">
                <input type="text" name="title" id="title" lay-verify="required" jq-error="请输入分类名称" placeholder="请输入分类名称" autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" name="sort" id="order" lay-verify="number" value="100" jq-error="排序必须为数字" placeholder="分类排序" autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">时间</label>
            <div class="layui-input-inline">
                <input type="text" name="updatetime" id="updatetime" value=""  autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-inline">
                <input type="radio" name="status" class="status" title="启用" value="1" checked />
                <input type="radio" name="status" class="status" title="禁用" value="0" />
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
{{--        <input type="hidden" name="level" value="0" />--}}
    </form>
</div>
<script src="/lib/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.extend({
        admin: '{/}/static/js/admin'
    });
    layui.use(['admin','jquery','form', 'layer','laydate'], function() {
        var admin = layui.admin,
            $ = layui.jquery,
            form = layui.form,
            layer = layui.layer;
        var laydate = layui.laydate;
        laydate.render({
            elem: '#updatetime', //指定元素
            type:'datetime'
        });
        //监听提交
        form.on('submit(add)', function(data) {
            console.log(data.field);
            //发异步，把数据提交给php
            $.ajax({
                url:'/admin/blog/categoryEdit',
                type:'post',
                data:data.field,
                dataType:'json',
                success:function(ret) {
                    if(ret.code==0){
                        layer.alert("修改成功", {
                            icon: 6
                        }, function() {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                        return false;
                    }else{
                        layer.alert("修改失败", {
                            icon: 5
                        });
                        return false;
                    }
                }
            });

            return false;
        });

        //遍历select option
        $(document).ready(function(){
            $.ajax({
                url:'/admin/blog/categoryinfo',
                type:'get',
                dataType:'html',
                success:function(ret){
                    $("#pid-select").append(ret);
                    form.render('select');
                    console.log(ret);

                }
            });
            $.get('/admin/blog/EditcategoryOne',{'cid':$('#cid').val()},function(res) {
                /////success
                if(res.code==0){
                    //更改顶级分类
                    $("#pid-select").val(res.data.pid);
                    $("#title").val(res.data.title);
                    $("#order").val(res.data.sort);
                    $('.status').each(function(){
                        if($(this).val()==res.data.status){
                            $(this).attr('checked','checked');
                        }else{
                            $(this).attr('checked',false);
                        }
                    });
                    $("#updatetime").val(res.data.updatetime);

                    form.render('select');
                    laydate.render();
                    console.log(res);
                }else{
                    layer.msg('操作失败!', {
                        icon: 5,
                        time: 1000
                    });
                }

            },'json')

            // $("#pid-select").find('option').each(function (text){
            //     alert(1);
            //     var level = $(this).attr('data-level');
            //     var text = $(this).text();
            //     console.log(text);
            //     if(level>0){
            //         text = "├　"+ text;
            //         for(var i=0;i<level;i++){
            //             text ="　　"+ text;　//js中连续显示多个空格，需要使用全角的空格
            //             //console.log(i+"text:"+text);
            //         }
            //     }
            //     $(this).text(text);
            //
            // });
            //
            // form.render('select'); //刷新select选择框渲染
        });

    });
</script>
</body>

</html>
