 <!-- Begin page content --> 
<div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_exa');?>
      		
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
      			<div class="container" style="height: 20px;margin-top: 30px;"> 
    	  			<form method="post" action="<?php echo base_url("/example/joblist");?>"> 
	          			<div class="input-prepend input-append" id="searchwrap">          				 
							<span class="add-on">选择实验</span> 
							<select name="experiment_id" class="span5" style="width:300px;">
                                  <?php if(!empty($experiment_list)):
                                      foreach ($experiment_list as $id=>$title){
                                          echo '<option '?><?php if(!empty($eid) && $eid==$id) echo "selected='selected'" ;?><?php echo 'value="'.$id.'">'.$title.'</option>';
                                      }
                                  endif;?>
					      </select>
							<button class="btn btn-primary" type="submit">筛选</button>
						</div>
					</form>
				</div>
					<?php if(!empty($jobs_list)):
					    foreach ($jobs_list as $id=>$job){
					        echo '<div class="contaniner page-header">';
					        echo '<h4>'.$job['exptitle'].' </h4>';
					        echo '<i class="icon-filter"></i><b> 输入文件：</b>'.$job['input'].'<br>';
					        echo '<i class="icon-tag"></i>执行命令：'.$job['command'].'<br>';
					        echo '<i class="icon-time"></i>开始时间：'.$job['start_time'];
					        echo '<i class="icon-time"></i>结束时间：'.$job['end_time'].'<br>';
					        echo '<i class="icon-refresh"></i> <span style="color:green">'.$job['state'].'</span>';
					        echo '<i class="icon-remove"></i><a href="'.base_url("example/delete/".$id).'" data-confirm="确定删除该模板作业？"> 删除模板作业 </a>';
					        echo '<i class="icon-download"></i><a href="'.base_url("example/download_result/".$id).'"> 结果下载</a>';
					        echo '</div>';
					    }
					endif; ?>
      	
        	</div>
      </div>
</div>