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


    <div class="layui-row" id="layuiadmin-form-admin" >
        <form class="layui-form layui-from-pane" required lay-verify="required" style="margin:20px">

            <div class="layui-form-item">
               
                    <input type="text" name="title" required lay-verify="type_name" autocomplete="off"
                        placeholder="产品名称" value="" class="layui-input">
               
            </div>

            <div class="layui-form-item">
                <input type="text" name="description" required lay-verify="type_name" autocomplete="off"
                    placeholder="产品描述" value="" class="layui-input">
            </div>

            <div class="layui-form-item">
                <input type="hidden" name="photo" class="upload_image_url" >

                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="test2">产品图片上传</button> 
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                    预览图：
                    <div class="layui-upload-list" id="demo2"></div>
                </blockquote>
                </div>
            </div>
            
            <div class="layui-form-item">
                <input type="number" name="number" required lay-verify="type_name" autocomplete="off"
                    placeholder="库存" value="" class="layui-input">
            </div>

                        
            <div class="layui-form-item">
                <input type="number" name="price" required lay-verify="type_name" autocomplete="off"
                    placeholder="单价" value="" class="layui-input">
            </div>

            <div class="layui-form-item">   
              <textarea class="layui-textarea" name="content"   id="LAY_demo1" style="display: none">  
                产品详情介绍
              </textarea>
            </div>  

              <br>      

            <div class="layui-form-item ">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="create">保存产品</button>
                    </div>
                </div>
            </div>
        </form>
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
    
        layui.use(['table', 'layer','laydate', 'upload','jquery', 'form','layedit'], function () {
          
            var layedit = layui.layedit;
            var table = layui.table;
            var laydate = layui.laydate;
            var $ = layui.jquery;
            var form = layui.form;
            upload = layui.upload;
            
            layedit.set({
                uploadImage: {
                 
                 url: 'content/img' //接口url
                  ,type: 'post' //默认post
                }
              });

            layedit.build('LAY_demo1'); //建立编辑器

         

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
                    $('#demo2').append('<img src="'+ result +'" style="width:150px" alt="'+ file.name +'" class="layui-upload-img">')
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
                       
                        if (res.status == 200) {
                            layer.msg('创建成功', {
                                offset: '15px',
                                icon: 1,
                                time: 1000
                            }, function () {
                                $(".layui-laypage-btn").click();
                                window.location.href = "list";
                                layer.closeAll();
                             
                  
                            })
                        } else if (res.status == 403) {
                            layer.msg('填写错误或重复', {
                                offset: '15px',
                                icon: 2,
                                time: 3000
                            }, function () {
                                location.href = 'create';
                            })
                        }
                    }
                });
                return false;
            });

           



        })

    </script>
</body>

</html>
