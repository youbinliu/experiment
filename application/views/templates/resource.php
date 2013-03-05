<? if (!empty($error)): ?>
      <div class="alert alert-error">
         <b>错误!</b> <?= $error ?>
      </div>
   <? elseif (!empty($info)): ?>
      <div class="alert alert-info">
         <b>提示.</b> <?= $info ?>
      </div>
   <? endif; ?>
   <form class="well" method="POST" action="<?php echo base_url("/resource/doadd");?>">
      <label>所属实验</label>      
      <select class="span5">
                <option>XXXXXX实验标题</option>
                <option>aaaaaa实验标题</option>
      </select>
      
      <label>镜像选择</label>
       <select class="span5">
                <option>32bit Centos 5.5</option>
                <option>64bit Centos 5.5</option>
                <option>32bit Ubuntu 11.10</option>
                <option>64bit Ubuntu 11.10</option>
      </select>
      
      <label>密钥选择</label>
       <select class="span5">
                <option>eliot</option>
                <option>other</option>
      </select>
      
      <label>vcpu个数</label>
       <select class="span5">
                <option>1</option>
                <option>2</option>
      </select>
      
      <label>内存</label>
       <select class="span5">
                <option>512M</option>
                <option>1024M</option>
                <option>2048M</option>
      </select>
      
      <label>虚拟机数量</label>
      <input type="text" name="name" style="width: 40%;">
      
      <label></label>
      <button type="submit" class="btn btn-primary">确定</button>
   </form>