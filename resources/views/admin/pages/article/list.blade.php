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
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .layui-form-switch {
            width: 55px;
        }
        .layui-form-switch em {
            width: 40px;
        }
        body{overflow-y: scroll;}
    </style>
</head>

<body>
<div class="weadmin-nav">
			<span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">文章管理</a>
        <a>
          <cite>文章列表</cite></a>
      </span>
    <a class="layui-btn layui-btn-sm" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">&#x1002;</i></a>
</div>
<div class="weadmin-body">
    <div class="layui-row">
{{--        <form class="layui-form layui-col-md12 we-search">--}}
            文章搜索：
            <div class="layui-inline">
                <input type="text" name="search" id="search" placeholder="请输入关键字" autocomplete="off" class="layui-input">
            </div>
            <button class="layui-btn searchBtn"  lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
{{--        </form>--}}
    </div>
    <div class="weadmin-block demoTable">
{{--        <button class="layui-btn layui-btn-danger" data-type="getCheckData"><i class="layui-icon">&#xe640;</i>批量删除</button>--}}
{{--        <button class="layui-btn" data-type="Recommend"><i class="layui-icon">&#xe6c6;</i>推荐</button>--}}
{{--        <button class="layui-btn" data-type="Top"><i class="layui-icon">&#xe619;</i>置顶</button>--}}
{{--        <button class="layui-btn" data-type="Review"><i class="layui-icon">&#xe6b2;</i>审核</button>--}}
        <button class="layui-btn" onclick="WeAdminShow('发布信息','/admin/blog/addArticle',600,400)"><i class="layui-icon">&#xe61f;</i>添加</button>
        <span class="fr" style="line-height:40px">共有数据：0 条</span>
    </div>
    <table class="layui-hide" id="articleList" lay-filter="article"></table>
    <script type="text/html" id="operateTpl">
        <a title="编辑" lay-event="edit" href="javascript:;">
            <i class="layui-icon">&#xe642;</i>
        </a>
        <a title="查看" lay-event="detail" href="javascript:;">
            <i class="layui-icon">&#xe63c;</i>
        </a>
        <a title="删除" lay-event="del" href="javascript:;">
            <i class="layui-icon">&#xe640;</i>
        </a>
    </script>
    <script src="/lib/layui/layui.js" charset="utf-8"></script>
    <script src="/static/js/list.js" type="text/javascript" charset="utf-8"></script>

</div>
</body>

</html>
