<div class="span3" style="text-align:center">
	<?php if ( !empty($relativexp) ): ?>
    			
    				<h4>相关实验</h4>
    				
    				<?php foreach ($relativexp as $eid => $exp):?>
    							<a href="<?php echo base_url().$from.'/show/'.$eid;?>" style="display: inline"><?php echo $exp['title'];?></a>
    							<?php if(!empty($exp['score'])):?>
    								<p style="display: inline"><?php echo number_format($exp['score'],1)?></p>
    							<?php endif;?>
    							<br>
    				<?php endforeach;?>
    				
    				
  	<?php endif; ?>	
 </div>