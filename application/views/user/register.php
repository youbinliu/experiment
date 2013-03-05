<div style="width: 320px; margin: 0 auto;">
   <h3>注册</h3>
   <? if (!empty($error)): ?>
      <div class="alert alert-error">
         <b>错误!</b> <?= $error ?>
      </div>
   <? elseif (!empty($info)): ?>
      <div class="alert alert-info">
         <b>提示.</b> <?= $info ?>
      </div>
   <? endif; ?>
   <form class="well" method="POST" action="<?php echo(base_url("/home/doregister")); ?>">
      <label>用户名</label>
      <input type="text" name="username" style="width: 260px;">
      <label>密码</label>
      <input type="password" name="password" style="width: 260px;">
      <label>重复密码</label>
      <input type="password" name="repassword" style="width: 260px;">
      <label>邮箱</label>
      <input type="text" name="email" style="width: 260px;">
      <label>邀请码</label>
      <input type="text" name="ivitecode" style="width: 260px;">
      <button type="submit" class="btn btn-primary">注册</button>
      <a href="<?php echo base_url("/home/login"); ?>" class="font-12">已注册？登陆</a>
   </form>
</div>
