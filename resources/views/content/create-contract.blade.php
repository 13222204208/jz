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


    <div class="layui-row" id="layuiadmin-form-admin" >
        <form class="layui-form layui-from-pane" required lay-verify="required" style="margin:20px">

 

            <div class="layui-form-item">
               
                    <input type="text" name="title" lay-verify="required"  autocomplete="off"
                        placeholder="合同名称" value="" class="layui-input">
               
            </div>

  
           
            <div class="layui-form-item">
            <input type="hidden" name="cover" lay-verify="required"  class="image" >
              <div class="layui-upload" >
              <button type="button" class="layui-btn" id="test-upload-normal">封面图片上传</button>
                        <div class="layui-upload-list">
                          <img class="layui-upload-img" src="" id="test-upload-normal-img" style="width:150px" alt="图片预览">
                        </div>
                </div>   
           </div>

           <div class="layui-form-item">
            <input type="hidden" name="file_name" lay-verify="required"  class="image" >
              <div class="layui-upload" >
                <button type="button" class="layui-btn" id="test3"><i class="layui-icon"></i>上传文件</button>
                </div>   
           </div>

{{--             <div class="layui-form-item">
               
            <input type="number" name="quantity" lay-verify="required"  autocomplete="off"
                placeholder="合同套数" value="" class="layui-input">
       
          </div>  --}}

          <div class="layui-form-item">
               
            <input type="number" name="cost" lay-verify="required"  autocomplete="off"
                placeholder="合同价值" value="" class="layui-input">
       
          </div>

          <div class="layui-form-item"> 
            <div class="layui-inline">
              <label class="layui-form-label">开始时间：</label>
              <div class="layui-input-inline">
      
                <input type="text" name="start_time" class="layui-input" lay-verify="required"  id="startTime" placeholder="yyyy-MM-dd HH:mm:ss">
              </div>
      
            </div>
      
            <div class="layui-inline">
              <label class="layui-form-label">结束时间：</label>
              <div class="layui-input-inline">
                <input type="text" class="layui-input" name="stop_time" lay-verify="required" id="stopTime" placeholder="yyyy-MM-dd HH:mm:ss">
              </div>
      
            </div>
          </div>


            <div class="layui-form-item">   
              <textarea  placeholder="合同备注" class="layui-textarea" name="comments" >合同备注  
              </textarea>
            </div>  

              <br>      

            <div class="layui-form-item ">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="create">保存</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
    
        layui.use(['table', 'layer','laydate', 'upload','jquery', 'form','layedit'], function () {
          
             layedit = layui.layedit;
            var table = layui.table;
            var laydate = layui.laydate;
            var $ = layui.jquery;
            var form = layui.form;
            upload = layui.upload;

            laydate.render({
              elem: '#startTime',
              type: 'datetime',
            });
            //日期时间范围
            laydate.render({
              elem: '#stopTime',
              type: 'datetime',
             
            });
      

            form.on('select(cate_demo)', function(data){
                if(data.value == 'case'){
                    $('#tags').show();
                }
            });
                        //获取角色名称
                        $.ajax({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "caseinfo/1",
                            method: 'get',
                            dataType: 'json',
                            success: function(res) {
                        
                              status = res.status;
                               role_name = res.data; //console.log( role_name[0].name); return false
                              if (res.status == 200) {
                                optionData = "";
                                  for (var i = 0; i < role_name.length; i++) {
                                  var t = role_name[i];
                                  optionData += '<input class="education2" type="checkbox" name="tag[]" lay-skin="primary" title="' + t.name + '" value="' + t.id+ '">';
                                }
                    
                                  console.log(optionData);
                                  $("#roleScope").html(optionData);
                                  form.render(); 
                    
                                }else if (res.status == 403) {
                                layer.msg('填写错误或角色名重复', {
                                  offset: '15px',
                                  icon: 2,
                                  time: 3000
                                }, function() {
                                  location.href = 'power';
                                })
                              }
                            }
                          });
            
            layedit.set({
                uploadImage: {
                 
                 url: 'caseinfo/img' //接口url
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


              //指定允许上传的文件类型
            upload.render({
              elem: '#test3',
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
              ,url: 'file' //改成您自己的上传接口
              ,accept: 'file' //普通文件
              ,size:10240
              ,done: function(res){
                console.log(res);
                if (res.code == 0) { 
                  var file_url=res.data.src;
                  $(" input[ name='file_name' ] ").val(file_url);
                  return layer.msg('文件上传成功',{
                      offset: '15px',
                      icon: 1,
                      time: 2000
                    });            
                }
              }
            });




   
            //监听提交
            form.on('submit(create)', function (data) {

                console.log(data);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "contract",
                    method: 'POST',
                    data: data.field,
                    dataType: 'json',
                    success: function (res) {
                       console.log(res);
                        if (res.status == 200) {
                            layer.msg('创建成功', {
                                offset: '15px',
                                icon: 1,
                                time: 1000
                            }, function () {
                                $(".layui-laypage-btn").click();
                                window.location.href = "contract-list";
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
