 <!-- Begin page content --> 
      <div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_res');?>
      		
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
				
    	  			<?php for($i = 0; $i <10 ;$i++){?>
                        <div class="contaniner page-header"> 
	        				<h4>实验名XXX（集群编号one-10301）</h4> 	    					
	    					<i class="icon-time"></i> 2013-03-05 12:13
	    					<i class="icon-refresh"></i> <span style="color:green">RUNNING</span>
	    					<BR>
	    					<i class="icon-filter"></i> 主cpu 2
	    					<i class="icon-filter"></i> 从cpu 2
	    					<i class="  icon-hdd"></i> 主内存 1024M
	    					<i class="  icon-hdd"></i> 从内存 1024M
	    					<i class="icon-leaf"></i> 从节点数 3	    					
	    					<br> 	    					
	    					<i class="icon-align-left"></i> ip地址：iaas.hustcloud.com
	    					<i class="icon-download"></i> <a href=""> ssh-key </a>	   
	    					<!--<br>
	    					<i class="icon-play"></i><a href=""> resume </a>	    					
	    					<i class="icon-pause"></i><a href=""> stop </a>
	    					<i class=" icon-stop"></i><a href=""> shutdown </a>
	    					-->
	    				</div> 
	    				
	    		<?php }?>
                     
                        
                     
		  </div>
      	
        </div>
      </div>
</div>