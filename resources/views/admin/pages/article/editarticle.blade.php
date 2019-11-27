<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>发布信息</title>
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
        <input type="hidden" name="id" id="id" value="{{$id}}"/>

        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" id="title" lay-verify="required" jq-error="请输入信息标题" placeholder="请输入信息标题" autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">分类</label>
            <div class="layui-input-inline">
                <select name="cid" id="pid-select" lay-verify="required" lay-filter="cid-select">

                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">作者</label>
            <div class="layui-input-block">
                <input type="text" name="author" id="author" lay-verify="required" jq-error="请输入作者" placeholder="请输入作者" autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">详细内容</label>
            <div class="layui-input-inline" style="width: 80%" id="editor">

            </div>
            <textarea id="context" name="context" style="display: none;width: 100%" class="layui-input "></textarea>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" name="sort" id="order" lay-verify="number" value="100" jq-error="排序必须为数字" placeholder="分类排序" autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-inline">
                <input type="radio" name="is_enable" class="status" title="启用" value="1" checked />
                <input type="radio" name="is_enable" class="status" title="禁用" value="0" />
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">信息生效时间</label>
            <div class="layui-input-block" style="width: 30%">
                <input type="text" name="starttime" id="starttime" value=""  autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">信息作废时间</label>
            <div class="layui-input-block" style="width: 30%">
                <input type="text" name="endtime" id="endtime" value=""  autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">信息发布时间</label>
            <div class="layui-input-block" style="width: 30%">
                <input type="text" name="updatetime" id="updatetime" value=""  autocomplete="off" class="layui-input ">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block" >
                <button class="layui-btn" lay-submit="" lay-filter="add">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script src="/lib/layui/layui.js" charset="utf-8"></script>
<script src="https://unpkg.com/wangeditor@3.1.1/release/wangEditor.min.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.extend({
        admin: '{/}/static/js/admin'
    });
    layui.use(['admin','jquery','form', 'layer','layedit','laydate'], function() {
        var admin = layui.admin,
            $ = layui.jquery,
            form = layui.form,
            // layedit = layui.layedit,
            layer = layui.layer,
            laydate = layui.laydate;
        laydate.render({
            elem: '#starttime', //指定元素
            type:'datetime',
            value: new Date(),
            isInitValue:true
        });
        laydate.render({
            elem: '#endtime', //指定元素
            type:'datetime',
            value: new Date(),
            isInitValue:true
        });
        laydate.render({
            elem: '#updatetime', //指定元素
            type:'datetime',
            value: new Date(),
            isInitValue:true
        });
        // layedit.set({//关于编辑器图片上传
        //     uploadImage: {
        //         url: '/admin/blog/uploadimage' //接口url
        //         ,type: 'post' //默认post
        //     }
        // });
        // layedit.build('context',{
        //     height: 180
        // }); //建立编辑器
        // form.verify({
        //     content:function () {
        //         layedit.sync('context')
        //     }
        // });


        //监听提交
        form.on('submit(add)', function(data) {
            console.log(data.field);
            console.log(data.field.context);
            var form_data=data.field;
            // form_data.context=layedit.getContent();
            //发异步，把数据提交给php
            $.ajax({
                url:'/admin/blog/articleEditPush',
                type:'post',
                data:form_data,
                dataType:'json',
                success:function(ret) {
                    if(ret.code==0){
                        layer.alert("增加成功", {
                            icon: 6
                        }, function() {
                            // 获得frame索引
                            var index = parent.layer.getFrameIndex(window.name);
                            //关闭当前frame
                            parent.layer.close(index);
                        });
                        return false;
                    }else{
                        layer.alert("增加失败", {
                            icon: 5
                        });
                        return false;
                    }
                }
            });

            return false;
        });


        var E = window.wangEditor
        var editor = new E('#editor');
        var $text1 = $('#context');
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        }
        editor.customConfig.debug = true
// 隐藏“网络图片”tab
        editor.customConfig.showLinkImg = true
// 关闭粘贴内容中的样式
        editor.customConfig.pasteFilterStyle = false
// 忽略粘贴内容中的图片
        editor.customConfig.pasteIgnoreImg = false
// 将图片大小限制为 3M
        editor.customConfig.uploadImgMaxSize = 5 * 1024 * 1024
// 限制一次最多上传 1 张图片
        editor.customConfig.uploadImgMaxLength = 1
        editor.customConfig.uploadImgServer = '/admin/blog/uploadimage';
        editor.customConfig.uploadFileName = 'file';

// 使用 base64 保存图片
        editor.customConfig.uploadImgShowBase64 = true

        editor.customConfig.uploadImgHooks = {
            customInsert: function (insertImg, result, editor) {
                var url =result.data;//获取后台返回的url
                console.log("image url = " + url)
                insertImg(url);
            }
        };

        editor.create()
        // 初始化 textarea 的值
        $text1.val(editor.txt.html())
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
            $.get('/admin/blog/getlistone',{'id':$('#id').val()},function(res) {
                /////success
                if(res.code==0){
                    //更改分类
                    $("#pid-select").val(res.data.cid);
                    $("#title").val(res.data.title);
                    $("#author").val(res.data.author);
                    $("#order").val(res.data.sort);
                    $('.status').each(function(){
                        if($(this).val()==res.data.is_enable){
                            $(this).attr('checked','checked');
                        }else{
                            $(this).attr('checked',false);
                        }
                    });
                    $("#updatetime").val(res.data.updatetime);
                    $("#starttime").val(res.data.starttime);
                    $("#endtime").val(res.data.endtime);

                    // $("#context").val(res.data.context);
                    editor.txt.html(res.data.context);
                    // console.log(layedit);
                    //console.log('context',layedit.setContent('res.data.context'));
                    // console.log(layedit.getContent());
                    form.render();
                    laydate.render();
                    // layedit.render();
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
