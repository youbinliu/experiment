 <!-- Begin page content --> 
      <div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_exp');?>
      		
      		<div class="span9"> 
      		<?php if (!empty($error)): ?>
      			<div class="alert alert-error">
         			<b>错误!</b> <?php echo $error ?>
      			</div>
            <?php elseif (!empty($info)): ?>
      			<div class="alert alert-info">
         			<b>信息.</b> <?php echo $info ?>
      			</div>
            <?php endif; ?>
    	  		<?php if (!empty($all_experiments) ):
    	  		    foreach ( $all_experiments as $id=>$experiment){
    	  		        echo '<div class="contaniner page-header" style="background-color: #dceaf4;padding: 10px;">';   
    	  		      	echo '<h4>'.$experiment['title'].'</h4>';
    	  		        echo '<i class="icon-tag"></i>'.$experiment['type'].'<br>';
    	  		        echo '<i class="icon-time"></i>'.$experiment['start_time'].'<br>';
    	  		        echo '<i class="icon-home"></i>';
    	  		        echo '<a href="'.base_url("exp/show/".$id).'">详细</a>';
    	  		        echo '<i class="icon-edit"></i>';
    	  		        echo '<a href="'.base_url("exp/edit/".$id).'">完善信息</a>';
    	  		        echo '<i class=" icon-remove"></i>';
    	  		        echo '<a href="'.base_url("exp/delete/".$id).'" expid="'.$id.'" data-confirm="该实验已释放完所有资源。 <br /> 确认删除该实验？">删除</a>';
    	  		        echo '<i class=" icon-wrench"></i>';
    	  		        echo '<a href="'.base_url("resource/filtershowlist/".$id).'">资源管理</a>';
    	  		        echo '<br>';
    	  		        echo '<div style="width:400px">'.substr($experiment['describe'],0,400).'</div><br></div>';
    	  		    }
                endif; ?>
		  </div>
<!-- 		 <a href="http://www.baidu.com" data-confirm="确认删除该实验？ <br /> 注意，删除实验前请删除该实验所申请的所有资源，否则会导致删除错误！">Delete</a> -->
      	
        </div>
      </div>
</div>