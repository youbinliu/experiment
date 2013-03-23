
<!-- Begin page content -->
<div class="container-fluid">
 
<div class="row-fluid">
			<?php $this->load->view('templates/sidebar_res');?>
      		
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
				     			
				<?php if(!empty($image_list)):
					foreach ($image_list as $image){
						$id = $image['template_id'];
						echo '<div class="contaniner page-header">';
						echo '<h4>实验环境名称：'.$image['template_name'].'</h4>';
						echo '<i class="icon-time"></i> 注册时间： '.$image['regtime'].' ';
						echo '<i class="icon-refresh"></i> <span style="color:green"> 状态：'.$image['stat'].'</span><br>';
						echo '<i class="icon-filter"></i> <span style="color:green">是否公开：'.$image['public'].'</span> ';
						echo '<i class="icon-leaf"></i> 运行虚拟机数 ：'.$image['vms'].'<br>';
						echo '<i class="icon-plus"></i><a href="'?><?php echo base_url("/resource/imageaction/public").'/'.$id ;?><?php echo '" data-confirm="确定公开模板？"> 公开模板 </a>';
						echo '<i class="icon-minus"></i><a href="'?><?php echo base_url("/resource/imageaction/unpublic").'/'.$id ;?><?php echo '" data-confirm="确定私有模板？"> 私有模板 </a>';
						echo '<i class="icon-ok-circle"></i><a href="'?><?php echo base_url("/resource/imageaction/enable").'/'.$id ;?><?php echo '" data-confirm="确定启用模板？"> 启用模板 </a>';
						echo '<i class="icon-ban-circle"></i><a href="'?><?php echo base_url("/resource/imageaction/unable").'/'.$id ;?><?php echo '" data-confirm="确定禁用模板？"> 禁用模板 </a>';
						echo '<i class="icon-remove"></i><a href="'?><?php echo base_url("/resource/imageaction/remove").'/'.$id ;?><?php echo '" data-confirm="此操作会删除该实验环境！<br>确定执行？"> 删除模板 </a>';
						echo '</div>';
					}
				endif; ?>
			</div>
      	
		</div>
	</div>
</div>