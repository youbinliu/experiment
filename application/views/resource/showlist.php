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
	        				<h4>实验名XXX（one-10301）</h4> 	    					
	    					<i class="icon-time"></i> 2013-03-05 12:13
	    					<i class="icon-refresh"></i> <span style="color:green">RUNNING</span>
	    					<BR>
	    					<i class="icon-filter"></i> VCPU 2
	    					<i class="  icon-hdd"></i> 内存 1024M
	    					<i class="icon-leaf"></i> 镜像 CentOS-5.5-x86_64	    					
	    					<br> 	    					
	    					<i class="icon-align-left"></i> 地址：iaas.hustcloud.com
	    					<i class="icon-align-right"></i> 端口：5317
	    					<i class="icon-tag"></i> 密钥 eliot
	    					<i class=" icon-map-marker"></i> ipv6：2001:250:4000:5403:0:c0ff:fea7:7
	    					<br>
	    					<i class="icon-play"></i><a href=""> resume </a>	    					
	    					<i class="icon-pause"></i><a href=""> stop </a>
	    					<i class=" icon-stop"></i><a href=""> shutdown </a>
	    					<i class=" icon-ok-sign"></i><a href=""> save image </a>
	    				</div> 
	    				
	    		<?php }?>
                     
                        
                     
		  </div>
      	
        </div>
      </div>
</div>