<!DOCTYPE html>
<html lang="zh-cn">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <title>重点学科资源云</title>

   <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/docs.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">

   <script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
   <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
   <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
   
   <script src="https://211.69.198.245/static/gateone.js"></script>
</head>
<body>
	<div id="wrap">
	<?php $this->load->view('templates/menu');?>
	  	<div id="gateone_container" style="position: relative; width: 100%; height: 600px;">
	        <div id="gateone" ></div>
	    </div>
	
	    <!-- Call GateOne.init() at some point after the page is done loading -->
	    <script>
	    window.onload = function() {
	        // Initialize Gate One:
	        GateOne.init({
			url: 'https://211.69.198.245'});
	    }
	    </script>
  	</div>
</body>
</html>