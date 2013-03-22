	<?php if (!empty($error)): ?>
	<div class="alert alert-error">
		<b>错误!</b> <?php echo $error ?>
	</div>
	<?php elseif (!empty($info)): ?>
	<div class="alert alert-info">
		<b>提示.</b> <?php echo $info ?>
      </div>
	<?php endif; ?>
   
	<form class="well" method="POST" action="<?php if($action == "add")echo base_url("diary/doadd");else echo  base_url("diary/doedit");?><?php if(!empty($default['id'])) echo '/'.$default['id']; ?>">
      
	<label>选择实验</label>
	<?php echo form_error('diary_eid'); ?>
	<select <?php if(!empty($disabled) && in_array('experiment_id',$disabled)) echo "disabled"; ?> name="diary_eid" class="span5">
	<?php if(!empty($experiment_list)):
		foreach ($experiment_list as $id=>$title){
			echo '<option '?><?php if(!empty($eid) && $eid==$id) echo "selected='selected'" ;?><?php echo 'value="'.$id.'">'.$title.'</option>';
		}
	endif;?>
	</select>
	<label>日记标题</label>
	<?php echo form_error('diary_title'); ?>
	<input type="text" <?php if(!empty($disabled) && in_array('title',$disabled)) echo "disabled"; ?> <?php if(!empty($default['title'])) echo 'value='.$default['title']; ?> name="diary_title" style="width: 40%;">

	<label>日记内容</label>
	<?php echo form_error('diary_content'); ?>
	<textarea <?php if(!empty($disabled) && in_array('content',$disabled)) echo "disabled"; ?> name="diary_content" rows="5"  style="width: 40%"><?php if(!empty($default['content'])) echo $default['content']; ?></textarea>

      
	<label></label>
	<input type="hidden" <?php if(!empty($default['id'])) echo 'value='.$default['id']; ?> name="experiment_id" style="width: 40%;">
<!--       <button type="submit" class="btn btn-primary">确定</button> -->
	<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary">确定</button>
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hedden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">确认</h3>
		</div>
		<div class="modal-body">
			<?php if($action == "add") echo '<p>确认添加日志？</p>'; else echo '<p>确认修改日志？</p>';?>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary">确定</button>
			<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">关闭</button>
		</div>
	</div>

	</form>