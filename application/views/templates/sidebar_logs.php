<div class="span3 bs-docs-sidebar"> 
	<ul class="nav nav-list bs-docs-sidenav"> 
	 
		<li <?php if($sidebar == "add")echo 'class="active"'; ?>><a href="<?php echo base_url("diary/add"); ?>"><i class="icon-chevron-right"></i>写日记</a></li> 
	 
		<li <?php if($sidebar == "showlist")echo 'class="active"'; ?>><a href="<?php echo base_url("diary/showlist") ;?>"><i class="icon-chevron-right"></i>所有日记</a></li> 
	 	
		<li <?php if($sidebar == "system")echo 'class="active"'; ?>><a href="<?php echo base_url("diary/system"); ?>"><i class="icon-chevron-right"></i>系统日志</a></li> 
	   
	</ul> 
</div> 