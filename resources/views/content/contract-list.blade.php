<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>添加合同 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>
<body>

    <div class="demoTable" style="margin:30px;">
        <button class="layui-btn" data-type="reload" value="0" id="admin-management">添加合同</button>
        <div class="layui-inline" style="color:gray" id="lp_address">
        </div>
    </div>


    <div class="layui-row" id="popUpdateTest" style="display:none;">
        <table class="layui-hide" id="LAY_table" lay-filter="user"></table>
        <script type="text/html" id="toolbarDemo">
            <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckData">确定关联</button></div>
          </script>       
</div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="download">下载合同附件</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit">关联商家</a>

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
            $(" input[ name='cover' ] ").val(img_url);
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

              //多图片上传
            upload.render({
                elem: '#test2'
                ,headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                ,url: 'upload/imgs' //改成您自己的上传接口
                ,size:3000
                ,multiple: true
                ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                   // $('#uploader-list').append('<img src="'+ result +'" style="width:150px" alt="'+ file.name +'" class="layui-upload-img">')

                   $('#uploader-list').append(
                    "<div style='float:left;margin-right:10px;'><img alt='图片不存在' class='layui-upload-img'  height='100' src='"+result+"'><span style='color:blue' onclick=delFile(this,'"+result+"')>删除</span></div>"
                );
                });
                }
                ,done: function(res){
                    console.log(res); 
                    if (res.code == 0) { 
                        var last_url = $(".upload_image_url").val();
                        var upload_image_url = "";
                        if(last_url){
                            upload_image_url = last_url+","+res.data.src;
                        }else {
                            upload_image_url = res.data.src;
                        }
                        $(".upload_image_url").val(upload_image_url);
                        return layer.msg('图片上传成功',{
                            offset: '15px',
                            icon: 1,
                            time: 2000
                          });            
                      }
                      //如果上传失败
                      if (res.status == 403) {
                        return layer.msg('上传失败',{
                            offset: '15px',
                            icon: 2,
                            time: 2000
                          });
                      }
                //上传完毕
                }
            });



            $(document).on('click', '#admin-management', function () {
                location.href='create-contract';
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

            table.render({
                url: "contract" //数据接口
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
                            title: '合同名称',
                            width:100
                        },{
                            field: 'comments',
                            title: '合同备注',
                            width:200
                        },{
                            field: 'cost',
                            title: '合同费用',
                            width:150
                        },{
                            field: 'quantity',
                            title: '合同套数',
                            width:150
                      
                        },{
                            field: 'done_quantity',
                            title: '已完成套数',
                   
                      
                        },{
                            field: 'start_time',
                            title: '合同开始时间',
                            width:180
                      
                        }, {
                            field: 'stop_time',
                            title: '合同结束时间',
                            width:180
                      
                        }, {
                            field: 'created_at',
                            title: '创建时间',
                      
                      
                        },  {
                            fixed: 'right',
                            title: "操作",
                            align: 'center',
                            width:200,
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
               
                if (obj.event === 'download') {
                    url = window.location.protocol+"//"+window.location.host+"/";
                    file = url+data.file_name;
                    window.open(file);
                } else if (obj.event === 'edit') {
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "关联商家",
                        area: ['700px', '600px'],
                        content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });

                    table.render({
                        url: "contract/2" //数据接口
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
                                layer.msg("只能选择一个", {
                                    icon: 5
                                });
                            }
            
                            id = data[0]['id'];

                            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "contract/"+dataId,
                        type: 'patch',
                        data: {merchant_id:id},//商家id
                        success: function (msg) {
                            if (msg.status == 200) {
                                layer.closeAll('loading');
                                layer.load(2);
                                layer.msg("关联成功", {
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
