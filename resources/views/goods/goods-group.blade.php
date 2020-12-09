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
        <div class="layui-inline" style="color:gray" id="lp_address">
        </div>
    </div>



    <div class="layui-row" id="popUpdateTest" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"
            style="margin:20px">

            <div class="layui-form-item">
                <label class="layui-form-label">分类名称</label>
                <div class="layui-input-block">
                    <input type="text" name="type_name" required lay-verify="type_name" autocomplete="off"
                        placeholder="请输入分类名称" value="" class="layui-input">
                </div>
            </div>



<br>
            <div class="layui-form-item ">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="editAccount">保存</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
    
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>

    </script>

    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
        var layedit;
        layui.use(['table', 'layer','laydate', 'upload','jquery', 'form'], function () {
          

         
            var table = layui.table;
            var laydate = layui.laydate;
            var $ = layui.jquery;
            var form = layui.form;
        


            $(document).on('click', '#admin-management', function () {
                location.href='addgroup';
            });





            table.render({
                url: "goods" //数据接口
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
                      
                        }, {
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


            table.on('tool(user)', function (obj) {
                var data = obj.data;
                console.log(data);
                if (obj.event === 'del') {

                    layer.confirm('真的删除此分类么', function (index) {
                        $.ajax({
                            url: "goods/"+data.id,
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
                } else if (obj.event === 'edit') {
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "修改名称",
                        area: ['600px', '300px'],
                        content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                    //动态向表传递赋值可以参看文章进行修改界面的更新前数据的显示，当然也是异步请求的要数据的修改数据的获取
                    form.val("formUpdate", data);
                    setFormValue(obj, data);
                } else if (obj.event === 'show') {
                    console.log(data.type_name);
               
                   var id= data.id
                   tableIns= table.render({
                      url: "gain/demand/type"+'/'+id //数据接口
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
                                  field: 'type_name',
                                  title: '分类名称',
                              }, {
                                  field: 'parent_id',
                                  title: '父类ID',
                                  width: 100
                              }, {
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
                }

            });

            function setFormValue(obj, data) {
                form.on('submit(editAccount)', function (massage) {
                    massage = massage.field;
                    console.log(data);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "update/name",
                        type: 'post',
                        data: {
                            id: data.id,
                            type_name: massage.type_name,
                        },
                        success: function (msg) {
                            console.log(msg);
                            if (msg.status == 200) {
                                layer.closeAll('loading');
                                layer.load(2);
                                layer.msg("修改成功", {
                                    icon: 6
                                });
                                setTimeout(function () {

                                    obj.update({
                                        type_name: massage.type_name,
                                    }); //修改成功修改表格数据不进行跳转 


                                    layer.closeAll(); //关闭所有的弹出层
                                    //window.location.href = "/edit/horse-info";

                                }, 1000);

                            } else {
                                layer.msg("修改失败", {
                                    icon: 5
                                });
                            }
                        }
                    })
                    return false;
                })
            }

        })

    </script>
</body>

</html>
