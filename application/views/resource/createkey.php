 <!-- Begin page content --> 
<div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_res');?>
      		
      		<div class="span9" style="margin-top: 30px"> 
    	  	     <? if (!empty($error)): ?>
			      <div class="alert alert-error">
			         <b>错误!</b> <?= $error ?>
			      </div>
			   <? elseif (!empty($info)): ?>
			      <div class="alert alert-info">
			         <b>提示.</b> <?= $info ?>
			      </div>
			   <? endif; ?>
			   <form class="well" method="POST" action="<?php echo base_url("/resource/docreatekey");?>">
			     
			      <label>key名</label>
			      <input type="text" name="name" style="width: 40%;">
			      
			      <label></label>
			      <button type="submit" class="btn btn-primary">确定</button>
			   </form>
        	</div>
      </div>
</div>