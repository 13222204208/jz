

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>添加类型</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">

  <style> .layui-form-label {
    width: 120px !important;
    text-align: center !important;
    }
    </style>
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md12">
        <div class="layui-card">
          <div class="layui-card-header">积分参数设置</div>
          <div class="layui-card-body" >
            
            <div class="layui-form" lay-filter="">          

                <div class="layui-form-item">
                    <label class="layui-form-label" style="width: 300" >工程订单积分参数</label>
                    <div class="layui-input-inline">
                      <input type="number" id="gcOrder" name="engineer_parameter" lay-verify="pass" placeholder="按百分比 1输入 100" autocomplete="off" value="" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">%</div>
                  </div>

                  <div class="layui-form-item">
                    <label class="layui-form-label">客户订单积分参数</label>
                    <div class="layui-input-inline">
                      <input type="number" id="khOrder" name="owner_parameter" lay-verify="pass" placeholder="按百分比 0.15 输入 15" autocomplete="off" value="" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux">%</div>
                  </div>

 

              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit lay-filter="setmyinfo">保存</button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>


    </div>
  </div>



  <script src="/layuiadmin/layui/layui.js"></script>
  <script src="/layuiadmin/layui/jquery3.2.js"></script>
  <script> 
    layui.use([ 'form','table'], function() {
			var $ = layui.$,
				admin = layui.admin,
				table = layui.table,
				layer = layui.layer,
				form = layui.form;

				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "integral-data",
					method: 'get',
					success: function(res) {
					
						if (res.status == 200) {
							$('#gcOrder').val(res.data.engineer_parameter);
                            $('#khOrder').val(res.data.owner_parameter);
						} 
					}
				});


			form.on('submit(setmyinfo)', function(data) {
				var data = data.field;
				
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					url: "integral-data/1",
					method: 'patch',
					data: data,
					success: function(res) {
						console.log(res);
						if (res.status == 200) {
							layer.msg('成功', {
								offset: '15px',
								icon: 1,
								time: 3000
                        });
            
						} else {
							console.log(res);
							layer.msg('添加失败', {
								offset: '15px',
								icon: 2,
								time: 3000
							})
						}
					}
				});
				return false;
			});

    });
  </script>
</body>
</html>