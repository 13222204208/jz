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
    <div class="layui-row" id="popUpdateTask" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"  style="margin:20px">
    
         <div class="layui-form-item">
            <label class="layui-form-label">合同名称</label>
            <div class="layui-input-block">
              <input type="text" name="title" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">合作方全称</label>
            <div class="layui-input-block">
              <input type="text" name="partner" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
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
            <label class="layui-form-label">合同标的</label>
            <div class="layui-input-block">
              <input type="number" name="cost" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">合同备注</label>
            <div class="layui-input-block">
              <input type="text" name="comments" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
    
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button type="submit" class="layui-btn" lay-submit="" lay-filter="editOrder">立即提交</button>
              <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
          </div>

        </form>
      </div>

    <div class="demoTable" style="margin:5px;">
        <button class="layui-btn" data-type="reload" value="0" id="admin-management">添加合同</button>
        <div class="layui-inline" style="color:gray" id="lp_address">
        </div>
    </div>

    <form class="layui-form" action="">
        <div class="layui-form-item">

            <div class="layui-inline"></div>
                <label class="layui-form-label"> 合同名称：</label>
                <div class="layui-input-inline">
                    <input class="layui-input" name="contract_name"  autocomplete="off">
                </div>

                <label class="layui-form-label"> 合作方：</label>
                <div class="layui-input-inline">
                    <input class="layui-input" name="partner"  autocomplete="off">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" lay-submit="" lay-filter="searchContract">查询</button>
                </div>
            </div>
        </div>

    </form>


    <div class="layui-row" id="allotPackage" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" style="margin:20px">

            <div class="layui-form-item">
               
                <select name="type" lay-verify="required" >
                    <option value="add">增加套餐</option>
                    <option value="del">减少套餐</option>
                </select>
            </div>

            <div class="layui-form-item">
               
                  <select name="goods_package_id" lay-filter="cate_demo" id="GoodsPackage" lay-verify="required" >

                  </select>
              </div>

            <div class="layui-form-item">
               
                    <input type="number" name="goods_package_qty" lay-verify="required"  autocomplete="off"
                        placeholder="数量" value="" class="layui-input">
               
            </div>

              <br>      

            <div class="layui-form-item ">
                <div class="layui-input-block">
                    <div class="layui-footer" style="left: 0;">
                        <button class="layui-btn" lay-submit="" lay-filter="createPackage">保存</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="layui-row" id="popUpdateTest" style="display:none;">
        <table class="layui-hide" id="LAY_table" lay-filter="user"></table>
        <script type="text/html" id="toolbarDemo">
            <div  style="text-align: center">  <button class="layui-btn layui-btn-sm" lay-event="getCheckData">确定关联</button></div>
          </script>       
</div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
    <script type="text/html" id="barDemo">
        <a class="layui-btn  layui-btn-xs" lay-event="update">编辑</a>
        <a class="layui-btn  layui-btn-xs" lay-event="download">下载合同附件</a>
        <a class="layui-btn  layui-btn-xs" lay-event="edit">关联商家</a>
        <a class="layui-btn  layui-btn-xs" lay-event="allot">分配套餐</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>

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

            form.on('submit(searchContract)', function (data) {
                data= data.field;
                
                table.render({
                    url: "search_contract"//数据接口
                        ,
                    page: true //开启分页
                        ,
                    type:'get',
                    where:{
                        contract_name:data.contract_name,
                        partner:data.partner
                    },
                    elem: '#LAY_table_user',
                    toolbar: '#listbarDemo',
                    cols: [
                        [
    
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
                          
                          
                            },  {
                                fixed: 'right',
                                title: "操作",
                                align: 'center',
                                width:380,
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
                toolbar: '#listbarDemo',
                cols: [
                    [

                        {
                            field: 'id',
                            title: 'ID',
                            width: 60,
                            sort: true
                        }, {
                            field: 'title',
                            title: '合同名称',
                            width:100
                        },{
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
                      
                      
                        },  {
                            fixed: 'right',
                            title: "操作",
                            align: 'center',
                            width:380,
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
                id = data.id;
                function setFormValue(obj, data) {
        
                    form.on('submit(editOrder)', function(data){
                       message = data.field;
                       //console.log(obj.data.id); return false;
                       $.ajax({
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           url: "updateContract/"+obj.data.id,
                           method: 'post',
                           data: message,
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
                                           title:message.title,
                                           partner:message.partner,
                                           cover:message.cover,
                                           cost:message.cost,
                                           comments:message.comments
                                       });  
   
   
                                       layer.closeAll(); //关闭所有的弹出层
                                       //window.location.href = "/edit/horse-info";
   
                                   }, 1000);
   
                               } else {
                                   layer.msg("修改失败", {
                                       icon: 5
                                   });
                               }
                           }
                       });
                       return false;
                     });
               }
               if(obj.event === 'update'){
                layer.open({
                    //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                    type: 1,
                    title: "编辑合同",
                    area: ['620px', '450px'],
                    content: $("#popUpdateTask") //引用的弹出层的页面层的方式加载修改界面表单
                  });
                  url = window.location.protocol+"//"+window.location.host+"/";
                  str = data.photo;
                  $('#test-upload-normal-img').attr('src', url+data.cover); 
                  form.val("formUpdate", data);
                  setFormValue(obj, data);
            }else if(obj.event ==='allot'){
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "分配套餐",
                        area: ['500px', '300px'],
                        content: $("#allotPackage") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                    
            $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "goods-package",
                method: 'get',
                dataType: 'json',
                success: function(res) {
          
                  status = res.status;
                   role_name = res.data; //console.log( role_name[0].name); return false
                  if (res.status == 200) {
                    optionData = "";
                      for (var i = 0; i < role_name.length; i++) {
                      var t = role_name[i];
                      optionData += '<option value="'+t.id +'">'+ t.title+'</option>';
                    }
        
                      $("#GoodsPackage").html(optionData);
                      form.render('select');
        
                    }else if (res.status == 403) {
                    layer.msg('填写错误或角色名重复', {
                      offset: '15px',
                      icon: 2,
                      time: 3000
                    }, function() {
                      location.href = 'contract-list';
                    })
                  }
                }
              });

                          //监听提交
            form.on('submit(createPackage)', function (data) {
                data.field.contract_id = id;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "create-contract-package",
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
                                //window.location.href = "";
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

                }else if (obj.event === 'download') {
                    url = window.location.protocol+"//"+window.location.host+"/";
                    file = url+data.file_name;
                    window.open(file);
                } else if (obj.event === 'edit') {
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "关联商家",
                        area: ['700px', '450px'],
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
                                    field: 'nickname',
                                    title: '昵称',
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

                }else if (obj.event === 'del') {

                    layer.confirm('真的删除此合同么', function (index) {
                        $.ajax({
                            url: "contract/"+data.id,
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
                                    layer.msg("删除失败,此合同已存在工程", {
                                        icon: 5
                                    });
                                }
                            }
                        });
                        return false;
                    });
                }

            });

           

        })

    </script>
</body>

</html>
