	<?php if (!empty($error)): ?>
	<div class="alert alert-error">
		<b>错误!</b> <?php echo $error ?>
	</div>
	<?php elseif (!empty($info)): ?>
	<div class="alert alert-info">
		<b>提示.</b> <?php echo $info ?>
	</div>
	<?php endif; ?>
	<form class="well" method="POST" action="<?php echo base_url("/resource/doaddcluster");?>">
	<label>所属实验</label>
	<?php echo form_error('cluster_eid'); ?>   
	<select name="cluser_eid" class="span5">
	<?php if(!empty($experiment_list)):
		foreach ($experiment_list as $id=>$title){
			echo '<option '?><?php if(!empty($eid) && $eid==$id) echo "selected='selected'" ;?><?php echo 'value="'.$id.'">'.$title.'</option>';
		}
	endif;?>
	</select>
      
	<label>镜像选择</label>
	<?php echo form_error('cluster_template'); ?>
	<select name='cluster_template' class="span5">
	<?php if(!empty($cluster_template)):
		foreach ($cluster_template as $id=>$template){
			echo '<option '?><?php echo 'value="'.$id.'">'.$template['name'].'</option>';
		}
	endif;?>
	</select>
      
	<label>主节点cpu个数</label>
	<select name="master_cpu" class="span5">
		<option>2</option>
		<option>4</option>
	</select>
      
	<label>主节点内存</label>
	<select name="master_mem" class="span5">
		<option value="512">512M</option>
		<option value="1024">1024M</option>
	</select>
      
	<label>从节点cpu个数</label>
	<select name="slave_cpu" class="span5">
		<option>2</option>
		<option>4</option>
		<option>8</option>
	</select>
      
	<label>从节点内存</label>
	<select name="slave_mem" class="span5">
		<option value="512">512M</option>
		<option value="1024">1024M</option>
	</select>
      
	<label>从节点虚拟机数量</label>
	<?php echo form_error('cluster_slave_count'); ?>
	<input type="text" name="cluster_slave_count" style="width: 40%;">
      
	<label></label>
	<!-- <button type="submit" class="btn btn-primary">确定</button> -->
      
	<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary">确定</button>
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hedden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">确认</h3>
		</div>
		<div class="modal-body">
			<p>确认添加虚拟集群？</p>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary">确定</button>
			<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
	</div>
      
	</form>