 <!-- Begin page content --> 
      <div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_logs');?>
      		
      		<div class="span9">
      		<?php if (!empty($error)): ?>
      			<div class="alert alert-error">
         			<b>错误!</b> <?php echo $error ?>
      			</div>
            <?php elseif (!empty($info)): ?>
      			<div class="alert alert-info">
         			<b>信息.</b> <?php echo $info ?>
      			</div>
            <?php endif; ?>
      			<?php if(!empty($system_log['error'])) echo $system_log['error']; ?>
    	  		<?php if (!empty($system_log)):
    	  		    foreach ( $system_log as $id=>$log_list){
    	  		        echo '<div class="contaniner page-header">';   
    	  		      	echo '<h4>虚拟集群编号：'.$id.'</h4>';
    	  		      	foreach ($log_list as $log){
							echo '<p>'.$log.'</p>';
						}
    	  		    }
                endif; ?>
                     
		  </div>
      	
        </div>
      </div>
</div>