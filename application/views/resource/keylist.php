 <!-- Begin page content --> 
<div class="container-fluid"> 
         
	<div class="row-fluid"> 
		<?php $this->load->view('templates/sidebar_res');?>
      		
		<div class="span9" style="margin-top: 30px">
			<?php if (!empty($error)): ?>
			<div class="alert alert-error">
				<b>错误!</b> <?php echo $error ?>
			</div>
			<?php elseif (!empty($info)): ?>
			<div class="alert alert-info">
				<b>信息.</b> <?php echo $info ?>
			</div>
			<?php endif; ?>
			<?php if(!empty($key_list)):
				echo '<ul>';
				foreach ($key_list as $key_item){
					echo '<li><span class="span2 text-success"><i class="icon-check"></i>'.$key_item[1].'</span>';
					echo '<button id="downloadkey&'.$key_item[0].'&'.$key_item[1].'" class="span2 btn btn-primary">Download</button>';
					echo '<button id="deletekey&'.$key_item[0].'&'.$key_item[1].'" class="span2 btn btn-warning">Delete</button></li>';
					echo '<br>';
				}
				echo '</ul>';          
			endif; ?>				
		</div>
	</div>
</div>