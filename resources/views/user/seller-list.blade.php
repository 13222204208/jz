<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>商家列表 </title>
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
                <label class="layui-form-label">手机号：</label>
                <div class="layui-input-inline">
                    <input class="layui-input" name="phone" id="demoReload" autocomplete="off">
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


    <table class="layui-hide" id="LAY_table_user" lay-filter="lookSeller"></table>
     <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="look">查看积分</a>
    </script>  
    <script type="text/html" id="listbarDemo">
        <div class="layui-btn-container">
        
        </div>
      </script>
      <div class="layui-row" id="popUpdateSeller" style="display:none;">
        <table class="layui-hide" id="LAY_table_seller" ></table>
    </div>
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
                url: "seller" //数据接口
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
                            field: 'integral',
                            title: '剩余积分',
                        
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
                            field: 'company',
                            title: '公司名称',
                                          
                        },{
                            field: 'status',
                            title: '状态',
                            //width:150,
                            templet: function(d) {
                                if (d.status == 1) {
                                     return '正常';
                                  
                                }else{
                                    return '已禁用';
                              }
                                                             
                            }
                        },{
                            fixed: 'right',
                            title: "操作",
                            width: 200,
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


       
               form.on('submit(create)', function (data) {
                console.log(data.field); 
                table.render({
                    url: "seller/"+data.field.phone //数据接口
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
                                field: 'integral',
                                title: '剩余积分',
                            
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
                                field: 'company',
                                title: '公司名称',
                                              
                            },{
                                field: 'status',
                                title: '状态',
                                //width:150,
                                templet: function(d) {
                                    if (d.status == 1) {
                                      return '正常';
                                    }else{
                                        return '已禁用';
                                    }
                                  }
                            },{
                                fixed: 'right',
                                title: "操作",
                                width: 200,
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



            table.on('tool(lookSeller)', function (obj) {
                 userID = obj.data.id;
                 //console.log(obj);//return false;
             if(obj.event === "look"){
                layer.open({
                    //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                    type: 1,
                    title: "工程订单",
                    area: ['620px', '370px'],
                    content: $("#popUpdateSeller") //引用的弹出层的页面层的方式加载修改界面表单
                  });
                  table.render({
                    url: "seller-order/"+userID //数据接口
                        ,
                    page: true //开启分页
                        ,
                    elem: '#LAY_table_seller',
                    //toolbar: '#listbarDemo',
                    cols: [
                        [
    
                            {
                                field: 'id',
                                title: 'ID',
                                width: 80,
                                sort: true,
                                totalRowText: '合计'
                            },{
                                field: 'order_num',
                                title: '订单号',
                                width:170
                          
                            },{
                                field: 'order_name',
                                title: '订单名称',
                                width:150
                          
                            },{
                                field: 'total_money',
                                title: '订单金额',
                                width:100,
                                totalRow: true
                          
                            },{
                                field: 'integral',
                                title: '积分值',
                                width:100,
                                totalRow: true
                          
                            }, {
                                field: 'owner_name',
                                title: '业主名称',
                                width:120
                            },{
                                field: 'owner_phone',
                                title: '业主手机号',
                                width:150
                            },{
                                field: 'owner_address',
                                title: '业主地址',
                                width:150
                          
                            },{
                                field: 'functionary',
                                title: '负责人',
                                width:120
                          
                            },{
                                field: 'functionary_phone',
                                title: '负责人手机号',
                                width:120
                          
                            },
                            {
                                field: 'engineer_name',
                                title: '施工人员名称',
                                width:180
                          
                            },{
                                field: 'engineer_phone',
                                title: '施工人员手机号',
                                width:200
                          
                            },{
                                field: 'agreement_id',
                                title: '合同',
                                width:150
                          
                            },{
                                field: 'owner_demand',
                                title: '业主需求',
                                width:150
                          
                            }, {
                                field: 'company',
                                title: '商家公司名称',
                                width:150
                          
                            },{
                                field: 'status',
                                title: '状态',
                                templet: function(d) {
                                    if(d.status ==1){
                                      return '待施工';
                                    }else if(d.status ==2){
                                      return '施工中';
                                    }else if(d.status ==3){
                                        return '施工完成';
                                    }else if(d.status ==4){
                                        return '已签字';
                                    }
                                   
                                  },
                                width:100
                          
                            },{
                                field: 'created_at',
                                title: '创建时间',
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
                  
                    title: '后台用户',
                    totalRow: true
    
                });
                return false;
                 
             }
         

            
            
            });


        })

    </script>
</body>

</html>
