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
					<form method="post" action="<?php echo base_url("/resource/showclusterlist");?>"> 
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
				<?php if(!empty($cluster_list)):
					foreach ($cluster_list as $id=>$cluster){
						echo '<div class="contaniner page-header" style="background-color: #dceaf4;padding: 10px;">';
						echo '<h4>'.$experiment_list[$cluster['exp_id']].' (集群编号-'.$id.') </h4>';
						echo '<i class="icon-time"></i>创建时间： '?><?php if(!empty($cluster['start_time'])) echo $cluster['start_time']; ?><?php echo ' ';
						echo '<i class="icon-refresh"></i> <span style="color:green"> 状态：'?><?php if(!empty($cluster['status'])) echo $cluster['status']; ?><?php echo '</span>';
						echo '<BR>';
						echo '<i class="icon-filter"></i> 主cpu：'.$cluster['master_vcpu'].' ';
						echo '<i class="icon-filter"></i> 从cpu：'.$cluster['slave_vcpu'].' ';
						echo '<i class="  icon-hdd"></i> 主内存 ：'.$cluster['master_mem'].' ';
						echo '<i class="  icon-hdd"></i> 从内存 ：'.$cluster['slave_mem'].' ';
						echo '<i class="icon-leaf"></i> 从节点数 ：'.$cluster['slave_count'].' ';
						echo '<BR>';       
						echo '<i class="icon-align-left"></i>主节点ipv6：'?><?php if(!empty($cluster['master_ipv6'])) echo $cluster['master_ipv6']; ?><?php echo ' ';
						echo '<i class="icon-remove"></i><a href="'.base_url("/resource/deletecluster").'/'.$id.'" data-confirm="确定删除该虚拟集群？"> 删除虚拟机群 </a>';
						echo '<i class="icon-download"></i><a href="'.base_url("/resource/downloadclusterkey").'/'.$id.'"> 主节点ssh-key </a>';
						echo '</div>';
					}
				endif; ?>
			</div>
      	
		</div>
	</div>
</div>