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

<style type="text/css">
    .uploader-list {
     margin-left: -15px;
    }
   
    .uploader-list .info {
     position: relative;
     margin-top: -25px;
     background-color: black;
     color: white;
     filter: alpha(Opacity=80);
     -moz-opacity: 0.5;
     opacity: 0.5;
     width: 100px;
     height: 25px;
     text-align: center;
     display: none;
    }
   
    .uploader-list .handle {
     position: relative;
     background-color: black;
     color: white;
     filter: alpha(Opacity=80);
     -moz-opacity: 0.5;
     opacity: 0.5;
     width: 100px;
     text-align: right;
     height: 18px;
     margin-bottom: -18px;
     display: none;
    }
   
    .uploader-list .handle span {
     margin-right: 5px;
    }
   
    .uploader-list .handle span:hover {
     cursor: pointer;
    }
   
    .uploader-list .file-iteme {
     margin: 12px 0 0 15px;
     padding: 1px;
     float: left;
    }
   </style>
<body>

    <div class="demoTable" style="margin:30px;">
        <button class="layui-btn" data-type="reload" value="0" id="admin-management">添加产品</button>
        <div class="layui-inline" style="color:gray" id="lp_address">
        </div>
    </div>



    <div class="layui-row" id="popUpdateTest" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"
            style="margin:20px">

            <div class="layui-form-item">
               
                <input type="text" name="title" lay-verify="required"  autocomplete="off"
                    placeholder="产品名称" value="" class="layui-input">
           
        </div>

        <div class="layui-form-item">
            <input type="text" name="description" lay-verify="required"  autocomplete="off"
                placeholder="产品描述" value="" class="layui-input">
        </div>

       
        <div class="layui-form-item">
        <input type="hidden" name="cover" lay-verify="required"  class="image" >
          <div class="layui-upload" >
          <button type="button" class="layui-btn" id="test-upload-normal">产品封面图片上传</button>
                    <div class="layui-upload-list">
                      <img class="layui-upload-img" src="" id="test-upload-normal-img" style="width:150px" alt="图片预览">
                    </div>
            </div>   
       </div>

        <div class="layui-form-item">
            <input type="hidden" name="photo"  lay-verify="required"  class="upload_image_url" >

            <div class="layui-upload">
                <button type="button" class="layui-btn" id="test2">产品轮播图片上传</button> 
                <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                预览图：
               <div class="layui-upload-list" id="uploader-list"></div> 

            </blockquote>
            </div>
        </div>
        
        <div class="layui-form-item">
            <input type="number" name="number" lay-verify="required"  autocomplete="off"
                placeholder="库存" value="" class="layui-input">
        </div>

                    
        <div class="layui-form-item">
            <input type="number" name="price" lay-verify="required"  autocomplete="off"
                placeholder="单价" value="" class="layui-input">
        </div>

        <div class="layui-form-item">   
          <textarea class="layui-textarea" name="content"  lay-verify="required"   id="LAY_demo1" style="display: none">  
            产品详情介绍
          </textarea>
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
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit">编辑</a>
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
            upload = layui.upload;
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
                    '<div id="" class="file-iteme">' +
                    '<div class="handle"><i class="layui-icon layui-icon-delete"></i></div>' +
                    '<img style="width: 100px;height: 100px;" class="layui-upload-img" src='+ result +'>' +
                    '<div class="info">' + '</div>' +
                    '</div>'
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
                location.href='create';
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
                      
                        },{
                            field: 'package_price',
                            title: '套餐单价',
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
                    $(".layui-laypage-btn").click();
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "编辑产品",
                        area: ['600px', '600px'],
                        content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                    
                    url = "http://jz.com/";
                    str = data.photo;
                    var arr= str.split(",");
                   
                    for (var i=0;i<arr.length;i++) {
                        $('#uploader-list').append(
                            '<div id="" class="file-iteme">' +
                            '<div class="handle"><i class="layui-icon layui-icon-delete"></i></div>' +
                            '<img style="width: 150px;height: 150px;" class="layui-upload-img" src='+ url+arr[i] +'>' +
                            '<div class="info">'  + '</div>' +
                            '</div>'
                        );
                    }
                

                    $(document).on("mouseenter mouseleave", ".file-iteme", function(event){
                        if(event.type === "mouseenter"){
                         //鼠标悬浮
                         $(this).children(".info").fadeIn("fast");
                         $(this).children(".handle").fadeIn("fast");
                        }else if(event.type === "mouseleave") {
                         //鼠标离开
                         $(this).children(".info").hide();
                         $(this).children(".handle").hide();
                        }
                       });
        
                         // 删除图片
                        $(document).on("click", ".file-iteme .handle", function(event){
                            $(this).parent().remove(); 
                        });

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