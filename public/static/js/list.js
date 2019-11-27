layui.extend({
	admin: '{/}/static/js/admin'
});

layui.use(['table', 'jquery','form', 'admin'], function() {
	var table = layui.table,
		$ = layui.jquery,
		form = layui.form,
		admin = layui.admin;

	table.render({
		elem: '#articleList',
		cellMinWidth: 80,
		cols: [
			[{
				type: 'checkbox'
			}, {
				field: 'id',title: 'ID',sort: true
			}, {
				field: 'title',title: '标题',templet: '#usernameTpl'
			},
                {
                    field: 'author',title: '发布者',sort: true
                },
                {
				field: 'updatetime',title: '发布时间',sort: true
			}, {
				field: 'ctitle',title: '分类',sort: true
			}, {
				field: 'sort',title: '排序',sort: true
			}, {
				field: 'operate',title: '操作',toolbar: '#operateTpl',unresize: true
			}]
		],
        url:'/admin/blog/aritclelist',
		event: true,
		page: true,
        done: function(res, curr, count){
            console.log(res);

            //得到当前页码
            console.log(curr);

            //得到数据总量
            console.log(count);
            $('.fr').html('共有数据：'+count+' 条');
        }
	});


    $('.searchBtn').on('click',function(){
        table.reload('articleList', {
            where: {
                'search':$("#search").val(),
            }
        });
    });
	/*
	 *数据表格中form表单元素是动态插入,所以需要更新渲染下
	 * http://www.layui.com/doc/modules/form.html#render
	 * */
	$(function(){
		form.render();
        //监听工具条
        table.on('tool(article)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的 DOM 对象（如果有的话）

            if(layEvent === 'detail'){ //查看
                //do somehing
            } else if(layEvent === 'del'){ //删除
                layer.confirm('真的删除行么', function(index){

                    $.get('/admin/blog/DelArticle',{'id':data.id},function(res){
                        if(res.code==0){
                            obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                            layer.close(index);
                        }else{
                            layer.msg('操作失败!', {
                                icon: 5,
                                time: 1000
                            });
                        }
                    },'json')
                });
            } else if(layEvent === 'edit'){ //编辑
                //do something
                WeAdminShow('编辑','/admin/blog/editArticle?id='+data.id,600,400);
                //同步更新缓存对应的值
            } else if(layEvent === 'LAYTABLE_TIPS'){
                layer.alert('Hi，头部工具栏扩展的右侧图标。');
            }
        });
	});

	var active = {
		getCheckData: function() { //获取选中数据
			var checkStatus = table.checkStatus('articleList'),
				data = checkStatus.data;
			//console.log(data);
			//layer.alert(JSON.stringify(data));
			if(data.length > 0) {
				layer.confirm('确认要删除吗？' + JSON.stringify(data), function(index) {
					layer.msg('删除成功', {
						icon: 1
					});
					//找到所有被选中的，发异步进行删除
					$(".layui-table-body .layui-form-checked").parents('tr').remove();
				});
			} else {
				layer.msg("请先选择需要删除的文章！");
			}

		},
		Recommend: function() {
			var checkStatus = table.checkStatus('articleList'),
				data = checkStatus.data;
			if(data.length > 0) {
				layer.msg("您点击了推荐操作");
				for(var i = 0; i < data.length; i++) {
					console.log("a:" + data[i].recommend);
					data[i].recommend = "checked";
					console.log("aa:" + data[i].recommend);
					form.render();
				}

			} else {
				console.log("b");
				layer.msg("请先选择");
			}

			//$(".layui-table-body .layui-form-checked").parents('tr').children().children('input[name="zzz"]').attr("checked","checked");
		},
		Top: function() {
			layer.msg("您点击了置顶操作");
		},
		Review: function() {
			layer.msg("您点击了审核操作");
		}

	};

	$('.demoTable .layui-btn').on('click', function() {
		var type = $(this).data('type');
		active[type] ? active[type].call(this) : '';
	});

	/*用户-删除*/
	window.member_del = function(obj, id) {
		layer.confirm('确认要删除吗？', function(index) {
			//发异步删除数据
			$(obj).parents("tr").remove();
			layer.msg('已删除!', {
				icon: 1,
				time: 1000
			});
		});
	}

});

function delAll(argument) {
	var data = tableCheck.getData();
	layer.confirm('确认要删除吗？' + data, function(index) {
		//捉到所有被选中的，发异步进行删除
		layer.msg('删除成功', {
			icon: 1
		});
		$(".layui-form-checked").not('.header').parents('tr').remove();
	});
}
