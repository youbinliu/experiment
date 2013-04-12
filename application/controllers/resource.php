<?php if (!defined('BASEPATH')) die();
class Resource extends Main_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->validLogin();
		$this->load->library(array('form_validation','crane_openapi','session'));
		$this->load->model(array('iaas_util_model','vm_info_model','experiment_model','cluster_info_model'));
		$this->load->helper(array('form','url'));
	}
    
	
	public function info(){
		
		$data["menu"] = "resource";
		$data['sidebar'] = "info";
		$username = $this->session->userdata('username');
		$client_id = $this->session->userdata('client_id');
		$access_token = $this->session->userdata('access_token');
		$data['username'] = $username ? $username : '无法获得';
		$vm_total = array();
		$para_data = array(
				'method' => 'get_iaas_total_info',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_report($para_data);
		if( array_key_exists('error', $responce))
		{
			$data['error'] = '获得资源统计信息失败！';
		}
		else{
			$vm_total['vm_count'] = $responce['vmamount'];
			$vm_total['cpu_time'] = $responce['cputime'];
			$vm_total['memory'] = $responce['memory'];
			$vm_total['vcpu'] = $responce['vcpu'];
			$vm_total['net_in'] = $responce['bytin'];
			$vm_total['net_out'] = $responce['bytout'];
		}
		$data['vm_total'] = $vm_total;
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/info',$data);
		$this->load->view('include/footer');
		
	}
	
	/**
	 * Show the add vm page ,if given eid ,set the experiment
	 * @param string/int $eid
	 */
	public function add($eid=0){
		$data["menu"] = "resource";
		$data['sidebar'] = "add";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		if($eid !=0){
		    $data['eid'] = $eid;
		}
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$data['image_list'] = $this->iaas_util_model->get_image_list($username);
		$data['key_list'] = $this->iaas_util_model->get_key_list($username);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/add',$data);
		$this->load->view('include/footer');
	}
	
	/**
	 * Deal with the add vm action
	 * @param strint/int $eid
	 */
	public function doadd($eid=0){
	    $data["menu"] = "resource";
		$data['sidebar'] = "add";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$insert_ok = TRUE;
	    if($eid !=0){
		    $data['eid'] = $eid;
		}
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('create_vm') == FALSE)
		{
		    $data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
    		$data['image_list'] = $this->iaas_util_model->get_image_list($username);
    		$data['key_list'] = $this->iaas_util_model->get_key_list($username);
    		$this->load->view('include/header');
    		$this->load->view('templates/menu',$data);
    		$this->load->view('resource/add',$data);
    		$this->load->view('include/footer');
		}
		else
		{
		    $exp_id = $this->input->post('vm_eid');
		    $image = $this->input->post('vm_image');
		    $key = $this->input->post('vm_key');
		    $vcpu = $this->input->post('vm_cpu');
		    $memory = $this->input->post('vm_memory');
		    $count = $this->input->post('vm_count');
		    
		    
		    //create vm by openapi
		    $para_data = array(
            	'method'=>'vm_create',
            	'site'=>'hust',
		        'vcpu' => $vcpu,
		        'count' => $count,
		        'image' => $image,
		        'memory' => $memory,
		        'key' => $key,
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
     	    );
     	    $responce = $this->crane_openapi->request_iaas($para_data);

     	    if( array_key_exists('error', $responce))
     	    {
     	        var_dump($responce);
     	    }
     	    else{
     	        foreach ($responce['id_list'] as $vm_id) {
     	            $para = array(
     	                'exp_id' => $exp_id,
     	                'vm_id' => $vm_id,
     	            	'user_id' => $user_id,
     	                'vcpu' => $vcpu,
     	                'memory' => $memory,
     	                'image' => $image,
     	                'key' => $key
     	            );
     	            $result = $this->vm_info_model->add_vm_info($para);
     	            if( !$result){
     	                $insert_ok = FALSE;
                		break;
     	            }
     	        }
     	        if( $insert_ok == FALSE){
 	                $data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
            		$data['image_list'] = $this->iaas_util_model->get_image_list($username);
            		$data['key_list'] = $this->iaas_util_model->get_key_list($username);
            		$data['error'] = '插入数据库错误';
            		$this->load->view('include/header');
            		$this->load->view('templates/menu',$data);
            		$this->load->view('resource/add',$data);
            		$this->load->view('include/footer');      	            
     	        }
     	        else{
     	            redirect("resource/showlist");
     	        }    	        
     	    }
		}
	}
	
	//@todo page from the exp to show
	public function show($eid){
		$data["menu"] = "resource";
		$data['sidebar'] = "show";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('addexp',$data);
		$this->load->view('include/footer');
	}
	
	/**
	 * Show all vms owned by user
	 */
	public function showlist(){
		$data["menu"] = "resource";
		$data['sidebar'] = "showlist";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
     	
		$exp_id = $this->input->post('experiment_id');
		if( !$exp_id){
			$vms_list = $this->vm_info_model->get_user_vms_data($user_id);		
		}
		else{
			$data['eid'] = $exp_id;
			$vms_list = $this->vm_info_model->get_user_vms_by_experiment($user_id,$exp_id);	
		}
     	
     	//Get the vmpool_info by openapi
     	$para_data = array(
     			'method' => 'get_all_vm_info',
     			'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
     	);
     	$responce = $this->crane_openapi->request_iaas($para_data);
     	if( array_key_exists('error', $responce)){
     		$data['error'] = '获得虚拟机资源池信息失败';
     		$data['vms_list'] = array();
     		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
     		$this->load->view('include/header');
     		$this->load->view('templates/menu',$data);
     		$this->load->view('resource/showlist',$data);
     		$this->load->view('include/footer');
     		return;
     	}
     	foreach ($responce['info_list'] as $vm_detail) {
     		$vm_id = $vm_detail['guid'];
     		if( ! array_key_exists($vm_id, $vms_list)){
     			continue;
     		}
     		$vms_list[$vm_id]['start_time']= $vm_detail['stime'];
     		$vms_list[$vm_id]['status']= $vm_detail['stat'];
     	}
		$data['vms_list'] = $vms_list;
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/showlist',$data);
		$this->load->view('include/footer');
	}
	
	
	/**
	 * Show the vms owned by user ,sorted by the experiment
	 */
	public function filtershowlist($exp_id){
		$data["menu"] = "resource";
		$data['sidebar'] = "showlist";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
     	
		$expected_id = $this->experiment_model->get_userid_by_expid($exp_id);
		if( $expected_id != $user_id){
			var_dump(array('error'=>"You can't get the resource information of others!"));
			return;
		}
		$data['eid'] = $exp_id;
		$vms_list = $this->vm_info_model->get_user_vms_by_experiment($user_id,$exp_id);	
		
     	//Get the vmpool_info by openapi
     	$para_data = array(
     			'method' => 'get_all_vm_info',
     			'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
     	);
     	$responce = $this->crane_openapi->request_iaas($para_data);
     	if( array_key_exists('error', $responce)){
     		$data['error'] = '获得虚拟机资源池信息失败';
     		$data['vms_list'] = array();
     		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
     		$this->load->view('include/header');
     		$this->load->view('templates/menu',$data);
     		$this->load->view('resource/showlist',$data);
     		$this->load->view('include/footer');
     		return;
     	}
     	foreach ($responce['info_list'] as $vm_detail) {
     		$vm_id = $vm_detail['guid'];
     		if( ! array_key_exists($vm_id, $vms_list)){
     			continue;
     		}
     		$vms_list[$vm_id]['start_time']= $vm_detail['stime'];
     		$vms_list[$vm_id]['status']= $vm_detail['stat'];
     	}
		$data['vms_list'] = $vms_list;
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/showlist',$data);
		$this->load->view('include/footer');
	}
	
	/**
	 * Deal with the vm action. if shutdown,delete the vm in database
	 * @param string $action
	 * @param string/int $vm_id
	 */
	public function vmaction($action,$vm_id)
	{
		$username = $this->session->userdata('username');
		$user_id = $this->session->userdata('userid');
		$expect_id = $this->vm_info_model->get_userid_by_vmid($vm_id);
		if($expect_id != $user_id){
			var_dump(array('error' => "you can't operaton other's vm!"));
			return;
		}
	    if(in_array($action,array('stop','resume','shutdown'))){
     	    $para_data = array(
            	'method'=>'vm_action',
            	'site'=>'hust',
		        'vm_id' => $vm_id,
     	        'action' => $action,
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
     	    );
     	    $responce = $this->crane_openapi->request_iaas($para_data);
     	    if($action == 'shutdown' && !array_key_exists('error', $responce))
     	    {
     	        $this->vm_info_model->delete_vm($vm_id);
     	        redirect("resource/showlist");
     	    }
     	    redirect("resource/showlist");
	    }
	}
	
	/**
	 * Return the vm detail for ajax
	 */
	public function getvmdetail(){
		$vm_id = $this->input->post('vm_id');
		$username = $this->session->userdata('username');
		$user_id = $this->session->userdata('userid');
		$expect_id = $this->vm_info_model->get_userid_by_vmid($vm_id);
		if($expect_id != $user_id){
			echo json_encode(array('vm_id'=>$vm_id,'user_id'=>$user_id,'expect'=>$expect_id,'dns'=>'Get Error!','port'=>'Get Error!','ipv6'=>'Get Error!'));
			return;
		}
		$para_data = array(
				'method' => 'get_vm_info',
				'site' => 'hust',
				'vm_id' => $vm_id,
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_iaas($para_data);
		if( array_key_exists('error', $responce)){
			echo json_encode(array('dns'=>'Get Error!','port'=>'Get Error!','ipv6'=>'Get Error!'));
			return;
		}
		echo json_encode(array(
				'dns' => $responce['dns'],
				'port' => $responce['sshport'],
				'ipv6' => $responce['ipv6']
				));
		
	}
	
	public function vmstatistic(){
		$username = $this->session->userdata('username');
		$user_id = $this->session->userdata('userid');
		$vmid_list = array();
		$vm_statistic = array();
		$para_data = array(
				'method' => 'get_vm_info',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_report($para_data);
		if( array_key_exists('error', $responce)){
			echo json_encode(array('vmid_list'=>$vmid_list,'vm_statistic'=>$vm_statistic));
			return;
		}
		foreach ($responce['info_list'] as $info){
			$id = $info['vm_id'];
			$vmid_list[] = $id;
			$vm_statistic['vmcpu'][] = round($info['cpu'],3);
			$vm_statistic['vmmem'][] = round($info['mem'],3);
			$vm_statistic['vmbytein'][] = round($info['byte_in'],3);
			$vm_statistic['vmbyteout'][] = round($info['byte_out'],3);
		}
		$data = array(
				'vmid_list' => $vmid_list,
				'vm_statistic' => $vm_statistic
				);
		echo json_encode($data);
	}
	
	public function addcluster($eid=0){
		
		$data["menu"] = "resource";
		$data['sidebar'] = "addcluster";
		if($eid !=0){
			$data['eid'] = $eid;
		}
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');

		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$data['cluster_template'] = $this->iaas_util_model->get_cluster_template_list($username);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/addcluster',$data);
		$this->load->view('include/footer');
	}
	
	public function doaddcluster($eid=0)
	{
		
		
		$data["menu"] = "resource";
		$data['sidebar'] = "addcluster";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$insert_ok = TRUE;
		if($eid !=0){
			$data['eid'] = $eid;
		}
		$insert_ok = TRUE;
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('add_cluster') == FALSE)
		{
			$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
			$data['cluster_template'] = $this->iaas_util_model->get_cluster_template_list($username);
			$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('resource/addcluster',$data);
			$this->load->view('include/footer');
		}
		else
		{
			$exp_id = $this->input->post('cluser_eid');
			$template_id = $this->input->post('cluster_template');
			$master_vcpu = $this->input->post('master_cpu');
			$master_mem = $this->input->post('master_mem');
			$slave_vcpu = $this->input->post('slave_cpu');
			$slave_mem = $this->input->post('slave_mem');
			$slave_count = $this->input->post('cluster_slave_count');

			//@todo add cluster with openapi
			//create cluster by openapi
		    $para_data = array(
            	'method'=>'create_cluster',
            	'site'=>'hust',
		    	'template_id' => $template_id,
		    	'master_vcpu' => $master_vcpu,
		    	'master_mem' => $master_mem,
		    	'slave_vcpu' => $slave_vcpu,
		    	'slave_mem' => $slave_mem,
		    	'slave_count' => $slave_count,
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
     	    );
     	    $responce = $this->crane_openapi->request_hpcpaas($para_data);
     	    //For test data
// 			$responce = array(
// 					'id_list' => array('113','114')
// 					);
     	    if( array_key_exists('error', $responce))
     	    {
     	    	var_dump($responce);
     	    }
     	    else{
     	    	$cluster_id = $responce['cluster_id'];
     	    	$para = array(
     	    			'exp_id' => $exp_id,
     	    			'cluster_id' => $cluster_id,
     	    			'user_id' => $user_id,
     	    			'template_id' => $template_id,
     	    			'master_vcpu' => $master_vcpu,
     	    			'master_mem' => $master_mem,
     	    			'slave_vcpu' => $slave_vcpu,
     	    			'slave_mem' => $slave_mem,
     	    			'slave_count' => $slave_count
     	    	);
     	    	$result = $this->cluster_info_model->add_cluster_info($para);
     	    	if( !$result){
     	    		$insert_ok = FALSE;
     	    	}
     	    	if( $insert_ok == FALSE){
     	    		$data['error'] = '插入集群数据库错误';
     	    		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
     	    		$data['cluster_template'] = $this->iaas_util_model->get_cluster_template_list($username);
     	    		$this->load->view('include/header');
     	    		$this->load->view('templates/menu',$data);
     	    		$this->load->view('resource/addcluster',$data);
     	    		$this->load->view('include/footer');
     	    	}
     	    	else{
     	    		redirect('resource/showclusterlist');
     	    	}     	    	
     	    }
		}
	}
	
	public function showclusterlist(){
		$data["menu"] = "resource";
		$data['sidebar'] = "allcluster";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		
		$exp_id = $this->input->post('experiment_id');
		if( !$exp_id){
			$cluster_list = $this->cluster_info_model->get_user_clusters_data($user_id);
		}
		else{
			$data['eid'] = $exp_id;
			$cluster_list = $this->cluster_info_model->get_user_clusters_by_experiment($user_id,$exp_id);
		}
		//Get the clusterpool_info by openapi
		$para_data = array(
				'method' => 'query_cluster',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);

		if( array_key_exists('error', $responce)){
			$data['error'] = '获得集群资源池信息失败';
			$cluster_list = array();
     	    $data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
     	    $data['cluster_template'] = $this->iaas_util_model->get_cluster_template_list($username);
     	   	$this->load->view('include/header');
     	    $this->load->view('templates/menu',$data);
     	    $this->load->view('resource/addcluster',$data);
     	    $this->load->view('include/footer');
			return;
		}
		foreach ($responce['info_list'] as $cluster_detail) {
			$cluster_id = $cluster_detail['cluster_id'];
			if( ! array_key_exists($cluster_id, $cluster_list)){
				continue;
			}
			$cluster_list[$cluster_id]['start_time']= $cluster_detail['start_time'];
			$cluster_list[$cluster_id]['end_time']= $cluster_detail['start_time'];
			$cluster_list[$cluster_id]['status']= $cluster_detail['state'];
			$cluster_list[$cluster_id]['master_ipv6'] = $cluster_detail['master_ipv6'];
		}
		$data['cluster_list'] = $cluster_list;
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		//$data['cluster_template'] = $this->iaas_util_model->get_cluster_template_list($username);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/showclusterlist',$data);
		$this->load->view('include/footer');
	}
	
	public function filterclustershowlist()
	{
		$data["menu"] = "resource";
		$data['sidebar'] = "allcluster";
		$eid = $this->input->post("experiment_id");
		$data['eid'] = $eid;
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		
		$data['vms_list'] = $this->vm_info_model->get_user_vms_by_experiment($user_id,$eid);
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/showlist',$data);
		$this->load->view('include/footer');
	}
	
	public function downloadclusterkey($cluster_id)
	{
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$expect_id = $this->cluster_info_model->get_userid_by_clusterid($cluster_id);
		if($user_id != $expect_id){
			var_dump(array('error' => "You can't download other's cluster key!"));
		}
		$this->load->helper(array('download'));
		$para_data = array(
				'method'=>'get_cluster_key',
				'cluster_id' => $cluster_id,
				'site'=>'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);
		if( !array_key_exists('error', $responce)){
			$file_name = $cluster_id.'.pub';
			$message = $responce['key_content'];
			force_download($file_name, $message);
		}
	}
	
	public function deletecluster($cluster_id)
	{
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$expect_id = $this->cluster_info_model->get_userid_by_clusterid($cluster_id);
		if($user_id != $expect_id){
			var_dump(array('error' => "You can't delete other's cluster!"));
		}
		
		$para_data = array(
				'method'=>'delete_cluster',
				'cluster_id' => $cluster_id,
				'site'=>'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);
		if( array_key_exists('error', $responce)){
			var_dump($responce);
		}
		else{
			$result = $this->cluster_info_model->delete_cluster($cluster_id);
			if( !$result){
				var_dump(array('error'=>'Delete the cluster info from db error!'));
			}
			redirect('resource/showclusterlist');
		}
	}
	
	public function deleteuserkey($key_name)
	{
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
	    $para_data = array(
            'method'=>'delete_key',
	        'key_name' => $key_name,
            'site'=>'hust',
			'client_id' => $this->session->userdata('client_id'),
			'access_token' => $this->session->userdata('access_token')
     	);
     	$responce = $this->crane_openapi->request_iaas($para_data);
     	if( array_key_exists('error', $responce))
     	{
     		$data['error'] = "删除密钥失败！";
			$this->keylist($data);
		}
		else{	
			$this->keylist($data);
		}
	}
	
	/**
	 * Download the vm key,using IC's force_download
	 * @param unknown_type $username
	 * @param unknown_type $key_name
	 */
	public function downloadkey($username, $key_name)
	{
	    $this->load->helper(array('download'));
	    $para_data = array(
            'method'=>'get_key',
	        'key_name' => $key_name,
            'site'=>'hust',
			'client_id' => $this->session->userdata('client_id'),
			'access_token' => $this->session->userdata('access_token')
     	);
     	$responce = $this->crane_openapi->request_iaas($para_data);
     	if( array_key_exists('error', $responce))
     	{
     	    echo json_encode(array(
     	        'status'=>'no',
     	        'message'=> array($responce['error'],$para_data)
     	    ));
     	}
     	else
     	{
     	    $file_name = $key_name.'.prv';
     	    $message = $responce['key_content'];
     	    force_download($file_name, $message);
     	}
	}
	
	/**
	 * Deal with create key action
	 */
	public function docreatekey(){
		$data["menu"] = "resource";
		$data['sidebar'] = "createkey";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('create_key') == FALSE)
		{
			$para_data = array(
	            'method'=>'query_key',
	            'site'=>'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
	     	);
	     	$responce = $this->crane_openapi->request_iaas($para_data);
	     	if( array_key_exists('error', $responce))
	     	{
			    $data['error'] = $responce['error'];
	            $this->load->view('include/header');
			    $this->load->view('templates/menu',$data);
			    $this->load->view('resource/keylist',$data);
			    $this->load->view('include/footer');
	    		return;         	    
	     	}
	     	$data['key_list'] = $responce['key_list'];
	     	//var_dump($responce);
	     	$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('resource/keylist',$data);
			$this->load->view('include/footer');

		}
		else{
		    $para_data = array(
            	'method'=>'create_key',
            	'site'=>'hust',
		        'key_name' => $this->input->post('key_name'),
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
     	    );
     	    //var_dump($para_data);
     	    //return;
     	    $responce = $this->crane_openapi->request_iaas($para_data);
     	    if( array_key_exists('error', $responce))
     	    {
     	        var_dump($responce);
     	        $data['error'] = '创建密钥失败:'.$responce['error'];;
     	        $this->load->view('include/header');
		        $this->load->view('templates/menu',$data);
		        $this->load->view('resource/createkey',$data);
		        $this->load->view('include/footer');
		        return;
     	    }
		    redirect("resource/keylist");    
		}
	}
	
	/**
	 * Show the create key page
	 */
	public function createkey()
	{
		$data["menu"] = "resource";
		$data['sidebar'] = "createkey";	
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
	    $this->load->view('include/header');
	    $this->load->view('templates/menu',$data);
	    $this->load->view('resource/createkey',$data);
	    $this->load->view('include/footer');
	}
	
	/**
	 * Show the keys owned by the user
	 */
	public function keylist($data = array()){
		$data["menu"] = "resource";
		$data['sidebar'] = "keylist";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		
		$para_data = array(
            'method'=>'query_key',
            'site'=>'hust',
			'client_id' => $this->session->userdata('client_id'),
			'access_token' => $this->session->userdata('access_token')
     	);
     	$responce = $this->crane_openapi->request_iaas($para_data);
     	if( array_key_exists('error', $responce))
     	{
		    $data['error'] = $responce['error'];
            $this->load->view('include/header');
		    $this->load->view('templates/menu',$data);
		    $this->load->view('resource/keylist',$data);
		    $this->load->view('include/footer');
    		return;         	    
     	}
     	$data['key_list'] = $responce['key_list'];
     	//var_dump($responce);
     	$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/keylist',$data);
		$this->load->view('include/footer');
	}
	
	//About Image
	public function saveimage($vm_id){
		$data["menu"] = "resource";
		$data['sidebar'] = "imagelist";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$data['vm_id'] = $vm_id;
		
     	$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/saveimage',$data);
		$this->load->view('include/footer');
	}
	
	public function dosaveimage(){
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		
		$data["menu"] = "resource";
		$data['sidebar'] = "imagelist";
		$vm_id = $this->input->post('vm_id');
		$data['vm_id'] = $vm_id;
				
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('save_image') == FALSE)
		{
	     	$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('resource/saveimage',$data);
			$this->load->view('include/footer');
			return;
		}
		$image_name = $this->input->post('image_name');
		$image_describe = $this->input->post('image_describe');
		
		$para_data = array(
				'method'=>'create_vm_template',
				'template_name' => $image_name,
				'description' => $image_describe,
				'site'=>'hust',
				'vm_id' => $vm_id,
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		
		$responce = $this->crane_openapi->request_iaas($para_data);
		if( array_key_exists('error', $responce))
		{
			$data['error'] = '保存实验环境失败:'.$responce['error'];;
	     	$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('resource/saveimage',$data);
			$this->load->view('include/footer');
			return;
		}
		$this->vm_info_model->delete_vm($vm_id);
		redirect("resource/imagelist");
	}
	
	public function imagelist($data = array()){
		$data["menu"] = "resource";
		$data['sidebar'] = "imagelist";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		
		$image_list = array();
		$para_data = array(
				'method' => 'query_template',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_iaas($para_data);
		if( array_key_exists('error', $responce))
		{
			$data['error'] = '获取实验环境失败:'.$responce['error'];;
			$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('resource/imagelist',$data);
			$this->load->view('include/footer');
			return;
		}
		foreach( $responce['template_list'] as $template){
			if( $template['user_name'] == $username){
				$image_list[] = $template;
			}
		}
		$data['image_list'] = $image_list;
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/imagelist',$data);
		$this->load->view('include/footer');
	}
	
	public function imageaction($action,$template_id){
		$data["menu"] = "resource";
		$data['sidebar'] = "imagelist";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		
		if( in_array($action, array('public','unpublic','enable','unable','remove'))){
		    $para_data = array(
		    		'method' => 'template_action',
		    		'site' => 'hust',
		    		'action' => $action,
		    		'template_id' => $template_id,
					'client_id' => $this->session->userdata('client_id'),
					'access_token' => $this->session->userdata('access_token')
	 
		    );
			$responce = $this->crane_openapi->request_iaas($para_data);
			if( array_key_exists('error', $responce))
			{
				$data['error'] = '操作实验环境失败:'.$responce['error'];
				$this->imagelist($data);
				return;
			}
			redirect("resource/imagelist");
		}
		else{
			$data['error'] = '无效的实验环境操作！';
			$this->imagelist($data);
		}
	}
	
	public function test_model(){
	    $user_name = 'lycc316';
	    
/*		$para = array(
		    'exp_id'=> 17,
		    'vm_id' => 2,
		    'vcpu' => 3,
		    'memory' => 4,
		    'image' => 'test',
		    'key' => 'key'
		);
		$data = $this->vm_info_model->add_vm_info($para);*/
		//$data = $this->experiment_model->get_experiments_id_title($username);
		//$data = $this->iaas_util_model->get_cluster_template_list($user_name);
		//$data = $this->iaas_util_model->get_hpc_job_template($user_name);
// 		$para = array(
// 				'exp_id' => 20,
// 				'user_id' => 6,
// 						'master_vcpu' => 5,
// 						'master_mem' => 5,
// 						'slave_vcpu' => 5,
// 						'slave_mem' => 5,
// 						'slave_count' => 6
// 				);
// 		$data = $this->cluster_info_model->delete_cluster(110);//add_cluster_info($para);
		$para_data = array(
				'method' => 'query_template',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
// 		$para_data = array(
// 				'method' => 'get_template_detail',
// 				'site' => 'hust',
// 				'user_name' => 'lycc316',
// 				'template_id' => '83'
				
// 		);
// 	    $para_data = array(
// 	    		'method' => 'template_action',
// 	    		'site' => 'hust',
// 	    		'user_name' => 'lycc316',
// 	    		'action' => 'unable',
// 	    		'template_id' => '83'
	    
// 	    );
	    $responce = $this->crane_openapi->request_iaas($para_data);
		var_dump($responce);
		//$data = $this->iaas_util_model->get_key_list($user_name);
/*		$para = array(
		    'exp_id'=> 17,
		    'vm_id' => 2,
		    'start_time' => '2013-02-21 15:55:30',
		    'status' => 'RUNNING'
		);
		$data = $this->vm_info_model->update_vm_status($para);*/
/*	    $para = array(
		    'exp_id'=> 17,
		    'vm_id' => 2,
		    'port' => 1431,
		    'dns' => 'hello.com',
	        'ipv6' =>'ffff:fffff:ffff:ffff'
		);
		$data = $this->vm_info_model->update_vm_port($para);*/
		//$data = $this->vm_info_model->get_user_vms_data();
		//$data = $this->vm_info_model->get_vm_by_experiment(18);
/* 		$para_data = array(
				'method' => 'get_vm_info_list',
				'site' => 'hust',
				'user_name' => 'test41'
				);
		$responce = $this->crane_openapi->request_iaas($para_data); */
//		var_dump($responce);
	}
	
}
