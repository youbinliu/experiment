<? if (!empty($error)): ?>
      <div class="alert alert-error">
         <b>错误!</b> <?= $error ?>
      </div>
   <? elseif (!empty($info)): ?>
      <div class="alert alert-info">
         <b>提示.</b> <?= $info ?>
      </div>
   <? endif; ?>
   <form class="well" method="POST" action="<?php if($action == "add")echo base_url("/exp/doadd");else echo  base_url("/exp/doedit");?>">
      <label>科研题目</label>
      <input type="text" name="name" style="width: 40%;">
      <label>科研分类</label>
      <select class="span5">
                <option>云计算</option>
                <option>高性能计算</option>
                <option>图像处理</option>
                <option>等等</option>
      </select>
      
      <label>实验描述</label>
      <textarea rows="5"  style="width: 40%"></textarea>
      <label>实验状态</label>
       <select class="span5">
                <option>新建</option>
                <option>搁置</option>
                <option>已完成</option>                
      </select>
      <label></label>
      <button type="submit" class="btn btn-primary">确定</button>
   </form>