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

    <div class="demoTable" style="margin:5px;">
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
            <input type="number" name="number"  autocomplete="off"
                placeholder="库存" value="" class="layui-input">
        </div>

                    
        <div class="layui-form-item">
            <input type="number" name="price" lay-verify="required"  autocomplete="off"
                placeholder="单价" value="" class="layui-input">
        </div>

        <div class="layui-form-item">
            <input type="number" name="package_price"  autocomplete="off"
                placeholder="套餐单价" value="" class="layui-input">
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
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
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
                            width:200
                        },{
                            field: 'description',
                            title: '产品描述',
                            width:250
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
                      
                        },{
                            field: 'created_at',
                            title: '创建时间',
                            width:180
                      
                        },  {
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
                    //location.href="details/"+data.id;
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "编辑产品",
                        area: ['700px', '450px'],
                        content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                   
                    url = window.location.protocol+"//"+window.location.host+"/";
                    str = data.photo;
                    $('#test-upload-normal-img').attr('src', url+data.cover); 
                    var arr= str.split(",");
                   
                    photo ="";
                    for (var i=0;i<arr.length;i++) {
                      
                        photo += "<div style='float:left;margin-right:10px;'><img alt='图片不存在' class='layui-upload-img'  height='100' src='"+url+arr[i]+"'><span style='color:blue' onclick=delFile(this,'"+arr[i]+"')>删除</span></div>";    
                    }
                    console.log(photo); //return photo;
                    $("#uploader-list").html(photo);

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

                        $(".upload_image_url").val(fileArray.toString());
                       // data['photo'] = fileArray.toString();
                    }

                    index= layedit.build('LAY_demo1');
                    layedit.setContent(index, data.content);
                   
              
                  
                    form.val("formUpdate", data);
                    setFormValue(obj, data);
                }

            });

            layedit.set({
                uploadImage: {
                 
                 url: 'content/img' //接口url
                  ,type: 'post' //默认post
                }
              });

            function setFormValue(obj, data) {
                form.on('submit(editAccount)', function (massage) {
                    
                    massage = massage.field;
                    layedit.sync(index);
                    content= $('#LAY_demo1').val();
                    massage['content'] = content;


                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "goods/"+data.id,
                        type: 'patch',
                        data: massage,
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
                                        title: massage.title,
                                        description: massage.description,
                                        number: massage.number,
                                        price: massage.price,
                                        package_price: massage.package_price
                                    }); //修改成功修改表格数据不进行跳转 


                                    layer.closeAll(); //关闭所有的弹出层
                                    //window.location.href = "/edit/horse-info";

                                }, 1000);
                                window.location.reload();
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
