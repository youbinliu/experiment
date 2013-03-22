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
				<div class="container" style="height: 20px;margin-top: 30px;"> 
					<form method="post" action="<?php echo base_url("/resource/showlist");?>"> 
						<div class="input-prepend input-append" id="searchwrap">          				 
							<span class="add-on">选择实验</span> 
							<select name="experiment_id" class="span5" style="width:300px;">
								<?php if(!empty($experiment_list)):
										foreach ($experiment_list as $id=>$title){
											echo '<option '?><?php if(!empty($eid) && $eid==$id) echo "selected='selected'" ;?><?php echo 'value="'.$id.'">'.$title.'</option>';
										}
								endif;?>
							</select>
							<button class="btn btn-primary" type="submit">筛选</button>
						</div>
					</form>
				</div>
				<?php if(!empty($vms_list)):
					foreach ($vms_list as $id=>$vm){
						echo '<div class="contaniner page-header">';
						echo '<h4>'.$experiment_list[$vm['exp_id']].' (one-'.$id.') </h4>';
						echo '<a href="javascript:;" class="a_info"'?><?php echo 'id="getvmdetail&'.$id.'"><span id="getvmdetail&'.$id.'">显示/刷新访问信息</span></a>';
						echo '<BR>';
						echo '<i class="icon-time"></i>创建时间： '?><?php if(!empty($vm['start_time'])) echo $vm['start_time']; ?><?php echo ' ';
						echo '<i class="icon-refresh"></i> <span style="color:green"> 状态：'?><?php if(!empty($vm['status'])) echo $vm['status']; ?><?php echo '</span>';
						echo '<BR>';
						echo '<i class="icon-filter"></i> VCPU：'.$vm['vcpu'].' ';
						echo '<i class="  icon-hdd"></i> 内存 ：'.$vm['memory'].' ';
						echo '<i class="icon-leaf"></i> 镜像 ：'.$vm['image'].' ';
						echo '<BR>';
						echo '<div style="display:none;" id="showvmdetail'?><?php echo $id.'">';        
						echo '<i class="icon-align-left"></i> 地址：<span id="vmdns'.$id.'">'?><?php if(!empty($vm['dns'])) echo $vm['dns']; ?><?php echo ' </span>';
						echo '<i class="icon-align-right"></i> 端口：<span id="vmport'.$id.'">'?><?php if(!empty($vm['port'])) echo $vm['port']; ?><?php echo ' </span>';
						echo '<i class="icon-tag"></i> 密钥：'?><?php if(!empty($vm['key'])) echo $vm['key']; ?><?php echo ' ';
						echo '<i class=" icon-map-marker"></i> ipv6：<span id="vmipv6'.$id.'">'?><?php if(!empty($vm['ipv6'])) echo $vm['ipv6']; ?><?php echo ' </span>';
						echo '<BR>';
						echo '</div>';
						echo '<i class="icon-play"></i><a href="'?><?php echo base_url("/resource/vmaction/resume").'/'.$id ;?><?php echo '" data-confirm="确定执行操作resume？"> resume </a>';
						echo '<i class="icon-pause"></i><a href="'?><?php echo base_url("/resource/vmaction/stop").'/'.$id ;?><?php echo '" data-confirm="确定执行操作stop？"> stop </a>';
						echo '<i class=" icon-stop"></i><a href="'?><?php echo base_url("/resource/vmaction/shutdown").'/'.$id ;?><?php echo '" data-confirm="此操作会删除该虚拟机！<br>确定执行？"> shutdown </a>';
				        //echo '<i class=" icon-ok-sign"></i><a href=""> save image </a>';
						echo '</div>';
					}
				endif; ?>
			</div>
      	
		</div>
	</div>
</div>