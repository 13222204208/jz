<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>积分兑换 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
    <br>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">订单号：</label>
                <div class="layui-input-inline">
                    <input class="layui-input" name="order_num" id="demoReload" autocomplete="off">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" lay-submit="" lay-filter="create">查询</button>
                </div>
            </div>
        </div>

    </form>

    <div class="layui-row" id="orderRate" style="display:none;">
        工程进度
    </div>
    <div class="layui-row" id="orderGoods" style="display:none;">
        
    </div>



    <div class="layui-row" id="merchantUpdateTest" style="display:none;">
       
</div>

    <div class="layui-row" id="popUpdateTask" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"  style="margin:20px">
    
          
            <div class="layui-form-item">
                <input type="hidden" name="voucher" lay-verify="required"  class="image" >
                  <div class="layui-upload" >
                  <button type="button" class="layui-btn" id="test-upload-normal">凭证上传</button>
                            <div class="layui-upload-list">
                              <img class="layui-upload-img" src="" id="test-upload-normal-img" style="width:300px" alt="图片预览">
                            </div>
                    </div>   
               </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button type="submit" class="layui-btn" lay-submit="" lay-filter="editExchange">立即提交</button>
              <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
          </div>

        </form>
      </div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn  layui-btn-xs" lay-event="adopt">审批通过</a>
        <a class="layui-btn  layui-btn-xs" lay-event="lookProof">查看凭证</a>

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
             form = layui.form;
            upload = layui.upload;
            layedit = layui.layedit;

                                          //产品封面图片上传
      var uploadInst = upload.render({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        elem: '#test-upload-normal',
        accept:'images',
        size:3000,
        url: 'upload/imgs',
        before: function(obj) {      
          //预读本地文件示例，不支持ie8
          obj.preview(function(index, file, result) {
            $('#test-upload-normal-img').attr('src', result); //图片链接（base64）
          });
        },
        done: function(res) {
          if (res.code == 0) { 
            var img_url=res.data.src;
            $(" input[ name='voucher' ] ").val(img_url);
            return layer.msg('图片上传成功',{
                offset: '15px',
                icon: 1,
                time: 2000
              });            
          }
          //如果上传失败
          if (res.code == 403) {
            return layer.msg('上传失败',{
                offset: '15px',
                icon: 2,
                time: 2000
              });
          }
          //上传成功
        },
        error: function(error) {
          console.log(error);
          //演示失败状态，并实现重传
          var demoText = $('#test-upload-demoText');
          demoText.html('<span style="color: #FF5722;">图片上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
          demoText.find('.demo-reload').on('click', function() {
            uploadInst.upload();
          });
        }
      });
              
            form.on('submit(create)', function (data) {
                console.log(data.field);
                table.render({
                    url: "exchange/"+data.field.order_num //数据接口
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
                                field: 'order_num',
                                title: '订单号',
                              
                          
                            },{
                                field: 'integral',
                                title: '兑换积分',
                             
                          
                            },
                            {
                                field: 'nick_name',
                                title: '提交商家',
                                width:150,
                                templet: function(d) {
                                    return d.nick_name.nickname;
                                   
                                  },
                          
                            },
                            {
                                field: 'examine',
                                title: '审批帐号',
                           
                          
                            },
                            {
                                field: 'status',
                                title: '状态',
                                templet: function(d) {
                                    if(d.status ==1){
                                      return '未审批';
                                    }else if(d.status ==2){
                                      return '审批通过';
                                    }else if(d.status ==3){
                                        return '拒绝';
                                    }
                                   
                                  },
                                width:100
                          
                            },{
                                field: 'examine_time',
                                title: '审批时间',
                         
                          
                            },{
                                field: 'created_at',
                                title: '提交时间',
                       
                          
                            }, {
                                fixed: 'right',
                                title: "操作",
                                width: 250,
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
    
                   
         
                 return false;
             });

            table.render({
                url: "exchange" //数据接口
                    ,
                page: true //开启分页
                    ,
                toolbar: '#listbarDemo',
                elem: '#LAY_table_user',
                cols: [
                    [

                        {
                            field: 'id',
                            title: 'ID',
                            width: 80,
                            sort: true
                        }, {
                            field: 'order_num',
                            title: '订单号',
                          
                      
                        },{
                            field: 'integral',
                            title: '兑换积分',
                         
                      
                        },
                        {
                            field: 'nick_name',
                            title: '提交商家',
                            width:150,
                            templet: function(d) {
                                return d.nick_name.nickname;
                               
                              },
                      
                        },
                        {
                            field: 'examine',
                            title: '审批帐号',
                       
                      
                        },
                        {
                            field: 'status',
                            title: '状态',
                            templet: function(d) {
                                if(d.status ==1){
                                  return '未审批';
                                }else if(d.status ==2){
                                  return '审批通过';
                                }else if(d.status ==3){
                                    return '拒绝';
                                }
                               
                              },
                            width:100
                      
                        },{
                            field: 'examine_time',
                            title: '审批时间',
                     
                      
                        },{
                            field: 'created_at',
                            title: '提交时间',
                   
                      
                        }, {
                            fixed: 'right',
                            title: "操作",
                            width: 250,
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
                 if(obj.event ==='adopt'){
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "上传凭证",
                        area: ['620px', '450px'],
                        content: $("#popUpdateTask") //引用的弹出层的页面层的方式加载修改界面表单
                      });
                      form.on('submit(editExchange)', function(data){
                        message = data.field;
                        console.log(message); 
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "exchange/"+obj.data.id,
                            method: 'patch',
                            data: message,
                            success: function (msg) {
                                console.log(msg);
                                if (msg.code == 1) {
                                    layer.closeAll('loading');
                                    layer.load(2);
                                    layer.msg("修改成功", {
                                        icon: 6
                                    });
                                    setTimeout(function () {
                                     layer.closeAll(); //关闭所有的弹出层
                                        //window.location.href = "/edit/horse-info";
    
                                    }, 1000);
                                    $(".layui-laypage-btn").click();
    
                                } else {
                                    layer.msg("修改失败", {
                                        icon: 5
                                    });
                                }
                            }
                        });
                        return false;
                      });
                    return false;
                 }else if(obj.event === 'lookProof'){
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "凭证",
                        area: ['500px', '450px'],
                        content: $("#merchantUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });

                    url = window.location.protocol+"//"+window.location.host+"/";
                    photo ='<img width="500px" src="'+ url+data.voucher + '" >';
                    if(data.voucher == null){
                        photo = "未审批";
                    }
                    $('#merchantUpdateTest').html(photo)
                 }else if (obj.event === 'show') {

                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "施工进度",
                        area: ['700px', '450px'],
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

  /**                  if(data.engineer_id != 0){
                        layer.confirm('确定要重新分配吗', function (index) {
                            layer.open({
                                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                                type: 1,
                                title: "分配订单给安装人员",
                                area: ['700px', '450px'],
                                content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                            });
                            layer.close(index);  
                            return false;
                        });
                    }else{ */
                        layer.open({
                            //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                            type: 1,
                            title: "分配订单给安装人员",
                            area: ['700px', '450px'],
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
                        area: ['700px', '450px'],
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
                                       // img = url + data[i]['cover'];
                                        goods= data[i]['title']; 
                                        price = data[i]['price'];
                                        under += '<div class="ayui-col-xs3" style="margin:10px">'+
                                          
                                          // ' <img src=" '+ img+ '" width="215px">'+
                                         
                                             '  <p class="info">产品名称：'+goods+'</p>'+
                                       
                                                '<b> 产品价格：'+price+' 元</b>'+               
                                    
                                        '</div> ';
                                    }
                            

     
                         
                             

                                $('#orderGoods').html(under);
                                return false;
                            } 
                        }
                    });


                }else if (obj.event === 'relevance') {

 /**                   if(data.merchant_id != 0){
                        layer.confirm('确定要重新分配吗', function (index) {
                            layer.open({
                                //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                                type: 1,
                                title: "关联商家",
                                area: ['700px', '450px'],
                                content: $("#merchantUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                            });
                            layer.close(index);  
                            return false;
                        });
                    }else{ */
                        layer.open({
                            //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                            type: 1,
                            title: "关联合同",
                            area: ['700px', '450px'],
                            content: $("#merchantUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                        });
                

                    table.render({
                        url: "merchant" //数据接口
                            ,
                        toolbar: '#toolbarDemo_merchant',
                        page: true, //开启分页
                            
                        elem: '#LAY_table_merchant',
                        cols: [
                            [
                                {type:'checkbox'},
                                {
                                    field: 'id',
                                    title: 'ID',
                                    width: 60,
                                    sort: true
                                }, {
                                    field: 'title',
                                    title: '合同名称',
                                    width:100
                                }, {
                                    field: 'partner',
                                    title: '合作方全称',
                                    width:150
                                },{
                                    field: 'cost',
                                    title: '合同标的',
                                    width:100
                                },{
                                    field: 'quantity',
                                    title: '合同套数',
                                    width:90
                              
                                },{
                                    field: 'merchant_name',
                                    title: '商家昵称',
                                    width:90
                              
                                },{
                                    field: 'merchant_phone',
                                    title: '商家手机号',
                                    width:130
                              
                                },{
                                    field: 'contract_package',
                                    title: '剩余套餐详情',
                                    width:250,
                                    templet: function(d) {
                                        info ='';
                                        console.log(d.contract_package);
                                        for(var i=0; i<d.contract_package.length; i++){
                                     
                                            info += ' '+d.contract_package[i]['goods_package'].title+':'+d.contract_package[i]['goods_package_qty']+'套';
                                        }
                                        return info;
                                      },
                              
                                },{
                                    field: 'done_quantity',
                                    title: '已完成套数',
                                    width:100,
                              
                                },{
                                    field: 'start_time',
                                    title: '合同开始时间',
                                    width:180
                              
                                }, {
                                    field: 'stop_time',
                                    title: '合同结束时间',
                                    width:180
                              
                                }, {
                                    field: 'comments',
                                    title: '合同备注',
                                    width:200
                                },{
                                    field: 'created_at',
                                    title: '创建时间',
                              
                              
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
                        table.on('toolbar(userMerchant)', function(obj){
                            var checkStatus = table.checkStatus(obj.config.id);
                        
                            switch(obj.event){
                            case 'getCheckMerchantData':
                                var data = checkStatus.data;
                               // layer.alert(JSON.stringify(data));
                            break;
                            };
    
                            if(data.length >1 ){
                                layer.msg("只能选择一个合同", {
                                    icon: 5
                                });
                                return false;
                            }
            
                            id = data[0]['id'];

                            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "relevance/"+dataId,
                        type: 'patch',
                        data: {order_id:id},
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
