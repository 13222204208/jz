<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>轮播图</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
</head>

<body>
  <div class="demoTable" style="margin:5px;">
    <button class="layui-btn" data-type="reload" value="0" id="task-management">新建轮播图</button>
    <div class="layui-inline" style="color:gray" id="lp_address">
    </div>
</div>

  <table id="LAY_table_user" lay-filter="test"></table>
  <script type="text/html" id="barDemo">

    <a class="layui-btn  layui-btn-xs" lay-event="edit">修改</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  </script>     

  <div class="layui-row" id="popCreateTask" style="display:none;">
    <form class="layui-form layui-from-pane" required lay-verify="required" style="margin:20px">


    <input type="hidden" name="img_url" class="image" >
      <div class="layui-form-item">
        <div class="layui-upload" style="margin-left: 20%;">
        <button type="button" class="layui-btn" id="test-upload-normal">上传图片</button>
                  <div class="layui-upload-list">
                    <img class="layui-upload-img" src="" id="test-upload-normal-img" style="width:150px" alt="图片预览">
                  </div>
          </div>   
     </div>

      <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
          <input type="number" name="img_sort" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">跳转链接</label>
        <div class="layui-input-block">
          <input type="text" name="jump_url" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
          <input type="text" name="title" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
      </div>


      <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
          <input type="checkbox" checked="" name="state" lay-skin="switch" lay-filter="switchTest" lay-text="开启|关闭">
        </div>
      </div>

      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer" style="left: 0;">
            <button class="layui-btn" lay-submit="" lay-filter="createTask">新建轮播图</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="layui-row" id="popUpdateTask" style="display:none;">
    <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate"  style="margin:20px">


    <input type="hidden" name="img_url" class="image" >
      <div class="layui-form-item">
        <div class="layui-upload" style="margin-left: 20%;">
        <button type="button" class="layui-btn" id="upload-normal">上传图片</button>
                  <div class="layui-upload-list">
                    <img class="layui-upload-img" src="" id="upload-normal-img" style="width:150px" alt="图片预览">
                  </div>
          </div>   
     </div> 
     <div class="layui-form-item">
        <label class="layui-form-label">跳转链接</label>
        <div class="layui-input-block">
          <input type="text" name="jump_url" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
          <input type="text" name="title" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block">
          <input type="number" name="img_sort" required lay-verify="required" autocomplete="off" placeholder="" class="layui-input">
        </div>
      </div>


      <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
          <input type="checkbox" checked="" name="state" lay-skin="switch" lay-filter="switchTest" lay-text="开启|关闭">
        </div>
      </div>

      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer" style="left: 0;">
            <button class="layui-btn" lay-submit="" lay-filter="editChart">修改轮播图</button>
<!--             <button type="reset" class="layui-btn layui-btn-primary">重置</button> -->
          </div>
        </div>
      </div>
    </form>
  </div>


 



  <script src="/layuiadmin/layui/layui.js"></script>
  <script src="/layuiadmin/layui/jquery3.2.js"></script>
  <script>
    layui.use(['table', 'form',  'jquery','upload'], function() {
      var table = layui.table;
      var laydate = layui.laydate;
      var form = layui.form;
      var util = layui.util;
      var $ = layui.jquery;
      var  upload = layui.upload;

      $(document).on('click', '#task-management', function() {
        layer.open({
          //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
          type: 1,
          title: "新建轮播图",
          area: ['620px', '380px'],
          content: $("#popCreateTask") //引用的弹出层的页面层的方式加载修改界面表单
        });
      });

      //普通图片上传
      var uploadInst = upload.render({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        elem: '#test-upload-normal',
        accept:'images',
        size:3000,
        url: 'upload/rotation/img',
        before: function(obj) {      
          //预读本地文件示例，不支持ie8
          obj.preview(function(index, file, result) {
            $('#test-upload-normal-img').attr('src', result); //图片链接（base64）
          });
        },
        done: function(res) {
          if (res.status == 200) { 
            var img_url=res.path;
            $(" input[ name='img_url' ] ").val(img_url);
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

      var uploadInstedit = upload.render({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        elem: '#upload-normal',
        accept:'images',
        size:3000,
        url: 'upload/rotation/img',
        before: function(obj) {      
          //预读本地文件示例，不支持ie8
          obj.preview(function(index, file, result) {
            $('#upload-normal-img').attr('src', result); //图片链接（base64）
          });
        },
        done: function(res) {
          if (res.status == 200) { 
            var img_url=res.path;
            $(" input[ name='img_url' ] ").val(img_url);
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
          //上传成功
        },
        error: function(error) {
          console.log(error);
          //演示失败状态，并实现重传
          var demoText = $('#test-upload-demoText');
          demoText.html('<span style="color: #FF5722;">图片上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
          demoText.find('.demo-reload').on('click', function() {
            uploadInstedit.upload();
          });
        }
      });

      form.on('submit(createTask)', function(data) {//新建轮播图
				var data = data.field;
				console.log(data);
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "create/chart",
					method: 'POST',
					data: data,
					success: function(res) {
						console.log(res);
						if (res.status == 200) {
							layer.msg('保存成功', {
								offset: '15px',
								icon: 1,
								time: 3000
							});
              setTimeout(function() {
          
layer.closeAll(); //关闭所有的弹出层
location.href="rotation-chart";
}, 2000);
						} else {
							console.log(res);
							layer.msg('保存失败', {
								offset: '15px',
								icon: 2,
								time: 3000
							})
						}
					}
				});
				return false;
			});

      table.render({
        height: 600,
        url: "query/rotation/list",
        page: true, //开启分页
        elem: '#LAY_table_user',
        cols: [
          [ //表头
            {
              field: 'id',
              title: 'ID',
              width: 80,
              align: 'center',
              sort: true
            },{
              field: 'jump_url',
              title: '跳转链接',
              width: 280,
              align: 'center',
              sort: true
            },{
              field: 'title',
              title: '标题',
              width: 280,
              align: 'center',
              sort: true
            },
            {
              field: 'img_sort',
              title: '排序',
              align: 'center',
              width: 130,
            }, {
              field: 'state',
              title: '状态',
              align: 'center',
              width: 150,
              templet: function(d) {
                if (d.state == 1) {
                  return "开启";
                }else if(d.state == "on"){
                  return "开启";
                }else{
                  return "关闭";
                }
              },
            }, {
              field: 'created_at',
              title: '创建时间',
              align: 'center',
              width: 180
            },{
              fixed: 'right',
              title:"操作",
              width: 180,
              align: 'center',
              toolbar: '#barDemo'
            }
          ]
        ],
        parseData: function(res) { //res 即为原始返回的数据
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


      table.on('tool(test)', function(obj) { //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
        var data = obj.data; //获得当前行数据
        var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
        var tr = obj.tr; //获得当前行 tr 的 DOM 对象（如果有的话）

                 if (layEvent === 'del') { //删除
                  layer.confirm('真的删除行么', function(index) {
                    $.ajax({
                      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                      url: "del/rotation/chart",
                      type: 'post',                     
                      datatype: 'json',
                      data: {
                        'id': data.id
                      }, //向服务端发送删除的id
                      success: function(res) {
                        console.log(res);
                        if (res.status == 200) {
                          obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                          layer.close(index);
                          console.log(index);
                          layer.msg("删除成功", {
                            icon: 1
                          });
                        } else {
                          layer.msg("删除失败", {
                            icon: 5
                          });
                        }
                      }
                    });
                    layer.close(index);
                    //向服务端发送删除指令
                  });
                } else  
        if (layEvent === 'edit') { //编辑

          layer.open({
            //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
            type: 1,
            title: "编辑轮播图",
            area: ['620px', '350px'],
            content: $("#popUpdateTask") //引用的弹出层的页面层的方式加载修改界面表单
          });

          url = window.location.protocol+"//"+window.location.host+"/"+ data.img_url;
          $('#upload-normal-img').attr('src',url);
          // console.log(data);return false;
          form.val("formUpdate", data);
          setFormValue(obj, data);

          form.render();
        } else if (layEvent === 'LAYTABLE_TIPS') {
          layer.alert('Hi，头部工具栏扩展的右侧图标。');
        }
      });
      //更新广告信息
      function setFormValue(obj, data) {
        form.on('submit(editChart)', function(massage) {
          massage= massage.field; //console.log(massage);return false;
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "update/rotation/chart",
            type: 'post',
            data: {
              id: data.id,
              img_url: massage.img_url,
              img_sort:massage.img_sort,
              jump_url:massage.jump_url,
              title:massage.title,
              state:massage.state
            },
            success: function(msg) {
              console.log(msg);
              if (msg.status == 200) {
                layer.closeAll('loading');
                layer.load(2);
                layer.msg("修改成功", {
                  icon: 6
                });
                setTimeout(function() {

                  obj.update({
                    img_sort:massage.img_sort,
                    title:massage.title,
                    jump_url:massage.jump_url,
              state:massage.state
                  }); //修改成功修改表格数据不进行跳转              
                  layer.closeAll(); //关闭所有的弹出层

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

    });
  </script>
</body>

</html>