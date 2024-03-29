<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文章分类</title>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
<div class="weadmin-nav">
			<span class="layui-breadcrumb">
		        <a href="">首页</a>
		        <a href="">文章管理</a>
		        <a><cite>分类管理</cite></a>
		    </span>
    <a class="layui-btn layui-btn-sm" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
</div>
<div class="weadmin-body">
    <div class="weadmin-block">
        <button class="layui-btn" id="expand">全部展开</button>
        <button class="layui-btn" id="collapse">全部收起</button>
        <button class="layui-btn" onclick="WeAdminShow('添加分类','{{url('admin/blog/categoryAddshow')}}')"><i class="layui-icon"></i>添加</button>
{{--        <span class="fr" style="line-height:40px">共有数据：66 条</span>--}}
    </div>

    <div id="demo"></div>
</div>
<script src="/lib/layui/layui.js" charset="utf-8"></script>
<script src="/static/js/category.js" type="text/javascript" charset="utf-8"></script>
</body>

</html>
