
//For Chart Drawing
	function draw_vm_chart(selector,chart_title,chart_text,char_xdata,chart_ydata){
		new Highcharts.Chart({
			chart : {
				renderTo : selector
			},
			title : {
				text : chart_title
				},
			xAxis : {
				categories : char_xdata,
				labels : {
					rotation : -45,
					align : 'right',
				}
			},
			yAxis : {
				min : 0,
				title : {
					text : chart_text
				}
			},
			series : [{
				type : 'column',
				name : chart_title,
				data : chart_ydata
			}]
		});
	}

	var refresh_vms_chart = function(){
		var vmid_list = new Array();
		var vm_statistic = new Array();
		$.ajax({
			url:"/experiment/resource/vmstatistic",
			type:"POST",
        	data:{},
			dataType:"json",
			timeout:8000,
			success:function(data){
				data = eval(data);
				vmid_list = data['vmid_list'];
				vm_statistic = data['vm_statistic'];
				draw_vm_chart('vmcpu', 'cpu平均利用率', 'cpu平均利用率(%)', vmid_list, vm_statistic['vmcpu']);
				draw_vm_chart('vmmem', 'mem平均使用量', 'mem平均使用量(MB)', vmid_list, vm_statistic['vmmem']);
				draw_vm_chart('vmbytein', '流入流量', '流入流量(MB)', vmid_list, vm_statistic['vmbytein']);
				draw_vm_chart('vmbyteout', '流出流量', '流出流量(MB)', vmid_list, vm_statistic['vmbyteout']);
				
			},
        	error: function(XMLHttpRequest, textStatus, errorThrown) {
	             alert(XMLHttpRequest.status);
	             alert(XMLHttpRequest.readyState);
	             alert(XMLHttpRequest.responseText);
	        }
		});
	}
	
/**
 * 
 */
$(document).ready(function(){
   
	//For VM Key Download
	$("button.span2.btn-primary").click(function(){
		var id = $(this).attr('id');
		var method = id.split('&')[0];
		var username = id.split('&')[1];
		var keyname = id.split('&')[2];
		window.open("/experiment/resource/downloadkey/"+username+'/'+keyname);
	});
	
	//For VM Key Delete
	$("button.span2.btn-warning").click(function(){
		var id = $(this).attr('id');
		var method = id.split('&')[0];
		var username = id.split('&')[1];
		var keyname = id.split('&')[2];
		
		$.ajax({
			url:"/experiment/"+"resource/"+method,
			type:"POST",
        	data:{
        		'key_name':keyname,
        		'user_name':username
        	},
			dataType:"json",
			timeout:8000,
			success:function(data){
				data = eval(data);
				if( data['status'] == 'error'){
					alert(data['message']);
					return;
				}
				else{
					alert(data['message']);
					location.href = "/experiment/resource/keylist";
				}
			},
        	error: function(XMLHttpRequest, textStatus, errorThrown) {
	             alert(XMLHttpRequest.status);
	             alert(XMLHttpRequest.readyState);
	             alert(XMLHttpRequest.responseText);
	        }
		});	
	});
	
	//For all Delete link to show dialog modal
    $('a[data-confirm]').click(function(ev) {
        var href = $(this).attr('href');

        if (!$('#dataConfirmModal').length) {
            $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">请确认</h3></div><div class="modal-body"></div><div class="modal-footer"><a class="btn btn-primary" id="dataConfirmOK">确认</a><button class="btn btn-inverse" data-dismiss="modal" aria-hidden="true">取消</button></div></div>');
        } 
        $('#dataConfirmModal').find('.modal-body').html($(this).attr('data-confirm'));
        $('#dataConfirmOK').attr('href', href);
        $('#dataConfirmModal').modal({show:true});
        return false;
    });
	
/*	$('button[id^="downloadkey"]').click(function(){
		alert("OK!");
	})*/
	
	//For VM Detail Show
	$("a.a_info").click(function(){
		var id = $(this).attr('id');
		var vmid = id.split('&')[1];
		
		$.ajax({
			url:"/experiment/resource/getvmdetail",
			type:"POST",
        	data:{
        		'vm_id':vmid
        	},
			dataType:"json",
			timeout:8000,
			success:function(data){
				data = eval(data);
				$("#vmdns"+vmid).html(data['dns']);
				$("#vmport"+vmid).html(data['port']);
				$("#vmipv6"+vmid).html(data['ipv6']);
				if( $("div#showvmdetail"+vmid).css('display') == 'none'){
					$("div#showvmdetail"+vmid).show();
				}
			},
        	error: function(XMLHttpRequest, textStatus, errorThrown) {
	             alert(XMLHttpRequest.status);
	             alert(XMLHttpRequest.readyState);
	             alert(XMLHttpRequest.responseText);
	        }
		});
	});
	
	
	$("#getvmsatistic").click(function(){
		$("#show_vm_statistic_chart").show();
		refresh_vms_chart();
	});
	
//	refresh_vms_chart();
	
	
//    var chart1 = new Highcharts.Chart({
//        chart: {
//            renderTo: 'vmmem',
//        },
//        title: {
//            text: 'Fruit Consumption'
//        },
//        xAxis: {
//            categories: ['Apples', 'Bananas', 'Oranges']
//        },
//        yAxis: {
//            title: {
//                text: 'Fruit eaten'
//            }
//        },
//        series: [{
//            name: 'Jane',
//            data: [1, 0, 4]
//        }, {
//            name: 'John',
//            data: [5, 7, 3]
//        }]
//    });
//	
//	var cpu0y= new Array();
//	var vmidt = new Array('test1','test2','test3','test4');
//	var cpu0y = new Array(1,2,3,4);
//	
//	var chart = new Highcharts.Chart({
//		chart : {
//			renderTo : 'vmcpu'
//		},
//		title : {
//			text : 'cpu平均利用率'
//			},
//		xAxis : {
//			categories : vmidt,
//			labels : {
//				rotation : -45,
//				align : 'right',
//			}
//		},
//		yAxis : {
//			min : 0,
//			title : {
//				text : 'cpu平均利用率(%)'
//			}
//		},
//		series : [{
//			type : 'column',
//			name : 'cpu平均利用率',
//			data : cpu0y
//		}]
//	});
	
});