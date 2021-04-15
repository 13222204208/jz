<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>添加套餐产品 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>

<body>

    <div class="demoTable" style="margin:5px;">
        <button class="layui-btn" data-type="reload" value="0" id="admin-management">添加套餐</button>
     
    </div>

    <div class="layui-row" id="popUpdateTest" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"
            style="margin:20px">
            
            <div class="layui-form-item">
                <label class="layui-form-label">套餐名称</label>
                <div class="layui-input-inline">
                <input type="text" name="title" lay-verify="required"  autocomplete="off"
                    placeholder="产品名称" value="" class="layui-input">
                </div>
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
            <label class="layui-form-label">套餐价格</label>
            <div class="layui-input-inline">
            <input type="number" name="package_price"  autocomplete="off"
                placeholder="套餐单价" value="" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">转化率</label>
            <div class="layui-input-inline">
                <input type="number"  name="change" lay-verify="pass" placeholder="转化率 0.15 输入 15" autocomplete="off" value=""  class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">   
          <textarea class="layui-textarea" name="content"    id="LAY_demo1" style="display: none">  
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




    <table class="layui-hide" id="LAY_table_user" lay-filter="myuser"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-xs" lay-event="show">查看套内详情</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> 

    </script>

    <div class="layui-row" id="showTest" style="display:none;">
        <button class="layui-btn" id="admin-management-goods" style="margin-left:10px" data-type="reload">添加产品</button>
        <table class="layui-hide" id="LAY_tables" lay-filter="groupuser"></table>
        <script type="text/html" id="addBarDemo">
       
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a> 
    
        </script>

    </div>
    <div class="layui-row" id="addPopUpdate" style="display:none;">
        
        <script type="text/html" id="toolbarGoods">
            <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckGoods">确定添加</button></div>
          </script>
        <table class="layui-hide" id="LAY_table_goods" lay-filter="checkDoods"></table>

     
    </div>

    <div class="layui-row" id="popUpdateTest" style="display:none;">
        
        <script type="text/html" id="toolbarDemo">
            <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckData">提交选择</button></div>
          </script>
        <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>

     
    </div>

    <script src="/layuiadmin/layui/layui.js"></script>
    <script>
       
        layui.use(['table', 'layer','laydate','layedit', 'upload','jquery', 'form'], function () {
          

         
             table = layui.table;
             laydate = layui.laydate;
             $ = layui.jquery;
             form = layui.form;
             layedit = layui.layedit;
             upload = layui.upload;

            $(document).on('click', '#admin-management', function () {
                location.href='addgroup';
            });

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



              
            $(document).on('click', '#admin-management-goods', function () {
                layer.open({
                    //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                    type: 1,
                    title: "选择产品",
                    area: ['800px', '450px'],
                    content: $("#addPopUpdate") //引用的弹出层的页面层的方式加载修改界面表单
                  });

                  $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "check_id",
                    method: 'get',
                 
                    dataType: 'json',
                    success: function (res) {
                        console.log(res); 
                        if (res.status == 200) {
                            table.render({
                                toolbar: '#toolbarGoods',
                                page: true, //开启分页
                                limit:10,
                                elem: '#LAY_table_goods',
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
                               data:res.data,
                                id: 'testReload',
                                title: '后台用户',
                                totalRow: true
                
                            });
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


    
            });
            

            table.render({
                url: "group" //数据接口
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
                            title: '套餐名称',
                            width:150
                        }, {
                            field: 'type',
                            title: '套餐类型',
                            width:150,
                            templet: function(d) {
                                if(d.type == 1){
                                    return "普通套餐"
                                }else{
                                    return "自定义套餐"
                                }
                            }
                        },{
                            field: 'package_price',
                            title: '套餐价格',
                            width:150
                        },{
                            field: 'change',
                            title: '转化率(%)',
                            width:150
                        }, {
                            field: 'integral',
                            title: '积分值',
                            width:150
                        },  {
                            field: 'created_at',
                            title: '创建时间',
                        },{
                            field: 'status',
                            title: '状态',
                            //width:150,
                            templet: function(d) {
                                if (d.status == 1) {
                                  return '<div class="layui-input-block">'+
                                    '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                     '" lay-skin="switch" checked '+ 'lay-text="上架|下架">'+
                                  '</div>';
                                }else{
                                    return '<div class="layui-input-block">'+
                                        '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                         '" lay-skin="switch" lay-text="上架|下架">'+
                                      '</div>';
                                }
                              }
                        },{
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

            form.on('switch(switchGoodsID)',function (data) {
                
                //开关是否开启，true或者false
                var checked = data.elem.checked;

                if(checked === false){
                    checked = 2;
                }else{
                    checked = 1;
                }

                //获取所需属性值
                var switch_goods_id = data.elem.attributes['switch_goods_id'].nodeValue;
                console.log(checked);
                console.log(switch_goods_id);
                $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "group"+'/'+switch_goods_id ,
                    type: 'patch',
                    data: {
                        status:checked
                    },
                    success: function(msg) {
                      console.log(msg);
                      if (msg.status == 200) {

            
                        form.render();

                        layer.msg("修改成功", {
                            icon: 1
                          });
                      } else {
                        layer.msg("修改失败", {
                          icon: 5
                        });
                      }
                    }
                  });


               });


            table.on('tool(myuser)', function (obj) {
                var data = obj.data;
                var event = obj.event;
                id = data.id;
                console.log(data);

                if (event === 'show') {
                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "group"+'/'+id ,
                        type: 'get',
                        success: function(msg) {
                          console.log(msg);
                          if (msg.status == 200) {
                            table.render({
                                elem: '#LAY_tables',
                                data:msg.data,
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
                                            field: 'number',
                                            title: '库存',
                                            width:150
                                      
                                        },{
                                            field: 'price',
                                            title: '单价',
                                            width:150
                                      
                                        },{
                                            fixed: 'right',
                                            title: "操作",
                                            align: 'center',
                                            toolbar: '#addBarDemo'
                                        }
                                    ]
                                ]
                                ,even: true
                                ,page: true //是否显示分页
                                //,limits: [5, 7, 10]
                                ,limit: 10 //每页默认显示的数量   
                        }); 
                          } else {
                            layer.msg("修改失败", {
                              icon: 5
                            });
                          }
                        }
                      })
                  layer.open({
                    //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                    type: 1,
                    title: "套餐详情",
                    area: ['800px', '450px'],
                        content: $("#showTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });
         

                    
                table.on('tool(groupuser)', function (obj) {
              
                    $.ajax({
                        url: "del_group_goods",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        data:{
                            goods_id:obj.data.id,
                            group_id:data.id
                        },
                        type: "post",
                        success: function (msg) {
                      
                            if (msg.status == 200) {
                                //删除这一行
                                obj.del();
                                //关闭弹框
                                localStorage.removeItem("myCheckID")
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
                });

                
                table.on('checkbox(checkDoods)', function(obj){
                    console.log(obj.checked); //当前是否选中状      
                    yangCheckID = obj.data.id;
                    console.log(yangCheckID)
                    if(localStorage.getItem("myCheckID") == null){
                        checkID = "";
                    }else{
                        checkID= localStorage.getItem("myCheckID");
                    }
           
                    if(obj.checked == true){
                        checkID += ","+ yangCheckID;
                        localStorage.setItem("myCheckID",checkID);
                     
                    }
                    if(obj.checked == false){
                        Array.prototype.removeByValue = function(val) {
                            for(var i = 0; i < this.length; i++) {
                              if(this[i] == val) {
                                this.splice(i, 1);
                                break;
                              }
                            }
                          }

                        var stringResult = checkID.split(',');
                        stringResult.removeByValue(yangCheckID);
                        console.log(stringResult)
                 
                        localStorage.setItem("myCheckID",stringResult);
                    } 
                   console.log( localStorage.getItem("myCheckID"));
                   });
                

                table.on('toolbar(checkDoods)', function(obj){
                   /** localStorage.removeItem("myCheckID")
                    var checkStatus = table.checkStatus(obj.config.id);
                   
                    switch(obj.event){
                    case 'getCheckGoods':
                        var mydata = checkStatus.data;
                  
                    break;
                    };
                    console.log(mydata);
                    var gid ="";
                    for (let i=0; i<mydata.length; i++){
                        gid += mydata[i]['id']+",";
                    }
                    console.log(gid)
                  return false; */
                    gid = localStorage.getItem("myCheckID");
                    console.log(gid)
                    localStorage.removeItem("myCheckID")
                    $.ajax({
                        url: "add_group_goods",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        data:{
                            goods_id:gid,
                            group_id:data.id
                        },
                        type: "post",
                        success: function (msg) {
                   
                            if (msg.status == 200) {
                                layer.closeAll(); 
                                layer.msg("成功", {
                                    icon: 6
                                });
                            } else {
                                layer.msg("失败", {
                                    icon: 5
                                });
                            }
                           location.href = 'grouplist'; 
                        }
                    });
        
                });
            

                  } 
        

                if (event === 'del') {

                    layer.confirm('真的删除此分类么', function (index) {
                        $.ajax({
                            url: "group/"+data.id,
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
                }else if (obj.event === 'edit') {
                    //location.href="details/"+data.id;
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "编辑套餐",
                        area: ['700px', '450px'],
                        content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                   
                    url = window.location.protocol+"//"+window.location.host+"/";
                    str = data.photo;
                    $('#test-upload-normal-img').attr('src', url+data.cover); 
           

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

console.log(massage)
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "updateGroup/"+data.id,
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
                                        package_price: massage.package_price,
                                        change: massage.change,
                                        integral: massage.package_price*massage.change/100
                                    }); //修改成功修改表格数据不进行跳转 


                                    layer.closeAll(); //关闭所有的弹出层
                                    //window.location.href = "/edit/horse-info";
                                    window.location.reload();
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
