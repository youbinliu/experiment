 <!-- Begin page content --> 
<div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_logs');?>
      		
      		<div class="span9" style="margin-top: 30px"> 
			<?php if ( !empty($diary) ): ?>
				<div class="contaniner page-header">
    			<h4>日记标题：<?php echo $diary['title'];?></h4>
    			<i class="icon-tag"></i> 所属实验 ：<?php echo $diary['exptitle'];?><br>	
    			<i class="icon-time"></i> 开始时间： <?php echo $diary['time'];?><br>   
    			<i class="icon-file"></i> 日志内容： <?php echo nl2br(str_replace(" ","&nbsp;",$diary['content']));?><br>
    			</div>
    		<?php endif; ?>
    		</div>
      </div>
</div>