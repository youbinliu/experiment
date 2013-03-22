 <!-- Begin page content --> 
      <div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_exa');?>
      		
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
          	    	<?php if(!empty($template_list)):
					    foreach ($template_list as $id=>$template){
					        echo '<div class="contaniner page-header">';
					        echo '<h4>'.$template['name'].'</h4>';
					        echo '<i class="icon-filter"></i><b> VCPU个数：'.$template['cpu'].'</b>';
					        echo '<i class="icon-hdd"></i> <b>内存：'.$template['memory'].'</b>';
					        echo '<i class="icon-hdd"></i><b> 磁盘 ：'.$template['storage'].'</b>';
					        echo '<i class="icon-wrench"></i>';
					        echo '<a href="';?><?php echo base_url("example/add");?><?php echo '/'.$id.'">使用</a>';
					        echo '<BR>';
					        echo '<i class="icon-file"></i>'.$template['description'];
					        echo '</div>';
					    }
					endif; ?>

		  </div>
      	
        </div>
      </div>
</div>