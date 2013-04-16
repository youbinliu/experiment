 <!-- Begin page content --> 
<div class="row" style="text-align:left;padding-top:50px">
	<?php $this->load->view('templates/relative_side');?>
 	<?php if ( !empty($experiment) ): ?>
		<div class="contaniner page-header span10" style="background-color: #dceaf4;padding: 10px;">
    		<h4>实验题目：<?php echo $experiment->title;?></h4>
    		<!-- JiaThis Button BEGIN -->
			<div class="jiathis_style">
				<span class="jiathis_txt">分享到：</span>
				<a class="jiathis_button_qzone">QQ空间</a>
				<a class="jiathis_button_tsina">新浪微博</a>
				<a class="jiathis_button_tqq">腾讯微博</a>
				<a class="jiathis_button_renren">人人网</a>
				<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
				<a class="jiathis_counter_style"></a>
			</div>
			<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1358558647891616" charset="utf-8"></script>
			<!-- JiaThis Button END -->
			<br>
			<i class="icon-star"></i> 实验评分 ：
    			<?php if(!empty($score)):?>
    				<div id="demo1" style="display:inline">
    				</div><script type="text/javascript">
    					$("#demo1").rater({active:false,maxvalue:10,curvalue:<?php echo $score;?>,style:'inline-normal'});
    				</script>
    			<?php else:?>
    				<p style="display: inline">没有用户评分</p>	
    			<?php endif;?>
    			<?php if(empty($user_in)):?>
    				<?php $this->load->view('templates/rater');?>
    			<?php endif;?>
    			<br>
    		<i class="icon-tag"></i> 实验类型 ：<?php echo $experiment->type;?><br>
    		<?php if ( !empty($experiment->keywords) ): ?>
    		<i class="icon-book"></i> 关键字：<?php echo $experiment->keywords;?><br>
    		<?php endif; ?>
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
    	<?php endif; ?>
    	
</div>
	</div>
</div>
