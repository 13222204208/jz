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
    <div class="layui-row" id="popUpdateTask" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"  style="margin:20px">
    
         <div class="layui-form-item">
            <label class="layui-form-label">项目名称</label>
            <div class="layui-input-block">
              <input type="text" name="order_name" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">项目名称</label>
            <div class="layui-input-block">
              <input type="text" name="owner_name" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>

          <div class="layui-form-item">
            <label class="layui-form-label">业主手机号</label>
            <div class="layui-input-block">
              <input type="number" name="owner_phone" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
    
          <div class="layui-form-item">
            <label class="layui-form-label">业主地址</label>
            <div class="layui-input-block">
              <input type="text" name="owner_address" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">负责人</label>
            <div class="layui-input-block">
              <input type="text" name="functionary"   autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">负责人手机号</label>
            <div class="layui-input-block">
              <input type="number" name="functionary_phone"  autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">业主需求</label>
            <div class="layui-input-block">
              <input type="text" name="owner_demand"   autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button type="submit" class="layui-btn" lay-submit="" lay-filter="editOrder">立即提交</button>
              <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
          </div>

        </form>
      </div>
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
        <a class="layui-btn  layui-btn-xs" lay-event="update">编辑</a>
        <a class="layui-btn  layui-btn-xs" lay-event="edit">分配工程师</a>
        <a class="layui-btn  layui-btn-xs" lay-event="showGoods">查看产品</a> 
        <a class="layui-btn  layui-btn-xs" lay-event="show">查看进度</a> 
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> 
    </script>
    <script type="text/html" id="listbarDemo">
        <div class="layui-btn-container">
        
        </div>
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
                url: "build" //数据接口
                    ,
                page: true //开启分页
                    ,
                elem: '#LAY_table_user',
                toolbar: '#listbarDemo',
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
                            field: 'order_name',
                            title: '订单名称',
                            width:150
                      
                        },{
                            field: 'created_at',
                            title: '创建时间',
                            width:150
                      
                        },{
                            fixed: 'right',
                            title: "操作",
                            width: 370,
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
                 function setFormValue(obj, data) {
        
                    form.on('submit(editOrder)', function(data){
                       message = data.field;
                       //console.log(obj.data.id); return false;
                       $.ajax({
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           url: "updateOrder/"+obj.data.id,
                           method: 'post',
                           data: message,
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
                                           owner_name: message.owner_name,
                                           owner_phone: message.owner_phone,
                                           owner_address: message.owner_address,
                                           functionary: message.functionary,
                                           functionary_phone: message.functionary_phone,
                                           owner_demand: message.owner_demand,
                                           order_name: message.order_name,
                                       });  
   
   
                                       layer.closeAll(); //关闭所有的弹出层
                                       //window.location.href = "/edit/horse-info";
   
                                   }, 1000);
   
                               } else {
                                   layer.msg("修改失败", {
                                       icon: 5
                                   });
                               }
                           }
                       });
                       return false;
                     });
               }

                 if(obj.event === 'update'){
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "编辑订单",
                        area: ['620px', '450px'],
                        content: $("#popUpdateTask") //引用的弹出层的页面层的方式加载修改界面表单
                      });
                      form.val("formUpdate", data);
                      setFormValue(obj, data);
                }else if (obj.event === 'show') {

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
                        url: "build",
                        type: 'post',
                        data:{
                            order_num:data.order_num
                        },
                        success: function (msg) {
                            data = msg.data; 
                            if (msg.status == 200) {
                                url = window.location.protocol+"//"+window.location.host+"/";
                                if(data.before != null){
                                    str = data.before.photo;
                                    var strs= new Array(); //定义一数组
                                    strs=str.split(","); //字符分割
                                    photo = '';
                                    for (i=0;i<strs.length ;i++ ){
                                        photo +='<img width="500px" src="'+ url+strs[i] + '" >';
                                    }
                                    
                                    time = '施工前 '+data.before.created_at;
                                    photo = data.before.comments+'<br>'+photo;
                                 
                                }else{
                                    time = '还没有施工图片';
                                    photo = '';
                                }
                                
                                under= '';
                                if(data.under.length == 0){
                                    under = '';
                                }else{
                                    uphoto = '';
                                    for(i=0; i<data.under.length; i++){
                                        utime = '施工中 '+ data.under[i].created_at;

                                        str = data.under[i].photo;
                                        var strs= new Array(); //定义一数组
                                        strs=str.split(","); //字符分割
                                      
                                        for (j=0;j<strs.length ;j++ ){
                                           uphoto += '<img width="500px" src="'+ url+strs[j] + '" >';
                                        }
                                        //console.log(data.under[i].comments); return false;
                              
                                        
                                       //console.log(uphoto); return false;
                                        under +=      '<li class="layui-timeline-item">'+
                                            '<i class="layui-icon layui-timeline-axis"></i>'+
                                            '<div class="layui-timeline-content layui-text">'+
                                              '<h3 class="layui-timeline-title">'+utime+'</h3>'+
                                            '  <p>'+ data.under[i].comments +'<br>'+uphoto+
                                             
                                              '</p>'+
                                           ' </div>'+
                                          '</li>';
                                          uphoto = '';
                                    }
                                }

                                finish = '';
                                if(data.finish != null){
                                    ftime = '施工完成 '+data.finish.created_at;
                                    str = data.finish.photo;
                                    var strs= new Array(); //定义一数组
                                    strs=str.split(","); //字符分割
                                    photo = '';
                                    for (i=0;i<strs.length ;i++ ){
                                        photo +='<img width="500px" src="'+ url+strs[i] + '" >';
                                    }
                                  
                                    fphoto =data.finish.comments +'<br> '+photo;

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
                                    str = data.done.owner_sign_photo;
                                    var strs= new Array(); //定义一数组
                                    strs=str.split(","); //字符分割
                                    photo = '';
                                    for (i=0;i<strs.length ;i++ ){
                                        photo +='<img width="500px" src="'+ url+strs[i] + '" >';
                                    }
                                    owner_sign_photo ='业主签字<br>'+photo;

                                    str = data.done.engineer_sign_photo;
                                    var strs= new Array(); //定义一数组
                                    strs=str.split(","); //字符分割
                                    photo = '';
                                    for (i=0;i<strs.length ;i++ ){
                                        photo +='<img width="500px" src="'+ url+strs[i] + '" >';
                                    }

                                    engineer_sign_photo ='工程师签字<br>'+ photo;
                                 
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
                        url: "build/3" //数据接口
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
                        url: "build/"+dataId,
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

                    layer.confirm('真的删除此订单么', function (index) {
                        $.ajax({
                            url: "build/"+data.id,
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
