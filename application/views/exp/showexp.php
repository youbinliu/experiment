 <!-- Begin page content --> 
<div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_exp');?>
      		
      		<div class="span9" style="margin-top: 30px"> 
			<?php if ( !empty($experiment) ): ?>
				<div class="contaniner page-header">
    			<h4>实验题目：<?php echo $experiment->title;?></h4>
    			<i class="icon-tag"></i> 实验类型 ：<?php echo $experiment->type;?><br>
    			<i class="icon-user"></i> 创建用户 ：<?php echo $experiment->username;?> 		
    			<i class="icon-time"></i> 开始时间： <?php echo $experiment->start_time;?><br>   
    			<i class="icon-file"></i> 实验描述： <?php echo $experiment->describe;?><br>
    			<i class="icon-wrench"></i> 使用工具：<?php if( !empty($experiment->tools) ) echo $experiment->tools;?><br>
    			<i class="icon-briefcase"></i> 实验结果：<?php if(!empty($experiment->result)) echo $experiment->result;?><br>
    			<i class="icon-globe"></i> 相关论文：<?php if(!empty($experiment->papers)) echo $experiment->papers;?>
    			</div>
    		<?php endif; ?>
    		</div>
      </div>
</div>