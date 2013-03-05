<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="#">重点学科资源云</a>
      <div class="nav-collapse collapse">
        <p class="navbar-text pull-right">
          hi <?php if(!empty($username))echo $username ;else echo "无名氏";?>
          <a href="<?php echo base_url("home/logout");?>">退出</a>
        </p>
        <ul class="nav">
          <li <?php if(!empty($menu) && $menu == "exp") echo "class='active'"; ?> ><a href="<?php echo base_url("exp/showlist/all") ?>">实验管理</a></li>
          <li <?php if(!empty($menu) &&$menu == "example") echo "class='active'"; ?> ><a href="<?php echo base_url("example/template") ?>">典型实验</a></li>
          <li <?php if(!empty($menu) &&$menu == "resource") echo "class='active'"; ?> ><a href="<?php echo base_url("resource/info") ?>">资源管理</a></li>
          <li <?php if(!empty($menu) &&$menu == "logs") echo "class='active'"; ?> ><a href="<?php echo base_url("logs/showlist") ?>">实验日志</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>