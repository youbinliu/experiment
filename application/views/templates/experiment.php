<?php if (!empty($error)): ?>
      <div class="alert alert-error">
         <b>错误!</b> <?php echo $error ?>
      </div>
   <?php elseif (!empty($info)): ?>
      <div class="alert alert-info">
         <b>提示.</b> <?php echo $info ?>
      </div>
   <?php endif; ?>
   <form class="well" method="POST" action="<?php if($action == "add")echo base_url("/exp/doadd");else echo  base_url("/exp/doedit");?><?php if(!empty($default['id'])) echo '/'.$default['id']; ?>">
      <label>科研题目</label>
      <?php echo form_error('experiment_title'); ?>
      <input type="text" <?php if(!empty($default['title'])) echo 'value='.$default['title']; ?> name="experiment_title" style="width: 40%;">
      <label>科研分类</label>
      <?php echo form_error('experiment_type'); ?>
      <select name="experiment_type" class="span5">
            <?php if (!empty($experiment_type)):
    	  		    foreach ( $experiment_type as $id=>$type){
                        echo '<option value='.$id;?>
                        <?php if( !empty($default['type_id']) && $id==$default['type_id'] ) echo "selected='selected'"; ?>
                        <?php echo '>'.$type.'</option>';
    	  		    }
            endif; ?>
      </select>
      <label>关键词<label class="label label-info">（每个关键词用","分开，小于40个字符）</label></label>
      <input type="text" <?php if(!empty($default['keywords'])) echo 'value='.$default['keywords']; ?> name="experiment_keyword" style="width: 40%;" maxlength="40">
      
      <label>实验描述</label>
      <?php echo form_error('experiment_describe'); ?>
      <div>
      <textarea name="experiment_describe" id="experiment_describe" ><?php if(!empty($default['describe'])) echo $default['describe']; ?></textarea>
     
      
      <script type="text/javascript">
	      UE.getEditor('experiment_describe', {
	          wordCount:false, //关闭字数统计
	          elementPathEnabled:false//关闭elementPath
	      });
  	  </script>
      </div>
      <div <?php if(!empty($extra_not_show)) echo 'style="display: none"'; ?>>
      <label>实验工具</label>
      <?php echo form_error('experiment_tools'); ?>
      <textarea name="experiment_tools" rows="2" style="width: 40%"><?php if(!empty($default['tools'])) echo $default['tools']; ?></textarea>
      
      <label>实验结果</label>
      <?php echo form_error('experiment_result'); ?>
      <textarea name="experiment_result" id="experiment_result" rows="3" style="width: 40%"><?php if(!empty($default['result'])) echo $default['result']; ?></textarea>
      <script type="text/javascript">
	      UE.getEditor('experiment_result', {
	          wordCount:false, //关闭字数统计
	          elementPathEnabled:false//关闭elementPath
	      });
  	  </script>
	  <label>实验论文</label>
      <?php echo form_error('experiment_papers'); ?>
      <textarea name="experiment_papers" rows="4" style="width: 40%"><?php if(!empty($default['papers'])) echo $default['papers']; ?></textarea>
      </div>
      
      <label>实验状态</label>
      <?php echo form_error('experiment_status'); ?>
       <select name="experiment_status" class="span5">
                <option <?php if(!empty($default['status']) && 'New'==$default['status']) echo "selected='selected'"; ?> value="New">新建</option>
                <option <?php if(!empty($default['status']) && 'Pause'==$default['status']) echo "selected='selected'"; ?> value="Pause">搁置</option>
                <option <?php if(!empty($default['status']) && 'Done'==$default['status']) echo "selected='selected'"; ?> value="Done">已完成</option>                
      </select>
      <label></label>
      <input type="hidden" <?php if(!empty($default['id'])) echo 'value='.$default['id']; ?> name="experiment_id" style="width: 40%;">
      <button type="submit" <?php if(!empty($disabled) && in_array('button',$disabled)) echo "disabled"; ?> class="btn btn-primary">确定</button>
   </form>