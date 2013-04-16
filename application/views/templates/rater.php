<a href="#myModal" role="button" class="btn" data-toggle="modal">我要评分</a>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">评分</h3>
  </div>
  <div class="modal-body">
  	<p>点击星星进行评分</p>
    <div id="demo2" style="display:inline"></div><script type="text/javascript">$("#demo2").rater({active:true,maxvalue:10});</script>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true" id="rating-close">关闭</button>
    <button class="btn btn-primary" id="submit-score" >提交</button> 
  </div>
</div>
<script type="text/javascript">
$("#submit-score").click(function(){
	if(typeof(raterValue)=="undefined"){
		alert("请先打分");
		return;
	}
	//alert(raterValue);
	var tmp=document.location.href;
	var exp_arr=tmp.split('/');
	var exp_id=exp_arr[exp_arr.length-1];
	//alert(exp_id);
	var url="<?php echo base_url();?>";
	$.post(url+"exp/addrating",{exp:exp_id,score:raterValue},function(data){
			alert("评分成功");
			document.getElementById("rating-close").click();
			location.reload() 
	});
});
</script>