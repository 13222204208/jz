<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>用户列表 </title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>
<style>
.mainTop .layui-form-label { width: auto; padding-right: 5px; }
.dateIcon { display: inline-block; background: url(images/dateIcon.png) no-repeat 210px center; }
</style>
<body><br>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">角色名称：</label>
                <div class="layui-input-inline">
                    <select name="role_id" id="isNo" lay-filter="stateIsNo">
                        <option value=""></option>
                        <option value="1">业主</option>
                        <option value="2">商家</option>
                        <option value="3">工程师</option>
                    </select>
                </div>
            </div>

            <div class="layui-inline">
                <label class="layui-form-label">昵称：</label>
                <div class="layui-input-inline">
                    <input class="layui-input" name="name" id="demoReload" autocomplete="off">
                </div>
                <div class="layui-input-inline">
                    <button class="layui-btn" lay-submit="" lay-filter="create">查询</button>
                </div>
            </div>
        </div>

    </form>



    <div class="layui-row" id="popUpdateTask" style="display:none;">
        <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"  style="margin:20px">
    
         <div class="layui-form-item">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-block">
              <input type="text" name="nickname" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">真实姓名</label>
            <div class="layui-input-block">
              <input type="text" name="truename"   autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>

          <div class="layui-form-item">
            <label class="layui-form-label">地址</label>
            <div class="layui-input-block">
              <input type="text" name="address" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">公司名称</label>
            <div class="layui-input-block">
              <input type="text" name="company"  autocomplete="off" placeholder="" class="layui-input">
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

    <div class="layui-row" id="popUpdateTest" style="display:none;">
        <form class="layui-form" action="">
            <br>
            <div class="layui-form-item">
                <label class="layui-form-label">复选框</label>
                <div class="layui-input-block" id="search_checkbox" >
                  <input type="checkbox"  name="like[owner]" value="is_owner" title="业主">
                  <input type="checkbox"  name="like[seller]" value="is_seller" title="商家">
                  <input type="checkbox"  name="like[engineer]" value="is_engineer" title="工程师">
                </div>
              </div>
         
        
{{--              <div class="layui-form-item">
              <label class="layui-form-label">角色名称:</label>
              <div class="layui-input-block" >
                  <select name="role_id" id="isNo" lay-filter="stateIsNo">
                      <option value=""></option>
                      <option value="1">业主</option>
                      <option value="2">商家</option>
                      <option value="3">工程师</option>
                  </select>
              </div>
          </div>  --}}
        
        
            <div class="layui-form-item ">
              <div class="layui-input-block">
                  <div class="layui-footer" style="left: 0;">
                      <button class="layui-btn" lay-submit="" lay-filter="createRole">更换角色</button>
                  </div>
              </div>
          </div>
        </form>
    </div>

    <div class="layui-row" id="giveIntegral" style="display:none;">
        <form class="layui-form" action="">
            <br>
            <div class="layui-form-item">
                <label class="layui-form-label">赠送积分</label>
                <div class="layui-input-inline">
                    <input type="number"  name="integral" lay-verify="pass" placeholder="积分值" autocomplete="off" value=""  class="layui-input">
                  </div>
              </div>
         
        
        
            <div class="layui-form-item ">
              <div class="layui-input-block">
                  <div class="layui-footer" style="left: 0;">
                      <button class="layui-btn" lay-submit="" lay-filter="createIntegral">赠送</button>
                  </div>
              </div>
          </div>
        </form>
    </div>

    <table class="layui-hide" id="LAY_table_user" lay-filter="user"></table>
     <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">分配角色</a>
        <a class="layui-btn layui-btn-xs" lay-event="give">赠送积分</a>
        <a class="layui-btn layui-btn-xs" lay-event="update">编辑</a>
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
              

            table.render({
                url: "userinfo" //数据接口
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
                            width: 80,
                            sort: true
                        }, {
                            field: 'nickname',
                            title: '昵称',
                       
                        },{
                            field: 'phone',
                            title: '手机号',
                        
                        },{
                            field: 'truename',
                            title: '真实姓名',
                        
                        },{
                            field: 'address',
                            title: '地址',
                        
                        },{
                            field: 'sex',
                            title: '姓别',
                            templet:function(d){
                                if(d.sex == 1){
                                    return '男';
                                }else{
                                    return '女';
                                }
                            }
                        
                        },{
                            field: 'role_name',
                            title: '角色',
                                          
                        },{
                            field: 'give',
                            title: '赠送积分',
                            templet: function(d) {
                                console.log(d.give)
                                arr = d.give
                                str = ""
                                for (var k = 0, length = arr.length; k < length; k++) {
    
                                   console.log(arr[k])
                                      str += arr[k].integral+"，"
                                      } 
                                      return str;
                            }
                                          
                        },{
                            field: 'company',
                            title: '公司名称',
                                          
                        },{
                            field: 'status',
                            title: '状态',
                            //width:150,
                            templet: function(d) {
                                if (d.status == 1) {
                                     return '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                     '" lay-skin="switch" checked '+ 'lay-text="正常|已禁用">';
                                  
                                }else{
                                    return '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                    '" lay-skin="switch" lay-text="正常|已禁用">';
                              }
                                                             
                            }
                        },{
                            fixed: 'right',
                            title: "操作",
                            width: 260,
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
                //console.log(checked);
                //console.log(switch_goods_id);return false;
                $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "userinfo/"+switch_goods_id +'/edit',
                    type: 'get',
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

               form.on('submit(create)', function (data) {
                console.log(data.field); 
                table.render({
                    url: "search" //数据接口
                        ,
                    where:{
                        info:data.field.name,
                        role_id:data.field.role_id
                    },
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
                            },{
                                field: 'nickname',
                                title: '昵称',
                            
                            },{
                                field: 'phone',
                                title: '手机号',
                            
                            },{
                                field: 'truename',
                                title: '真实姓名',
                            
                            },{
                                field: 'address',
                                title: '地址',
                            
                            },{
                                field: 'sex',
                                title: '姓别',
                                templet:function(d){
                                    if(d.sex == 1){
                                        return '男';
                                    }else{
                                        return '女';
                                    }
                                }
                            
                            },{
                                field: 'give',
                                title: '赠送积分',
                                templet: function(d) {
                          
                                    arr = d.give
                                    str = ""
                                    for (var k = 0, length = arr.length; k < length; k++) {
        
                                       console.log(arr[k])
                                          str += arr[k].integral+"，"
                                          } 
                                          return str;
                                }
                                              
                            },{
                                field: 'role_name',
                                title: '角色',
                                              
                            },{
                                field: 'company',
                                title: '公司名称',
                                              
                            },{
                                field: 'give',
                                title: '赠送积分',
                                templet: function(d) {
                                    console.log(d.give)
                            /**        var arr = d.give;
                                        var sum =0;
                                        arr.forEach(function(value,index,array){

                                        array[index] == value; //结果为true

                                        return value;

                                        }); */
                                }
                                              
                            },{
                                field: 'status',
                                title: '状态',
                                //width:150,
                                templet: function(d) {
                                    if (d.status == 1) {
                                         return '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                         '" lay-skin="switch" checked '+ 'lay-text="正常|已禁用">';
                                      
                                    }else{
                                        return '<input type="checkbox" class="switch_checked" lay-filter="switchGoodsID"'+ 'switch_goods_id="'+ d.id+
                                        '" lay-skin="switch" lay-text="正常|已禁用">';
                                  }
                                                                 
                                }
                            },{
                                fixed: 'right',
                                title: "操作",
                                width: 260,
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
                   
         
                 return false;
             });



            table.on('tool(user)', function (obj) {
                 data = obj.data;
             
              if (obj.event === 'edit') {
                    //location.href="details/"+data.id;
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "更换角色",
                        area: ['400px', '250px'],
                        content: $("#popUpdateTest") //引用的弹出层的页面层的方式加载修改界面表单
                    });
                    console.log(data);
                    html = '';
                    if(data.is_owner == 1){
                    html += '<input type="checkbox"  name="like[owner]" value="is_owner" title="业主" checked="">';
                    }else{
                        html += '<input type="checkbox"  name="like[owner]" value="is_owner" title="业主" >';
                    }
                    if(data.is_seller == 1){
                    html +='<input type="checkbox"  name="like[seller]" value="is_seller" title="商家" checked="">';
                    }else{
                        html +='<input type="checkbox"  name="like[seller]" value="is_seller" title="商家" >';
                    }
                    if(data.is_engineer == 1){
            html +='<input type="checkbox"  name="like[engineer]" value="is_engineer" title="工程师" checked="" >';
                    }else{
                        html +='<input type="checkbox"  name="like[engineer]" value="is_engineer" title="工程师" >';
                    }

                    $('#search_checkbox').html(html);
                    form.render();    //重新渲染
                    dataId = data.id;
                    setFormId(obj,dataId);
                    function setFormId(obj,dataId){

                        form.on('submit(createRole)', function (data) {
                            role_id = data.field.role_id;
                            var arr_box = [];
                            $('#search_checkbox input[type=checkbox]:checked').each(function() {
                               arr_box.push($(this).val());
                            });
                          
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "userinfo/"+dataId,
                                type: 'patch',
                                data:{role:arr_box} ,//工程师id
                                success: function (msg) {
                                    console.log(msg);
                                    if (msg.status == 200) {
                                        layer.closeAll('loading');
                                        layer.load(2);
                                        layer.msg("修改成功", {
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

                  
                }else if(obj.event === 'update'){
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "编辑用户",
                        area: ['620px', '370px'],
                        content: $("#popUpdateTask") //引用的弹出层的页面层的方式加载修改界面表单
                      });
                    
                      form.val("formUpdate", data);
                      setFormValue(obj, data);
                }else if(obj.event === 'give'){
                    layer.open({
                        //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                        type: 1,
                        title: "赠送积分",
                        area: ['620px', '370px'],
                        content: $("#giveIntegral") //引用的弹出层的页面层的方式加载修改界面表单
                      });
                    
                      form.on('submit(createIntegral)', function(data){
                        message = data.field;
                        message.user_id = obj.data.id;
                       
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "give_integral",
                            method: 'post',
                            data: message,
                            success: function (msg) {
                                console.log(msg);
                                if (msg.status == 200) {
                                    layer.closeAll('loading');
                                    layer.load(2);
                                    layer.msg("成功", {
                                        icon: 6
                                    });
                                    setTimeout(function () {
     
                                  
     
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
                }else if (obj.event === 'del') {

                    layer.confirm('真的删除此用户么', function (index) {
                        $.ajax({
                            url: "userinfo/"+data.id,
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
                                    layer.msg("删除失败,此工程师名下有订单", {
                                        icon: 5
                                    });
                                }
                            }
                        });
                        return false;
                    });
                }

            });

            function setFormValue(obj, data) {
        
                form.on('submit(editOrder)', function(data){
                   message = data.field;
                   //console.log(obj.data.id); return false;
                   $.ajax({
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       },
                       url: "updateInfo/"+obj.data.id,
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
                                       nickname:message.nickname,
                                       truename:message.truename,
                                       address:message.address,
                                       company:message.company
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

        })

    </script>
</body>

</html>
