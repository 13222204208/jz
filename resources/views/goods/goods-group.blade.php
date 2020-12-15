<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>添加套餐产品 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>

<body>

    <div class="demoTable" style="margin:30px;">
        <button class="layui-btn" data-type="reload" value="0" id="admin-management">添加套餐</button>
     
    </div>





    <table class="layui-hide" id="LAY_table_user" lay-filter="myuser"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="show">查看详情</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>

    </script>

    <div class="layui-row" id="showTest" style="display:none;">
        <table class="layui-hide" id="LAY_tables" lay-filter="groupuser"></table>

    </div>

    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
       
        layui.use(['table', 'layer','laydate', 'upload','jquery', 'form'], function () {
          

         
             table = layui.table;
             laydate = layui.laydate;
             $ = layui.jquery;
             form = layui.form;
        


            $(document).on('click', '#admin-management', function () {
                location.href='addgroup';
            });


            table.render({
                url: "group" //数据接口
                    ,
                page: true //开启分页
                    ,
                elem: '#LAY_table_user',
                cols: [
                    [
                        {
                            field: 'id',
                            title: 'ID',
                            width: 80,
                            sort: true
                        }, {
                            field: 'title',
                            title: '套餐名称',
                            width:150
                        },{
                            field: 'package_price',
                            title: '套餐价格',
                            width:150
                        }, {
                            field: 'created_at',
                            title: '创建时间',
                        },{
                            field: 'status',
                            title: '状态',
                            //width:150,
                            templet: function(d) {
                                if (d.status == 1) {
                                  return '<div class="layui-input-block">'+
                                    '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                     '" lay-skin="switch" checked '+ 'lay-text="上架|下架">'+
                                  '</div>';
                                }else{
                                    return '<div class="layui-input-block">'+
                                        '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                         '" lay-skin="switch" lay-text="上架|下架">'+
                                      '</div>';
                                }
                              }
                        },{
                            fixed: 'right',
                            title: "操作",
                            align: 'center',
                            toolbar: '#barDemo'
                        }
                    ]
                ],
                parseData: function (res) { //res 即为原始返回的数据
                    console.log(res);
                    return {
                        "code": '0', //解析接口状态
                        "msg": res.message, //解析提示文本
                        "count": res.total, //解析数据长度
                        "data": res.data //解析数据列表
                    }
                },
                id: 'testReload',
                title: '后台用户',
                totalRow: true

            });

            form.on('switch(switchGoodsID)',function (data) {
                
                //开关是否开启，true或者false
                var checked = data.elem.checked;

                if(checked === false){
                    checked = 2;
                }else{
                    checked = 1;
                }

                //获取所需属性值
                var switch_goods_id = data.elem.attributes['switch_goods_id'].nodeValue;
                console.log(checked);
                console.log(switch_goods_id);
                $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "group"+'/'+switch_goods_id ,
                    type: 'patch',
                    data: {
                        status:checked
                    },
                    success: function(msg) {
                      console.log(msg);
                      if (msg.status == 200) {

            
                        form.render();

                        layer.msg("修改成功", {
                            icon: 1
                          });
                      } else {
                        layer.msg("修改失败", {
                          icon: 5
                        });
                      }
                    }
                  });


               });


            table.on('tool(myuser)', function (obj) {
                var data = obj.data;
                var event = obj.event;
                id = data.id;
                console.log(data);

                if (event === 'show') {
                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "group"+'/'+id ,
                        type: 'get',
                        success: function(msg) {
                          console.log(msg);
                          if (msg.status == 200) {
                            table.render({
                                elem: '#LAY_tables',
                                data:msg.data,
                                cols: [
                                    [
                
                                        {
                                            field: 'id',
                                            title: 'ID',
                                            width: 80,
                                            sort: true
                                        }, {
                                            field: 'title',
                                            title: '产品名称',
                                            width:150
                                        },{
                                            field: 'description',
                                            title: '产品描述',
                                            width:150
                                        }, {
                                            field: 'content',
                                            title: '产品详情',
                                      
                                        },{
                                            field: 'number',
                                            title: '库存',
                                            width:150
                                      
                                        },{
                                            field: 'price',
                                            title: '单价',
                                            width:150
                                      
                                        }
                                    ]
                                ]
                                ,even: true
                                ,page: true //是否显示分页
                                //,limits: [5, 7, 10]
                                ,limit: 10 //每页默认显示的数量   
                        }); 
                          } else {
                            layer.msg("修改失败", {
                              icon: 5
                            });
                          }
                        }
                      })
                  layer.open({
                    //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                    type: 1,
                    title: "套餐详情",
                    area: ['800px', '600px'],
                        content: $("#showTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });
         

                  } 
        

                if (event === 'del') {

                    layer.confirm('真的删除此分类么', function (index) {
                        $.ajax({
                            url: "group/"+data.id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            type: "delete",
                            success: function (msg) {
                                console.log(msg); 
                                if (msg.status == 200) {
                                    //删除这一行
                                    obj.del();
                                    //关闭弹框
                                    layer.close(index);
                                    layer.msg("删除成功", {
                                        icon: 6
                                    });
                                } else {
                                    layer.msg("删除失败", {
                                        icon: 5
                                    });
                                }
                            }
                        });
                        return false;
                    });
                }

            });

        })

    </script>
</body>

</html>
