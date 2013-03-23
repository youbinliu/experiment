<div class="span3 bs-docs-sidebar"> 
	<ul class="nav nav-list bs-docs-sidenav"> 
		<li <?php if($sidebar == "info")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/info"); ?>"><i class="icon-chevron-right"></i>资源统计</a></li> 
	 
		<li <?php if($sidebar == "add")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/add"); ?>"><i class="icon-chevron-right"></i>新建虚拟机</a></li> 
	 
		<li <?php if($sidebar == "showlist")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/showlist") ;?>"><i class="icon-chevron-right"></i>所有虚拟机</a></li> 
	 	
	 	<li <?php if($sidebar == "addcluster")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/addcluster"); ?>"><i class="icon-chevron-right"></i>新建虚拟机群</a></li> 
	 
		<li <?php if($sidebar == "allcluster")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/showclusterlist") ;?>"><i class="icon-chevron-right"></i>所有虚拟机群</a></li> 
	 
		<li <?php if($sidebar == "keylist")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/keylist") ;?>"><i class="icon-chevron-right"></i>查看密钥</a></li> 
	  	
		<li <?php if($sidebar == "createkey")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/createkey"); ?>"><i class="icon-chevron-right"></i>创建密钥</a></li> 

		<li <?php if($sidebar == "imagelist")echo 'class="active"'; ?>><a href="<?php echo base_url("resource/imagelist"); ?>"><i class="icon-chevron-right"></i>实验环境</a></li> 
	</ul> 
</div> 