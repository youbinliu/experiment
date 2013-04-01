<div style="width: 320px; margin: 0 auto;">
	<h3>注册</h3>
	<?php if (!empty($error)): ?>
	<div class="alert alert-error">
		<b>错误!</b> <?php echo $error ?>
	</div>
	<?php elseif (!empty($info)): ?>
	<div class="alert alert-info">
		<b>提示.</b> <?php echo $info ?>
	</div>
	<?php endif; ?>
   
	<?php $attributes = array('class' => 'well', 'id' => 'my_register_form'); ?>
	<?php echo form_open('register/check_register', $attributes); ?>
		<label>用户名</label>
		<?php echo form_error('username');?>
		<input type="text" name="username" value="<?php echo set_value('username',''); ?>" style="width: 260px;">
		<label>密码</label>
		<?php echo form_error('password');?>
		<input type="password" name="password" value="<?php echo set_value('password'); ?>" style="width: 260px;">
		<label>重复密码</label>
		<?php echo form_error('repassword');?>
		<input type="password" name="repassword" value="<?php echo set_value('repassword'); ?>" style="width: 260px;">
		<label>邮箱</label>
		<?php echo form_error('email');?>
		<input type="text" name="email" value="<?php echo set_value('email'); ?>" style="width: 260px;">
		<label>邀请码</label>
		<?php echo form_error('invitecode');?>
		<input type="text" name="invitecode" value="<?php echo set_value('invitecode'); ?>" style="width: 260px;">
<!--       <button type="submit" class="btn btn-primary">注册</button> -->
      
		<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary">确定</button>
		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hedden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">确认</h3>
			</div>
			<div class="modal-body">
				<p>确认注册？</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary">确定</button>
				<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">关闭</button>
			</div>
		</div>
      
		<a href="<?php echo base_url("/home/show_login"); ?>" class="font-12">已注册？登陆</a>
	</form>
</div>
