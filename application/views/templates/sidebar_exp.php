<div class="span3 bs-docs-sidebar"> 
	<ul class="nav nav-list bs-docs-sidenav"> 
	  		 
		<li <?php if($sidebar == "add")echo 'class="active"'; ?>><a href="<?php echo base_url("exp/add"); ?>"><i class="icon-chevron-right"></i>新建实验</a></li> 
	 
		<li <?php if($sidebar == "all")echo 'class="active"'; ?>><a href="<?php echo base_url("exp/showlist/all") ;?>"><i class="icon-chevron-right"></i>所有实验</a></li> 
	 
		<li <?php if($sidebar == "finished")echo 'class="active"'; ?>><a href="<?php echo base_url("exp/showlist/finished") ;?>"><i class="icon-chevron-right"></i>已完成的实验</a></li> 
	  	
	  	<li <?php if($sidebar == "unfinished")echo 'class="active"'; ?>><a href="<?php echo base_url("exp/showlist/unfinished"); ?>"><i class="icon-chevron-right"></i>未完成的实验</a></li> 
	   
	</ul> 
</div> 