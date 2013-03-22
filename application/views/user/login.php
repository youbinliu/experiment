<div style="width: 320px; margin: 0 auto;">
	<h3>登陆</h3>
	<?php if (!empty($error)): ?>
	<div class="alert alert-error">
		<b>错误!</b> <?php echo $error ?>
	</div>
	<?php elseif (!empty($info)): ?>
	<div class="alert alert-info">
		<b>信息.</b> <?php echo $info ?>
	</div>
	<?php endif; ?>
   
	<?php $attributes = array('class' => 'well', 'id' => 'my_login_form'); ?>
	<?php echo form_open('home/login', $attributes); ?>
		<label>用户名</label>
		<?php echo form_error('login_username'); ?>
		<input type="text" name="login_username" value="<?php echo set_value('login_username'); ?>" style="width: 260px;" >
		<label>密码</label>
		<?php echo form_error('login_password'); ?>
		<input type="password" name="login_password" value="<?php echo set_value('login_password'); ?>" style="width: 260px;">
		<button type="submit" class="btn btn-primary">登陆</button>
		<a href="<?php echo base_url("register/show_register") ?>" class="font-12">没有账号？注册</a>
	</form>
</div>
