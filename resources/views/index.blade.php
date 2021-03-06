

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>后台管理</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">


</head>
<body class="layui-layout-body">

  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
 <!--          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="http://www.layui.com/admin/" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li> -->
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
<!--           <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search?keywords=">
          </li> -->
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

<!--           <li class="layui-nav-item" lay-unselect>
            <a lay-href="app/message/index" layadmin-event="message" lay-text="消息中心">
              <i class="layui-icon layui-icon-notice"></i>
              <span class="layui-badge-dot"></span>
            </a>
          </li> -->
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="note">
              <i class="layui-icon layui-icon-note"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
              <cite>{{session('username')}}</cite>
            </a>
            <dl class="layui-nav-child">
          <!--    <dd><a lay-href="bguser/basic/document">基本资料</a></dd> -->
              <dd><a lay-href="user/upassword">修改密码</a></dd>
              <hr>
              <dd layadmin-event="" style="text-align: center;" ><a onclick="logout()">退出</a></dd>
            </dl>
          </li>
          <script>
              function logout(){
                top.location.href="/logout";
              }
          </script>

          <li class="layui-nav-item layui-hide-xs" lay-unselect>
           <!--  <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a> -->
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>

      <div class="layui-row" id="popUpdateTest" style="display:none;">
    <form class="layui-form layui-from-pane" required lay-verify="required" lay-filter="formUpdate" style="margin:20px">



      <div class="layui-form-item">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-block">
          <input type="text" name="nickname" required lay-verify="required" autocomplete="off" placeholder="" value="" class="layui-input">
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">角色</label>
        <div class="layui-input-block">
          <select name="role" lay-filter="aihao">

          </select>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-block">
          <input type="text" name="state"  autocomplete="off" placeholder="" value="" class="layui-input">
        </div>
      </div>

      <div class="layui-form-item ">
        <div class="layui-input-block">
          <div class="layui-footer" style="left: 0;">
            <button class="layui-btn" lay-submit="" lay-filter="editAccount">修改</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
          </div>
        </div>
      </div>
    </form>
  </div>

      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="home/homepage">
            <span>后台管理</span>
          </div>

          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            @if(in_array('用户列表',$per) || in_array('实名认证',$per) || in_array('报修售后列表',$per) || in_array('用户美图',$per))
            <li data-name="user" class="layui-nav-item">
              <a href="javascript:;" lay-tips="用户管理" lay-direction="2">
                <i class="layui-icon layui-icon-user"></i>
                <cite>用户管理</cite>
              </a>
              <dl class="layui-nav-child">
                @if(in_array('用户列表',$per))
                <dd>
                  <a lay-href="user/list">用户列表</a>
                </dd>
                @endif
                @if(in_array('商家列表',$per))
                <dd>
                  <a lay-href="user/seller-list">商家列表</a>
                </dd>
                @endif
                @if (in_array('实名认证',$per))
                <dd>
                  <a lay-href="user/true-name">实名认证</a>
                </dd>
                @endif
                @if (in_array('报修售后列表',$per))
                <dd>
                  <a lay-href="user/after-sale-list">报修售后列表</a>
                </dd>
                @endif
                @if (in_array('用户美图',$per))
                <dd>
                  <a lay-href="user/dynamic-list">用户美图</a>
                </dd>
                @endif

                @if (in_array('用户协议',$per))
                <dd>
                  <a lay-href="user/protocol">用户协议</a>
                </dd>
                @endif
              </dl>
            </li>
            @endif

            @if(in_array('后台帐号',$per) || in_array('角色管理',$per) || in_array('权限管理',$per))
            <li data-name="user" class="layui-nav-item">
              <a href="javascript:;" lay-tips="后台帐号管理" lay-direction="2">
                <i class="layui-icon layui-icon-user"></i>
                <cite>后台帐号管理</cite>
              </a>
              <dl class="layui-nav-child">
                @if(in_array('后台帐号',$per))
                <dd>
                  <a lay-href="admin/account">后台帐号</a>
                </dd>
                @endif
                @if(in_array('角色管理',$per))
                <dd>
                  <a lay-href="admin/role">角色管理</a>
                </dd>
                @endif

                @if( in_array('权限管理',$per))
                <dd>
                  <a lay-href="admin/power">权限管理</a>
                </dd>
                @endif
              </dl>
            </li>
            @endif
            @if(in_array('产品库',$per) || in_array('套餐管理',$per))
            <li data-name="template" class="layui-nav-item">
              <a href="javascript:;" lay-tips="产品管理" lay-direction="2">
                <i class="layui-icon layui-icon-app"></i>
                <cite>产品管理</cite>
              </a>
              <dl class="layui-nav-child">
                @if(in_array('产品库',$per))
                <dd><a lay-href="goods/list">产品库</a></dd>
                @endif
                @if( in_array('套餐管理',$per))
                <dd><a lay-href="goods/grouplist">套餐管理</a></dd>
                @endif
              </dl>
            </li>
            @endif

      
            @if(in_array('轮播图',$per) || in_array('案例和资讯',$per) || in_array('案例标签',$per) || in_array('合同列表',$per))
            <li data-name="template" class="layui-nav-item">
              <a href="javascript:;" lay-tips="内容管理" lay-direction="2">
                <i class="layui-icon layui-icon-template"></i>
                <cite>内容管理</cite>
              </a>
              <dl class="layui-nav-child">
                @if(in_array('轮播图',$per))
                <dd><a lay-href="content/rotation-chart">轮播图</a></dd>
                @endif
                @if(in_array('案例和资讯',$per))
                <dd><a lay-href="content/case-info-list">案例和资讯</a></dd>
                @endif
                @if( in_array('案例标签',$per))
                <dd><a lay-href="content/case-tag">案例标签</a></dd>
                @endif
                @if(in_array('合同列表',$per))
                <dd><a lay-href="content/contract-list">合同列表</a></dd>
                @endif
              </dl>
            </li>
            @endif
            @if(in_array('工程订单',$per) || in_array('客户订单',$per) || in_array('智能设计',$per))
            <li data-name="template" class="layui-nav-item">
              <a href="javascript:;" lay-tips="工程管理" lay-direction="2">
                <i class="layui-icon layui-icon-template"></i>
                <cite>工程管理</cite>
              </a>
              <dl class="layui-nav-child">
                @if(in_array('工程订单',$per))
                <dd><a lay-href="build/list">工程订单</a></dd>
                @endif
                @if(in_array('客户订单',$per))
                <dd><a lay-href="build/owner-order-list">客户订单</a></dd>
                @endif
                @if(in_array('积分参数',$per))
                <dd><a lay-href="build/integral">积分参数</a></dd>
                @endif
                @if(in_array('智能设计',$per))
                <dd><a lay-href="build/design-list">智能设计</a></dd>
                @endif
                @if(in_array('积分兑换',$per))
                <dd><a lay-href="build/integral-exchange">积分兑换</a></dd>
                @endif
              </dl>
            </li>
            @endif
            @if(in_array('户型列表',$per) || in_array('类型列表',$per))
            <li data-name="template" class="layui-nav-item">
              <a href="javascript:;" lay-tips="表单管理" lay-direction="2">
                <i class="layui-icon layui-icon-template"></i>
                <cite>表单管理</cite>
              </a>
              <dl class="layui-nav-child">
                @if(in_array('户型列表',$per))
                <dd><a lay-href="form/house-type">户型列表</a></dd>
                @endif
                @if(in_array('类型列表',$per))
                <dd><a lay-href="form/goods-type">类型列表</a></dd>
                @endif
              </dl>
            </li>
            @endif
        


          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
     
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="" lay-attr="" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
     
      </div>


      <!-- 主体内容 -->
     
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
           <iframe src="" frameborder="0" class="layadmin-iframe"></iframe> 
        </div>
      </div>
     
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>

  <script src="/layuiadmin/layui/layui.js"></script>
  <script>
  layui.config({
    base: '/layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index']),function(){



  };
  </script>
</body>
</html>


