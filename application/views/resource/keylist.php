 <!-- Begin page content --> 
<div class="container-fluid"> 
         
	<div class="row-fluid"> 
		<?php $this->load->view('templates/sidebar_res');?>
      		
		<div class="span9" style="margin-top: 30px">
			<?php if (!empty($error)): ?>
			<div class="alert alert-error">
				<b>错误!</b> <?php echo $error ?>
			</div>
			<?php elseif (!empty($info)): ?>
			<div class="alert alert-info">
				<b>信息.</b> <?php echo $info ?>
			</div>
			<?php endif; ?>
			<form class="well" method="POST" action="<?php echo base_url("/resource/docreatekey");?>">

				<h4>输入密钥名创建密钥</h4>
				<?php echo form_error('key_name');
				?>
				<input type="text" name="key_name" style="width: 40%;">

				<label></label>
				<!-- 			      <button type="submit" class="btn btn-primary">确定</button> -->
				<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-primary">
					确定
				</button>
				<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hedden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							×
						</button>
						<h3 id="myModalLabel">确认</h3>
					</div>
					<div class="modal-body">
						<p>
							确认添加密钥？
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-primary">
							确定
						</button>
						<button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">
							关闭
						</button>
					</div>
				</div>
			</form>
			
			<div class="well">
			<h4>所有密钥</h4>
			<?php if(!empty($key_list)):
				echo '<ul>';
				foreach ($key_list as $key_item){
					echo '<li><span class="span2 text-success"><i class="icon-check"></i>'.$key_item[1].'</span>';
					echo '<button id="downloadkey&'.$key_item[0].'&'.$key_item[1].'" class="span2 btn btn-primary">下载密钥</button>';
					//echo '<button id="deletekey&'.$key_item[0].'&'.$key_item[1].'" class="span2 btn btn-warning">Delete</button></li>';
					echo '<a class="span2 btn btn-warning" href="'.base_url("resource/deleteuserkey/".$key_item[1]).'" data-confirm="确认删除该密钥？ ">删除密钥</a>';
					echo '<br><br>';
				}
				echo '</ul>';        
			endif; ?>
			</div>			
		</div>
	</div>
</div>