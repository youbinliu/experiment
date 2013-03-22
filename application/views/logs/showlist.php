 <!-- Begin page content --> 
      <div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_logs');?>
      		
      		<div class="span9"> 
      			<div class="container" style="height: 20px;margin-top: 30px;"> 
    	  			<form method="post" action="<?php echo base_url("/diary/showlist");?>"> 
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
				<?php if(!empty($all_diary) && !empty($experiment_list)):
					foreach ($all_diary as $id=>$diary){
						echo '<div class="contaniner page-header" style="background-color: #dceaf4;padding: 10px;">';
						echo '<h4>'.$diary['title'].'</h4>';
						echo '<i class="icon-tag"></i> '.$experiment_list[$diary['exp_id']].'<br>';
						echo '<i class="icon-time"></i>'.$diary['time'].'<br>';
						echo '<i class="icon-home"></i><a href="'.base_url("diary/show").'/'.$id.'">详细</a>';
						echo '<i class="icon-edit"></i><a href="'.base_url("diary/edit").'/'.$id.'">编辑</a>';
						echo '<i class="icon-remove"></i><a href="'.base_url("diary/delete").'/'.$id.'" data-confirm="确定删除该日志？">删除</a>';
						echo '<br><div style="width:400px">'.substr($diary['content'],0,400).'</div></div>';
					}
				endif; ?>
		  </div>
      	
        </div>
      </div>
</div>