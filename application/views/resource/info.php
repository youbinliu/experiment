 <!-- Begin page content --> 
<div class="container-fluid"> 
         
	<div class="row-fluid"> 
			<?php $this->load->view('templates/sidebar_res');?>
      		
			<div class="span9" style="margin-top: 30px">
				<div class="contaniner page-header">
					<h4>虚拟机资源概况</h4>
					<table class="table table-bordered">
						<thead>
							<tr class="warning">
								<td>虚拟机数</td>
								<td>vcpu个数</td>
								<td>CPU时间</td>
								<td>内存大小</td>
								<td>流入流量</td>
								<td>流出流量</td>
							</tr>
						</thead>
						<tbody>
							<tr class="success">
								<?php if(!empty($vm_total)) :?>
								<td><?php echo $vm_total['vm_count'].'台'; ?></td>
								<td><?php echo $vm_total['vcpu'].'个'; ?></td>
								<td><?php echo $vm_total['cpu_time'].'小时'; ?></td>
								<td><?php echo $vm_total['memory'].'M'; ?></td>
								<td><?php echo $vm_total['net_in'].'G'; ?></td>
								<td><?php echo $vm_total['net_out'].'G'; ?></td>
								<?php else :?>
	<td></td><td></td><td></td><td></td><td></td><td></td>
	<?php endif;?>
							</tr>
						</tbody>
					</table>
				</div>

      			<div class="contaniner page-header">
      			 <h4>虚拟机资源统计</h4>
      			 <a href="javascript:;" id="getvmsatistic">显示/刷新</a>
      			 <div id="show_vm_statistic_chart">
    	  	     <ul class="thumbnails">
    	  	     	<li class="span6">
    	  	     		<div class="thumbnail" id="vmcpu"></div>
    	  	     	</li>
    	  	     	<li class="span6">
    	  	     		<div class="thumbnail" id="vmmem"></div>
    	  	     	</li>
    	  	     </ul>
    	  	     <ul class="thumbnails" >
    	  	         	  	     	<li class="span6">
    	  	     		<div class="thumbnail" id="vmbytein"></div>
    	  	     	</li>
    	  	     	<li class="span6">
    	  	     		<div class="thumbnail" id="vmbyteout"></div>
    	  	     	</li>
    	  	     </ul>
    	  	     </div>
    	  	     </div>
        	</div>
      </div>
</div>

<script type="text/javascript">
refresh_vms_chart()
</script>