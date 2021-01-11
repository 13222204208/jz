<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>报修和售后 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>
<body>

    <div class="layui-row" id="popPhoto" style="display:none;">
     
    </div>

    <div class="layui-row" id="popUpdateTest" style="display:none;">
            <table class="layui-hide" id="LAY_table" lay-filter="user"></table>
            <script type="text/html" id="toolbarDemo">
                <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckData">确定选择</button></div>
              </script>       
    </div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="show">查看故障图片</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit">分配工程师</a>
     <!--   <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> -->

    </script>

    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
     
        layui.use(['table', 'layer','laydate', 'layedit','upload','jquery', 'form'], function () {
          

         
            var table = layui.table;
            var laydate = layui.laydate;
            var $ = layui.jquery;
            var form = layui.form;
            upload = layui.upload;
            layedit = layui.layedit;
              

            table.render({
                url: "after" //数据接口
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
                            field: 'goods_name',
                            title: '产品名称',
                            width:200
                        },{
                            field: 'hitch_content',
                            title: '故障描述',
                            width:250
                        }, {
                            field: 'owner_name',
                            title: '业主名称',
                            width:100
                      
                        }, {
                            field: 'owner_phone',
                            title: '业主联系方式',
                            width:200
                      
                        },{
                            field: 'engineer',
                            title: '售后工程师',
                            width:300
                      
                        },{
                            field: 'status_value',
                            title: '状态',
                            width:100
                      
                        },{
                            fixed: 'right',
                            title: "操作",
                            width: 200,
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
                 data = obj.data;
             
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
                }else if(obj.event === 'show'){
                    console.log(data);

                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "故障图片",
                        area: ['700px', '600px'],
                        content: $("#popPhoto") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                    url = window.location.protocol+"//"+window.location.host+"/";
                    imgs= data.photo;
                    photo ="";
                    arrayList=  imgs.split(',');
                      console.log(arrayList);
                      arrayList.forEach(function(element) {
                        photo += '<img width="300px" src="'+url+element+'">'
                        
                    });
                    if(data.photo == ''){
                        $("#popPhoto").html('没有上传故障图片');   
                    }else{
                        $("#popPhoto").html(photo);
                    }
                   
                } else if (obj.event === 'edit') {
                    //location.href="details/"+data.id;
                   
                    if(data.engineer_id != 0){
                        layer.confirm('确定要重新分配吗', function (index) {
                            layer.open({
                                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                                type: 1,
                                title: "分配订单给安装人员",
                                area: ['700px', '600px'],
                                content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                            });
                        layer.close(index);  
                         return false;
                        });
                    }else{
                        layer.open({
                            //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                            type: 1,
                            title: "分配订单给安装人员",
                            area: ['700px', '600px'],
                            content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                        });
                    }


                    table.render({
                        url: "after/3" //数据接口
                            ,
                        toolbar: '#toolbarDemo',
                        page: true, //开启分页
                            
                        elem: '#LAY_table',
                        cols: [
                            [
                                {type:'checkbox'},
                                {
                                    field: 'id',
                                    title: 'ID',
                                    width: 80,
                                    sort: true
                                }, {
                                    field: 'truename',
                                    title: '姓名',
                                    width:150
                                },{
                                    field: 'phone',
                                    title: '手机号',
                                    width:150
                                }, {
                                    field: 'id_number',
                                    title: '身份证号',
                              
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
                    dataId = data.id;
                    setFormId(obj,dataId);
                    function setFormId(obj,dataId){
                        table.on('toolbar(user)', function(obj){
                            var checkStatus = table.checkStatus(obj.config.id);
                        
                            switch(obj.event){
                            case 'getCheckData':
                                var data = checkStatus.data;
                               // layer.alert(JSON.stringify(data));
                            break;
                            };
    
                            if(data.length >1 ){
                                layer.msg("只能选择一个人员", {
                                    icon: 5
                                });
                            }
            
                            id = data[0]['id'];

                            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "after/"+dataId,
                        type: 'patch',
                        data: {engineer_id:id},//工程师id
                        success: function (msg) {
                            if (msg.status == 200) {
                                layer.closeAll('loading');
                                layer.load(2);
                                layer.msg("分配成功", {
                                    icon: 6
                                });
                                setTimeout(function () {
                                    window.location.reload()
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

                        });
                        
                    }

           
                }

            });

        })

    </script>
</body>

</html>
