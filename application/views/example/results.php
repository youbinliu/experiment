 <!-- Begin page content --> 
<div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_exa');?>
      		
      		<div class="span9"> 
    	  		
                <?php for($i = 0 ; $i<10 ; $i ++){ ?>
                        <div class="contaniner page-header"> 
	        				<h4>实验名称XXX </h4> 
	        				
	    					<i class="icon-filter"></i><b> 输入文件：xxx</b><br>
	    					
	    					<i class="icon-wrench"></i>
	    					执行指令：xxxxxxxxxxxx
	    					<br> 	    					
	    					
	    					<i class="icon-time"></i>
	    					开始时间：2013-02-12 12:23
	    					<i class="icon-time"></i>
	    					结束：2013-02-12 12:53<br>
	    					<i class="icon-refresh"></i> <span style="color:green">进行中</span>
	    					<i class="icon-download"></i>
	    					<a href="<?php echo base_url("example/download/1"); ?>"> 结果下载</a>
	    				</div> 
                     <?php } ?>
      	
        	</div>
      </div>
</div>