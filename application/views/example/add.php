 <!-- Begin page content --> 
<div class="container-fluid"> 
         
	<div class="row-fluid"> 
		<?php $this->load->view('templates/sidebar_exa');?>
	      		
		<div class="span9" style="margin-top: 30px"> 
		<?php if (!empty($error)): ?>
			<div class="alert alert-error">
				<b>错误!</b> <?php echo $error ?>
			</div>
		<?php elseif (!empty($info)): ?>
			<div class="alert alert-info">
				<b>提示.</b> <?php echo $info ?>
			</div>
		<?php endif; ?>
			<form class="well" method="POST" enctype="multipart/form-data" action="<?php echo base_url("example/doadd");?>">
				<label>所属实验</label>
				<?php echo form_error('exp_id'); ?>   
				<select name="exp_id" class="span5">
				<?php if(!empty($experiment_list)):
					foreach ($experiment_list as $id=>$title){
						echo '<option '?><?php if(!empty($eid) && $eid==$id) echo "selected='selected'" ;?><?php echo 'value="'.$id.'">'.$title.'</option>';
					}
				endif;?>
				</select>
				      
				<label>节点数量</label>
				<?php echo form_error('node_count'); ?> 
				<input type="text" name="node_count" style="width: 40%;">
				<label>作业运行命令</label>
				<?php echo form_error('command'); ?> 
				<input type="text" name="command" style="width: 40%;">
				<label>上传文件(最多上传四个文件)</label>
				<input type="file" value="file" name="userfile1"/><br>
				<input type="file" value="file" name="userfile2"/><br>
				<input type="file" value="file" name="userfile3"/><br>
				<input type="file" value="file" name="userfile4"/><br>
				<label></label>
				<input type="hidden" name="template" value="<?php echo $template_id?>" />
	<!-- 			      <button type="submit" class="btn btn-primary">确定</button> -->
				      
				<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary">确定</button>
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hedden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">确认</h3>
					</div>
					<div class="modal-body">
						<p>确认添加典型HPC模板实验？</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary">确定</button>
						<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">关闭</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>