 <!-- Begin page content --> 
<div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_res');?>
      		
      		<div class="span9" style="margin-top: 30px"> 
    	  	     <?php if (!empty($error)): ?>
			      <div class="alert alert-error">
			         <b>错误!</b> <?php echo $error ?>
			      </div>
			   <?php elseif (!empty($info)): ?>
			      <div class="alert alert-info">
			         <b>提示.</b> <?php echo $info ?>
			      </div>
			   <?php endif; ?>
			   <form class="well" method="POST" action="<?php echo base_url("/resource/docreatekey");?>">
			     
			      <label>密钥名</label>
			      <?php echo form_error('key_name'); ?>
			      <input type="text" name="key_name" style="width: 40%;">
			      
			      <label></label>
<!-- 			      <button type="submit" class="btn btn-primary">确定</button> -->
		<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary">确定</button>
      <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hedden="true">
      	<div class="modal-header">
      		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">确认</h3>
		</div>
      	<div class="modal-body">
      		<p>确认添加密钥？</p>
      	</div>
      	<div class="modal-footer">
      		 <button class="btn btn-primary">确定</button>
      		 <button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">关闭</button>
      	</div>
      </div>
			   </form>
        	</div>
      </div>
</div>