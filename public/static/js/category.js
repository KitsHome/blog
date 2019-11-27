function del(nodeId) {
    $.get('/admin/blog/delcate',{'cid':nodeId},function(res) {
        /////success
        if(res.code==0){
                //发异步把用户状态进行更改
                layer.msg('已删除!', {
                    icon: 6,
                    time: 1000
                });
            parent.location.reload();

        }else{
            layer.msg('操作失败!', {
                icon: 5,
                time: 1000
            });
        }

    },'json')
}
/*分类-停用*/
function member_stop(obj, id) {
	var confirmTip;
	var status;
	if($(obj).attr('title') == '启用') {
		confirmTip = '确认要停用吗？';
        status=0;
	} else {
		confirmTip = '确认要启用吗？';
        status=1;
	}
	layer.confirm(confirmTip, function(index) {
        $.get('/admin/blog/editstatus',{'id':$(obj).attr('values'),'status':status},function(res) {
            /////success
            if(res.code==0){
                if($(obj).attr('title') == '启用') {
                    //发异步把用户状态进行更改
                    $(obj).attr('title', '停用')
                    $(obj).find('i').html('&#xe62f;');
                    $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                    layer.msg('已停用!', {
                        icon: 5,
                        time: 1000
                    });
                } else {
                    $(obj).attr('title', '启用')
                    $(obj).find('i').html('&#xe601;');

                    $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                    layer.msg('已启用!', {
                        icon: 6,
                        time: 1000
                    });
                }
            }else{
                layer.msg('操作失败!', {
                    icon: 5,
                    time: 1000
                });
            }

        },'json')

	});
}
//自定义的render渲染输出多列表格
var layout = [{
		name: '菜单名称',
		treeNodes: true,
		headerClass: 'value_col',
		colClass: 'value_col',
		style: 'width: 60%'
	},
	{
		name: '状态',
		headerClass: 'td-status',
		colClass: 'td-status',
		style: 'width: 10%',
		render: function(row) {
		    console.log(row.status);
		    if(row.status=='1'){
                return '<span class="layui-btn layui-btn-normal layui-btn-xs">已启用</span>';
            }else{
                return '<span class="layui-btn layui-btn-normal layui-btn-xs">未启用</span>';
            }

		}
	},
	{
		name: '操作',
		headerClass: 'td-manage',
		colClass: 'td-manage',
		style: 'width: 20%',
		render: function(row) {
		    // console.log(row);
			return '<a onclick="member_stop(this,' + row.id + ')" values="'+row.id+'" class="member_stop" href="javascript:;" title="启用"><i class="layui-icon">&#xe601;</i></a>' +
				'<a title="添加子类" onclick="WeAdminShow(\'添加\',\'/admin/blog/categoryAddshow\')" href="javascript:;"><i class="layui-icon">&#xe654;</i></a>' +
				'<a title="编辑" onclick="WeAdminShow(\'编辑\',\'/admin/blog/editcategoryshow?cid='+row.id+'\')" href="javascript:;"><i class="layui-icon">&#xe642;</i></a>' +
				'<a title="删除" onclick="del(' + row.id + ')" href="javascript:;">\<i class="layui-icon">&#xe640;</i></a>';
			//return '<a class="layui-btn layui-btn-danger layui-btn-mini" onclick="del(' + row.id + ')"><i class="layui-icon">&#xe640;</i> 删除</a>'; //列渲染
		}
	},
];
//加载扩展模块 treeGird
//		layui.config({
//			  base: './static/js/'
//			  ,version: '101100'
//			}).use('admin');
layui.extend({
	admin: '{/}../../static/js/admin',
	treeGird: '{/}../../lib/layui/lay/treeGird' // {/}的意思即代表采用自有路径，即不跟随 base 路径
});
layui.use(['treeGird', 'jquery', 'admin', 'layer'], function() {
	var layer = layui.layer,
		$ = layui.jquery,
		admin = layui.admin,
		treeGird = layui.treeGird;
	    var categorylist='';
        $.ajax({
            url:'/admin/blog/categorychildList',
            type:'get',
            dataType:'json',
            async:false,
            success:function(res) {
                console.log(res);
                if(res.code==0){
                    // console.log(11111);
                    categorylist=res.data;
                    // $('.fr').html('共有数据：'+(categorylist.length-1)+' 条')
                    console.log(categorylist);
                }
            }
        });
        console.log(categorylist);
	var tree1 = layui.treeGird({
		elem: '#demo', //传入元素选择器
		spreadable: true, //设置是否全展开，默认不展开
		nodes:categorylist,
        //     [{
		// 		"id": "1",
		// 		"name": "父节点1",
		// 		"children": [{
		// 				"id": "11",
		// 				"name": "子节点11"
		// 			},
		// 			{
		// 				"id": "12",
		// 				"name": "子节点12"
		// 			}
		// 		]
		// 	},
		// 	{
		// 		"id": "2",
		// 		"name": "父节点2",
		// 		"children": [{
		// 			"id": "21",
		// 			"name": "子节点21",
		// 			"children": [{
		// 				"id": "211",
		// 				"name": "子节点211"
		// 			}]
		// 		}]
		// 	}
		// ],
		layout: layout
	});
	$('#collapse').on('click', function() {
		layui.collapse(tree1);
	});

	$('#expand').on('click', function() {
		layui.expand(tree1);
	});
});
