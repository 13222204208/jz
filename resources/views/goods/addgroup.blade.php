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
    <div style="margin: 20px">
          <button class="layui-btn" id="admin-management" data-type="reload">选择产品</button>
    <form class="layui-form layui-from-pane" required lay-verify="required" >
    <div class="demoTable" >
        <br>
        <div class="layui-form-item">
               
            <select name="type" lay-verify="required" >
                <option value="1">普通套餐</option>
                <option value="2">自定义套餐</option>
            </select>
        </div>

        <div class="layui-form-item">
            <input type="text" class="layui-input" placeholder="套餐名称" name="title"  lay-verify="required"  autocomplete="off">
        </div>

        <div class="layui-form-item">
            <input type="number" name="package_price" lay-verify="required"  autocomplete="off"
                placeholder="套餐价" value="" class="layui-input">
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline">
                <input type="number"  name="change" lay-verify="pass" placeholder="转化率 0.15 输入 15" autocomplete="off" value=""  class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">%</div>
        </div>

  
     <input type="hidden" name="goods_id" lay-verify="required" value="" id="goodsId">
      </div>

     <br>      
      <div class="layui-form-item">
        <input type="hidden" name="cover" lay-verify="required"  class="image" >
          <div class="layui-upload" >
          <button type="button" class="layui-btn" id="test-upload-normal">套餐封面图片上传</button>
                    <div class="layui-upload-list">
                      <img class="layui-upload-img" src="" id="test-upload-normal-img" style="width:150px" alt="图片预览">
                    </div>
            </div>   
       </div>

       <div class="layui-form-item">   
        <textarea class="layui-textarea" name="content"  lay-verify="content"   id="LAY_demo1" style="display: none">  
          套餐介绍
        </textarea>
      </div> 

       <table class="layui-hide" id="LAY_table" lay-filter="group"></table>
       <div class="layui-form-item ">
        <div class="layui-input-block">
            <div class="layui-footer" style="left: 0;">
                <button class="layui-btn" lay-submit="" lay-filter="create">点击保存套餐</button>
            </div>
        </div>
    </div>
    </form>
    </div>



{{--      <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
      </script>  --}}

      <div class="layui-row" id="popUpdateTest" style="display:none;">
        
        <script type="text/html" id="toolbarDemo">
            <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckData">确定选择</button></div>
          </script>
        <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>

     
    </div>

    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
        var layedit;
        layui.use(['table', 'layer','laydate', 'upload','jquery', 'form', 'layedit'], function () {
         
            var table = layui.table;
            var laydate = layui.laydate;
            var $ = layui.jquery;
            var form = layui.form;
            upload = layui.upload;
            layedit = layui.layedit;

            layedit.set({
                uploadImage: {
                 
                 url: 'content/img' //接口url
                  ,type: 'post' //默认post
                }
              });
        
            index=  layedit.build('LAY_demo1'); //建立编辑器
         
            form.verify({
              content: function(value) { 
                   return layedit.sync(index);
                  }
          });

                  //套餐封面图片上传
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



            $(document).on('click', '#admin-management', function () {
                layer.open({
                    //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                    type: 1,
                    title: "选择产品",
                    area: ['800px', '450px'],
                    content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                  });

                  table.render({
                    url: "goods" //数据接口
                        ,
                    toolbar: '#toolbarDemo',
                    page: true, //开启分页
                        
                    elem: '#LAY_table_user',
                    cols: [
                        [
                            {type:'checkbox'},
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
                          
                            }
                        ]
                    ],
                    parseData: function (res) { //res 即为原始返回的数据
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
    
            });

            table.on('toolbar(user)', function(obj){
               
                var checkStatus = table.checkStatus(obj.config.id);
                switch(obj.event){
                case 'getCheckData':
                    var data = checkStatus.data;
                   // layer.alert(JSON.stringify(data));
                break;
                };

                var gid ="";
                for (let i=0; i<data.length; i++){
                    gid += data[i]['id']+",";
                }
                
                $("#goodsId").val(gid);
                layer.closeAll(); 
                table.render({
                    //page: true, //开启分页
                        
                    elem: '#LAY_table',
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
                          
                            }
                        ]
                    ],
                    data:data,
                    skin: 'line' //表格风格
                    ,even: true
                   // ,page: true //是否显示分页
                  //,limit: 10 //每页默认显示的数量
    
                });
    
            });

            //监听提交
            form.on('submit(create)', function (data) {
                console.log(data.field);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "group",
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
                                window.location.href = "grouplist";
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

           
/*
            table.on('tool(group)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {

                    layer.confirm('真的删除么', function (index) {
                        obj.del();
                  
                        layer.msg("删除成功", {
                            icon: 6
                        });
                        return false;
                    });
                } 
            });  
*/


        })

    </script>
</body>

</html>
