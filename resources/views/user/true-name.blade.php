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

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="show">查看证件照</a>
     <!--   <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>  -->

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
                url: "truename" //数据接口
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
                            field: 'truename',
                            title: '真实姓名',
                   
                        },{
                            field: 'phone',
                            title: '手机号',
                   
                        }, {
                            field: 'id_number',
                            title: '身份证号',
                   
                        },  {
                            field: 'engineer_status',
                            title: '状态',
                            //width:150,
                            templet: function(d) {
                                console.log(d.engineer_status);
                                if (d.engineer_status == 1) {
                                  return '<div class="layui-input-block">'+
                                    '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                     '" lay-skin="switch" checked '+ 'lay-text="已审核|未审核">'+
                                  '</div>';
                                }else{
                                    return '<div class="layui-input-block">'+
                                        '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                         '" lay-skin="switch" lay-text="已审核|未审核">'+
                                      '</div>';
                                }
                              }
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
                    url: "truename"+'/'+switch_goods_id ,
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


            table.on('tool(user)', function (obj) {
                 data = obj.data;
             
               if(obj.event === 'show'){
                    console.log(data);

                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "用户证件照",
                        area: ['500px', '450px'],
                        content: $("#popPhoto") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                    url = window.location.protocol+"//"+window.location.host+"/";
                    photo = '<img width="300px" src="'+url+data.id_front+'"><br>'+
                            '<img width="300px" src="'+url+data.id_the_back+'"><br>'+
                            '<img width="300px" src="'+url+data.id_in_hand+'">';
                    $("#popPhoto").html(photo);
                } 

            });

        })

    </script>
</body>

</html>
