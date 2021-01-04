<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>工程订单 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>
<body>

    <div class="layui-row" id="orderRate" style="display:none;">
        工程进度
    </div>
    <div class="layui-row" id="orderGoods" style="display:none;">
        
    </div>

    <div class="layui-row" id="popUpdateTest" style="display:none;">
            <table class="layui-hide" id="LAY_table" lay-filter="user"></table>
            <script type="text/html" id="toolbarDemo">
                <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckData">确定选择</button></div>
              </script>       
    </div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit">分配工程师</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="showGoods">查看订单产品</a> 
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="show">查看工程进度</a> 
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> 

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
                url: "ownerOrder" //数据接口
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
                            field: 'owner_name',
                            title: '业主名称',
                            width:120
                        },{
                            field: 'owner_phone',
                            title: '业主手机号',
                            width:150
                        },{
                            field: 'owner_address',
                            title: '业主地址',
                            width:150
                      
                        },{
                            field: 'functionary',
                            title: '负责人',
                            width:120
                      
                        },{
                            field: 'functionary_phone',
                            title: '负责人手机号',
                            width:120
                      
                        },
                        {
                            field: 'engineer_name',
                            title: '施工人员名称',
                            width:180
                      
                        },{
                            field: 'engineer_phone',
                            title: '施工人员手机号',
                            width:200
                      
                        },{
                            field: 'agreement_id',
                            title: '合同',
                            width:150
                      
                        },{
                            field: 'owner_demand',
                            title: '业主需求',
                            width:150
                      
                        }, {
                            field: 'status',
                            title: '状态',
                            templet: function(d) {
                                if(d.status ==1){
                                  return '待施工';
                                }else if(d.status ==2){
                                  return '施工中';
                                }else if(d.status ==3){
                                    return '施工完成';
                                }
                               
                              },
                            width:100
                      
                        },{
                            field: 'created_at',
                            title: '下单时间',
                            width:150
                      
                        }, {
                            fixed: 'right',
                            title: "操作",
                            width: 350,
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
                 data = obj.data;//console.log(data.order_num); return false;
             
                if (obj.event === 'show') {

                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "施工进度",
                        area: ['700px', '600px'],
                        content: $("#orderRate") //引用的弹出层的页面层的方式加载修改界面表单
                    });

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "ownerOrder",
                        type: 'post',
                        data:{
                            order_num:data.order_num
                        },
                        success: function (msg) {
                           data = msg.data; 
                            if (msg.status == 200) {
                                if(data.before != null){
                                    time = '施工前 '+data.before.created_at;
                                    photo =data.before.comments +'<br> <img width="500px" src="'+ data.before.photo + '" >';
                                 
                                }else{
                                    time = '还没有施工图片';
                                    photo = '';
                                }
                                
                                under= '';
                                if(data.under.length == 0){
                                    under = '';
                                }else{
                                    for(i=0; i<data.under.length; i++){
                                        utime = '施工中 '+ data.under[i].created_at;
                                        uphoto =data.under[i].comments +'<br> <img width="500px" src="'+ data.under[i].photo + '" >';
                                        under +=      '<li class="layui-timeline-item">'+
                                            '<i class="layui-icon layui-timeline-axis"></i>'+
                                            '<div class="layui-timeline-content layui-text">'+
                                              '<h3 class="layui-timeline-title">'+utime+'</h3>'+
                                            '  <p>'+ uphoto+
                                             
                                              '</p>'+
                                           ' </div>'+
                                          '</li>';
                                    }
                                }

                                finish = '';
                                if(data.finish != null){
                                    ftime = '施工完成 '+data.finish.created_at;
                                    fphoto =data.finish.comments +'<br> <img width="500px" src="'+ data.finish.photo + '" >';

                                    finish +=      '<li class="layui-timeline-item">'+
                                        '<i class="layui-icon layui-timeline-axis"></i>'+
                                        '<div class="layui-timeline-content layui-text">'+
                                          '<h3 class="layui-timeline-title">'+ftime+'</h3>'+
                                        '  <p>'+ fphoto+
                                         
                                          '</p>'+
                                       ' </div>'+
                                      '</li>';
                                }

                                done = ''; 
                                if(data.done != null){
                                    dtime = '签字完成 '+data.done.created_at;
                                    owner_sign_photo ='业主签字' +'<br> <img width="500px" src="'+ data.done.owner_sign_photo + '" >';

                                    engineer_sign_photo ='工程师签字' +'<br> <img width="500px" src="'+ data.done.engineer_sign_photo + '" >';
                                 
                                    done +=      '<li class="layui-timeline-item">'+
                                        '<i class="layui-icon layui-timeline-axis"></i>'+
                                        '<div class="layui-timeline-content layui-text">'+
                                          '<h3 class="layui-timeline-title">'+dtime+'</h3>'+
                                        '  <p>'+ owner_sign_photo+'<br>'+ engineer_sign_photo+
                                         
                                          '</p>'+
                                       ' </div>'+
                                      '</li>';
                                }

                         
                                html= 
                                  '<br><ul class="layui-timeline">'+
                                    '<li class="layui-timeline-item">'+
                                      '<i class="layui-icon layui-timeline-axis"></i>'+
                                      '<div class="layui-timeline-content layui-text">'+
                                        '<h3 class="layui-timeline-title">'+time+'</h3>'+
                                      '  <p>'+ photo+
                                       
                                        '</p>'+
                                     ' </div>'+
                                    '</li>'+under+  finish+done+
                                    
                                  '</ul>'  

                                $('#orderRate').html(html);
                                return false;
                            } 
                        }
                    });


                } else if (obj.event === 'edit') {
                    //location.href="details/"+data.id;
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "分配订单给安装人员",
                        area: ['700px', '600px'],
                        content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });

                    table.render({
                        url: "ownerOrder/3" //数据接口
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
                        url: "ownerOrder/"+dataId,
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

                  
                }else  if (obj.event === 'showGoods') {

                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "订单内产品",
                        area: ['700px', '600px'],
                        content: $("#orderGoods") //引用的弹出层的页面层的方式加载修改界面表单
                    });

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "goods/"+data.id,
                        type: 'get',
     
                        success: function (msg) {
                            console.log(msg); 
                           data = msg.data; 
                            if (msg.status == 200) {
                       
                                url = window.location.protocol+"//"+window.location.host+"/";
                                under ='';
                                    for(i=0; i<data.length; i++){
                                        img = url + data[i]['cover'];
                                        goods= data[i]['title']; 
                                        price = data[i]['price'];
                                        under += '<div class="ayui-col-xs3" style="margin:10px">'+
                                          
                                           ' <img src=" '+ img+ '" width="215px">'+
                                         
                                             '  <p class="info">产品名称：'+goods+'</p>'+
                                       
                                                '<b> 产品价格：'+price+' 元</b>'+               
                                    
                                        '</div> ';
                                    }
                            

     
                         
                             

                                $('#orderGoods').html(under);
                                return false;
                            } 
                        }
                    });


                }else if (obj.event === 'del') {

                    layer.confirm('真的删除此分类么', function (index) {
                        $.ajax({
                            url: "ownerOrder/"+data.id,
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