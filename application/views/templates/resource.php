	<?php if (!empty($error)): ?>
	<div class="alert alert-error">
		<b>错误!</b> <?php echo $error ?>
	</div>
	<?php elseif (!empty($info)): ?>
	<div class="alert alert-info">
		<b>提示.</b> <?php echo $info ?>
	</div>
	<?php endif; ?>
	<form class="well" method="POST" action="<?php echo base_url("/resource/doadd");?>">
	<label>所属实验</label>
	<?php echo form_error('vm_eid'); ?>   
	<select name="vm_eid" class="span5">
	<?php if(!empty($experiment_list)):
		foreach ($experiment_list as $id=>$title){
			echo '<option '?><?php if(!empty($eid) && $eid==$id) echo "selected='selected'" ;?><?php echo 'value="'.$id.'">'.$title.'</option>';
		}
	endif;?>
	</select>
      
	<label>镜像选择</label>
	<?php echo form_error('vm_image'); ?>
	<select name="vm_image" class="span5">
	<?php if(!empty($image_list)):
		foreach ($image_list as $image){
			echo '<option value="'.$image.'">'.$image.'</option>';
		}
	endif;?>
	</select>
      
	<label>密钥选择</label>
	<?php echo form_error('vm_key'); ?>
	<select name="vm_key" class="span5">
	<?php if(!empty($key_list)):
		foreach ($key_list as $key){
			echo '<option value="'.$key.'">'.$key.'</option>';
		}
	endif;?>
	</select>
      
	<label>vcpu个数</label>
	<select name="vm_cpu" class="span5">
		<option>1</option>
		<option>2</option>
	</select>
      
	<label>内存</label>
	<select name="vm_memory" class="span5">
		<option value="256">256M</option>
		<option value="512">512M</option>
		<option value="1024">1024M</option>
	</select>
      
	<label>虚拟机数量</label>
	<?php echo form_error('vm_count'); ?>
	<input name="vm_count" type="text" style="width: 40%;">
      
	<label></label>
<!--       <button type="submit" class="btn btn-primary">确定</button> -->
	<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary">确定</button>
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hedden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">确认</h3>
		</div>
		<div class="modal-body">
			<p>确认添加虚拟机？</p>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary">确定</button>
			<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
	</div>
	</form>