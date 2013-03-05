<? if (!empty($error)): ?>
      <div class="alert alert-error">
         <b>错误!</b> <?= $error ?>
      </div>
   <? elseif (!empty($info)): ?>
      <div class="alert alert-info">
         <b>提示.</b> <?= $info ?>
      </div>
   <? endif; ?>
   <form class="well" method="POST" action="<?php if($action == "add")echo base_url("logs/doadd");else echo  base_url("logs/doedit");?>">
      
      <label>选择实验</label>
      <select class="span5">
                <option>云计算XXXXXX实验</option>
                <option>高性能计算XXXXXX实验</option>
                <option>图像处理XXXXXX实验</option>
                <option>等等</option>
      </select>
      <label>日记标题</label>
      <input type="text" name="name" style="width: 40%;">
      <label>日记内容</label>
      <textarea rows="5"  style="width: 40%"></textarea>
      
      <label></label>
      <button type="submit" class="btn btn-primary">确定</button>
   </form>