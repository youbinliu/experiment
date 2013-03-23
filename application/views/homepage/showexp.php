 <!-- Begin page content --> 
<div class="row" style="text-align:left;padding-left:300px;padding-top:50px">

 	<?php if ( !empty($experiment) ): ?>
		<div class="contaniner page-header span10" style="background-color: #dceaf4;padding: 10px;">
    		<h4>实验题目：<?php echo $experiment->title;?></h4>
    		<i class="icon-tag"></i> 实验类型 ：<?php echo $experiment->type;?><br>
    		<i class="icon-user"></i> 创建用户 ：<?php echo $experiment->username;?> 		
    		<i class="icon-time"></i> 开始时间： <?php echo $experiment->start_time;?><br>   
    		<i class="icon-wrench"></i> 使用工具：<?php if( !empty($experiment->tools) ) echo $experiment->tools;?><br>
    		<i class="icon-globe"></i> 相关论文：<?php if(!empty($experiment->papers)) echo $experiment->papers;?><br>
    		<i class="icon-file"></i>实验描述和结果
    		<br><div class="span10"> <?php echo $experiment->describe;?></div><br>
    		<br><div class="span10">
    		
    		<?php if(!empty($experiment->result)) echo $experiment->result;?></div><br>
    		<br><div class="span10">
    		
    		</div>
    	</div>
    	<?php 
    endif; ?>
    
</div>
	</div>
</div>
