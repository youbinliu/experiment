<div style="width: 320px; margin: 0 auto;">
   <h3>登陆</h3>
   <? if (!empty($error)): ?>
      <div class="alert alert-error">
         <b>错误!</b> <?= $error ?>
      </div>
   <? elseif (!empty($info)): ?>
      <div class="alert alert-info">
         <b>信息.</b> <?= $info ?>
      </div>
   <? endif; ?>
   <form class="well" method="POST" action="<?php echo base_url("/home/dologin") ?>">
      <label>用户名</label>
      <input type="text" name="username" style="width: 260px;" >
      <label>密码</label>
      <input type="password" name="password" style="width: 260px;">
      <button type="submit" class="btn btn-primary">登陆</button>
      <a href="<?php echo base_url("/home/register") ?>" class="font-12">没有账号？注册</a>
   </form>
</div>
