<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>添加案例或资讯 </title>
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
               
                  <select name="type" lay-filter="cate_demo" lay-verify="required" >
                    <option value="">选择类型</option>
                    <option value="case">案例</option>
                    <option value="info">资讯</option>
                  </select>
              </div>

            <div class="layui-form-item">
               
                    <input type="text" name="title" lay-verify="required"  autocomplete="off"
                        placeholder="标题" value="" class="layui-input">
               
            </div>

            <div class="layui-form-item" id="tags" style="display: none">
                <label class="layui-form-label"><b>标签选择：</b></label>
              <div class="layui-input-block" id="roleScope" >
        
        
              </div>
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
                <input type="hidden" name="photo"  lay-verify="required"  class="upload_image_url" >

                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="test2">详情图片上传</button> 
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                    预览图：
                    <div class="layui-upload-list" id="demo2"></div>
                </blockquote>
                </div>
            </div>
            

            <div class="layui-form-item">   
              <textarea class="layui-textarea" name="content"  lay-verify="content"   id="LAY_demo1" style="display: none">  
                详情介绍
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


              //多图片上传
            upload.render({
                elem: '#test2'
                ,headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                ,url: 'upload/imgs' //改成您自己的上传接口
                ,size:3000
                ,multiple: true
            /*    ,before: function(obj){
                obj.preview(function(index, file, result){
                    $('#demo2').append('<img src="'+ result +'" style="width:150px" alt="'+ file.name +'" class="layui-upload-img">')
                });
                } */
                ,done: function(res){
                    console.log(res); 
                    if (res.code == 0) { 

                        var fileurl = res.data.src;;
					//原内容
					var old_url = $(".upload_image_url").val();
					//判断是否有原内容
					if(old_url.length>0){
			   			$(".upload_image_url").val( old_url + "," + fileurl);
			   		}else{
			   			$(".upload_image_url").val(fileurl);
			   		}
                    $("#demo2").empty();
                    url = window.location.protocol+"//"+window.location.host+"/";
					//获取input中存入的地址
					var type_pic_url = $(".upload_image_url").val();
			   		var strs = new Array();
			   		strs = type_pic_url.split(",");
					//图片回显
			   		var html = "";
			   		for(var i=0;i<strs.length;i++){
			   			html += "<div style='float:left;margin-right:10px;'><img alt='图片不存在' class='layui-upload-img'  height='100' src='"+url+strs[i]+"'><span style='color:blue' onclick=delFile(this,'"+strs[i]+"')>删除</span></div>";
			   		}
                       $("#demo2").html(html);

                       delFile= function(obj,file){
                        //obj为当前对象，file为该文件路径
                       
                        $(obj).siblings().remove();
                        $(obj).remove();
                        //获取全部文件路径
                        var files = $(".upload_image_url").val();
                        //分割
                        var fileArray = files.split(",");
                        //得到要删除文件路径在全部文件路径中的定位
                        var index = fileArray.indexOf(file);
                        if (index > -1) {
                            //分割字符串
                            fileArray.splice(index, 1);
                        }
                        
                        $(".upload_image_url").val(fileArray);
                     
                    }
                       
                     /*   var last_url = $(".upload_image_url").val();
                        var upload_image_url = "";
                        if(last_url){
                            upload_image_url = last_url+","+res.data.src;
                        }else {
                            upload_image_url = res.data.src;
                        }
                        $(".upload_image_url").val(upload_image_url); */
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

          function getChecked_list(data) {
            var id = "";
            var name ="";
            $.each(data, function (index, item) {
                if (id != "") {
                    id = id + "," + item.id;
                      name = name + "," + item.name;
                    
                  
                }
                else {
                    id = item.id;
                        name = item.name;
                    
                }
                var i = getChecked_list(item.children);
                if (i != "") {
                    id = id + "," + i;
                    name = name + "," + i;
                }
            });
            return id;
        }
   
            //监听提交
            form.on('submit(create)', function (data) {

                console.log(data);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "caseinfo",
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
                                window.location.href = "case-info-list";
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
