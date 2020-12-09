<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>添加产品 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>

<body>

    <div class="demoTable" style="margin: 20px">
        套餐名称：
        <div class="layui-inline">
          <input class="layui-input" name="id" id="demoReload" autocomplete="off">
        </div>

        &nbsp; &nbsp;  &nbsp; &nbsp;     <button class="layui-btn" id="admin-management" data-type="reload">选择产品</button>
      </div>





    <table class="layui-hide" id="LAY_table" lay-filter="group"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
      </script>

      <div class="layui-row" id="popUpdateTest" style="display:none;">
        
        <script type="text/html" id="toolbarDemo">
            <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckData">确定选择</button></div>
          </script>
        <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>

     
    </div>

    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
        var layedit;
        layui.use(['table', 'layer','laydate', 'upload','jquery', 'form'], function () {
         
            var table = layui.table;
            var laydate = layui.laydate;
            var $ = layui.jquery;
            var form = layui.form;
            upload = layui.upload;
           


            $(document).on('click', '#admin-management', function () {
                layer.open({
                    //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                    type: 1,
                    title: "选择产品",
                    area: ['800px', '580px'],
                    content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                  });

                  table.render({
                    url: "goods" //数据接口
                        ,
                    toolbar: '#toolbarDemo',
                    page: true //开启分页
                        ,
                    elem: '#LAY_table_user',
                    cols: [
                        [
                            {type:'checkbox'},
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
                    ],
                    parseData: function (res) { //res 即为原始返回的数据
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
    
            });

            table.on('toolbar(user)', function(obj){
               
                var checkStatus = table.checkStatus(obj.config.id);
                switch(obj.event){
                case 'getCheckData':
                    var data = checkStatus.data;
                   // layer.alert(JSON.stringify(data));
                break;
                };
                layer.closeAll(); 
                table.render({
                    page: true //开启分页
                        ,
                    elem: '#LAY_table',
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
                          
                            },{
                                fixed: 'right',
                                title: "操作",
                                align: 'center',
                                toolbar: '#barDemo'
                            }
                        ]
                    ],
                    data:data,
                    skin: 'line' //表格风格
                    ,even: true
                    ,page: true //是否显示分页
                  ,limit: 10 //每页默认显示的数量
    
                });
    
            });

            //监听提交
            form.on('submit(create)', function (data) {
                //console.log(data.field);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "goods",
                    method: 'POST',
                    data: data.field,
                    dataType: 'json',
                    success: function (res) {
                        console.log(res); return false;
                        if (res.status == 200) {
                            layer.msg('创建成功', {
                                offset: '15px',
                                icon: 1,
                                time: 1000
                            }, function () {
                                $(".layui-laypage-btn").click();
                                window.location.href = "";
                                layer.closeAll();
                             
                  
                            })
                        } else if (res.status == 403) {
                            layer.msg('填写错误或重复', {
                                offset: '15px',
                                icon: 2,
                                time: 3000
                            }, function () {
                                location.href = 'created';
                            })
                        }
                    }
                });
                return false;
            });

           

            table.on('tool(group)', function (obj) {
                var data = obj.data;
               // console.log(data);return false;
                if (obj.event === 'del') {

                    layer.confirm('真的删除么', function (index) {
                        obj.del();
                        //关闭弹框
                        layer.msg("删除成功", {
                            icon: 6
                        });
                        return false;
                    });
                } 

            });



        })

    </script>
</body>

</html>
