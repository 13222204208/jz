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
                    <div class="layui-upload-list" id="demo2"></div>
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
                <input type="number" name="package_price" lay-verify="required"  autocomplete="off"
                    placeholder="套餐单价" value="" class="layui-input">
            </div>

            <div class="layui-form-item">   
              <textarea class="layui-textarea" name="content"  lay-verify="content"   id="LAY_demo1" style="display: none">  
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

  

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
    
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>

    </script>

    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
    
        layui.use(['table', 'layer','laydate', 'upload','jquery', 'form','layedit'], function () {
          
             layedit = layui.layedit;
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




            index=  layedit.build('LAY_demo1'); //建立编辑器
         
            form.verify({
              content: function(value) { 
                   return layedit.sync(index);
                  }
          });
   
            //监听提交
            form.on('submit(create)', function (data) {
                console.log(data.field);
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
