 <div class="row" style="text-align:left;padding-left:300px">
 <!-- Begin page content --> 
 	<?php if ( !empty($experiment_list) ):
		foreach ( $experiment_list as $id=>$experiment){?>
		<div class="contaniner page-header span10" style="background-color: #dceaf4;padding: 10px;">
    		<h4><a  href="<?php echo base_url("home/show/".$id)?>"><?php echo $experiment['title'];?></a></h4>
    		<i class="icon-tag"></i> <?php echo $experiment['type'];?><br>
    		<i class="icon-user"></i> <?php echo $experiment['username'];?> 		
    		<i class="icon-time"></i> <?php echo $experiment['start_time'];?><br>   
    		<i class="icon-file"></i>实验描述：<br>
    		<div  style="background-color: #dceaf4;">  			
    			 <?php echo substr($experiment['describe'],0,400);?>
    		</div>
    	</div>
    	<?php }
    	
    endif; ?>
    
</div>
	</div>
</div>
