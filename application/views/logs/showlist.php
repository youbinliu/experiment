 <!-- Begin page content --> 
      <div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_logs');?>
      		
      		<div class="span9"> 
      			<div class="container" style="height: 20px;margin-top: 30px;"> 
    	  			<form method="post" action="/search"> 
	          			<div class="input-prepend input-append" id="searchwrap">          				 
							<span class="add-on">选择实验</span> 
							<select class="span5" style="width:300px;">
					                <option>XXXXXX实验标题</option>
					                <option>aaaaaa实验标题</option>
					      </select>
							<button class="btn btn-primary" type="submit">筛选</button> 
						</div> 
					</form> 
				</div>
    	  		<?php for($i = 0;$i<10;$i++){?>
                        <div class="contaniner page-header"> 
	        				<h4>重大研究成果</h4> 
	    					<i class="icon-tag"></i> xxx实验<br> 
	    					<i class="icon-time"></i>2013-03-05 12:13<br>
	    					 <i class="icon-home"></i> 
	    					<a href="<?php echo base_url("exp/show/1")?>">详细</a>  
	    					<i class="icon-edit"></i> 
	    					<a href="<?php echo base_url("exp/edit/1")?>">编辑</a>  
	    					<i class=" icon-remove"></i>
	    					<a href="<?php echo base_url("exp/delete/1")?>">删除</a>	    					
	    					<br> 
	    					
	    					<i class="icon-file"></i>
	    					详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯详细内容嘛....就是这些咯
	    					</div> 
                     <?php } ?>
                     
		  </div>
      	
        </div>
      </div>
</div>