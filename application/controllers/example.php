<?php if (!defined('BASEPATH')) die();
class Example extends Main_Controller {
	
	public function __construct()
	{
		parent::__construct();
	
		$this->validLogin();
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation','crane_openapi','session'));
		$this->load->model(array('iaas_util_model','experiment_model','hpcjob_info_model'));
	}
	
	public function template(){
		$data["menu"] = "example";
		$data['sidebar'] = "template";
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		
		$template_list = $this->iaas_util_model->get_hpc_job_template($username);
		
		$data['template_list'] = $template_list;
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('example/template',$data);
		$this->load->view('include/footer');
	}
	
	public function add($template_id){
		$data["menu"] = "example";
		$data['sidebar'] = "";
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		
		$data['template_id'] = $template_id;
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('example/add',$data);
		$this->load->view('include/footer');
		
	}
	
	public function doadd(){		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		
		$exp_id = $this->input->post("exp_id");
		$node_count = $this->input->post("node_count");
		$command = $this->input->post("command");
		$template_id = $this->input->post("template");
		
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('add_template') == FALSE)
		{
			$this->add($template_id);
			return;
		}
		
		//create hpc template by openapi
	    $params = array(
        	'method'=>'submit_app_job',
        	'site'=>'hust',
	        'template_id'=>$template_id,
	        'node_count'=>$node_count,
	        'command'=>$command,
			'client_id' => $this->session->userdata('client_id'),
			'access_token' => $this->session->userdata('access_token')
 	    );
		
		$path = array();
		$realpath = array();
		
		$this->load->library('upload');
 		$config['upload_path'] = './tmp/';
 		$config['allowed_types'] = "*";
        $this->upload->initialize($config);
		
        if (!empty($_FILES['userfile1']['name']))
        {
            
            if ($this->upload->do_upload('userfile1'))
            {
                $data = $this->upload->data();
				$path[0] = $data['file_name'];				
				$params['file1'] = '@'.$data['full_path'];  
				$realpath[0] = $data['full_path'];  
            }
        }
		
		if (!empty($_FILES['userfile2']['name']))
        {
            if ($this->upload->do_upload('userfile2'))
            {
                $data = $this->upload->data();
				$path[1] = $data['file_name'];
				$params['file2'] = '@'.$data['full_path'];  
				$realpath[1] = $data['full_path'];  
            }
        }
		
		if (!empty($_FILES['userfile3']['name']))
        {
            if ($this->upload->do_upload('userfile3'))
            {
                $data = $this->upload->data();
				$path[2] = $data['file_name'];
				$params['file3'] = '@'.$data['full_path'];  
				$realpath[2] = $data['full_path'];  
            }
        }

		if (!empty($_FILES['userfile4']['name']))
        {
            if ($this->upload->do_upload('userfile4'))
            {
                $data = $this->upload->data();
				$path[3] = $data['file_name'];
				$params['file4'] = '@'.$data['full_path'];  
				$realpath[3] = $data['full_path'];  
            }
        }
		
		$input_file = implode(",", $path);  
		
		$params['input_file'] = $input_file;
		
		
		$responce = $this->crane_openapi->request_hpcpaas($params);
		
		unlink($realpath[0]);
		unlink($realpath[1]);
		unlink($realpath[2]);
		unlink($realpath[3]);
		
		if( array_key_exists('error', $responce))
		{
			var_dump($responce);
		}
		else{
			$job_id = $responce['job_id'];
			$para = array(
					'exp_id' => $exp_id,
					'job_id' => $job_id,
					'user_id' => $user_id,
					'template_id' => $template_id,
					'node_count' => $node_count,
					'command' => $command
			);
			$result = $this->hpcjob_info_model->add_job_info($para);
			if( $result == FALSE){
				$data["menu"] = "example";
				$data['sidebar'] = "";
				$data['error'] = '插入典型实验数据库错误';
				$data['template_id'] = $template_id;
				$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
				$this->load->view('include/header');
				$this->load->view('templates/menu',$data);
				$this->load->view('example/add',$data);
				$this->load->view('include/footer');
			}
			else{
				redirect('example/joblist');
			}
		}
	}
	
	public function delete($job_id){
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$expect_id = $this->hpcjob_info_model->get_userid_by_jobid($job_id);
		if($user_id != $expect_id){
			var_dump(array('error' => "You can't delete other's cluster!"));
			return;
		}
		
		//@todo delete use openapi
		$para_data = array(
				'method'=>'delete_job',
				'job_id' => $job_id,
				'site'=>'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);
		if( array_key_exists('error', $responce)){
			var_dump($responce);
		}
		else{
			$result = $this->hpcjob_info_model->delete_job($job_id);
			if( !$result){
				var_dump(array('error'=>'Delete the cluster info from db error!'));
				return;
			}
			redirect('example/joblist');
		}
	}
	
	public function download_result($job_id){
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$this->load->helper(array('download'));
		$para_data = array(
				'method'=>'download_job_result',
				'job_id' => $job_id,
				'site'=>'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);
		if( array_key_exists('error', $responce))
		{
			$data['error'] = $responce['error'];
			$this->joblist($data);
		}
		else
		{
			$file_name = $responce['file_name'];
			$message = $responce['result_file'];
			force_download($file_name, $message);
		}
	}
	
	public function joblist($data=array()){
		
		$data["menu"] = "example";
		$data['sidebar'] = "results";
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		
		$exp_id = $this->input->post('experiment_id');
		if( !$exp_id){
			$jobs_list = $this->hpcjob_info_model->get_user_jobs_data($user_id);
		}
		else{
			$data['eid'] = $exp_id;
			$jobs_list = $this->hpcjob_info_model->get_user_jobs_by_experiment($user_id,$exp_id);
		}
		
		$para_data = array(
				'method' => 'get_user_job',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
		);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);
		if( array_key_exists('error', $responce)){
			$data['error'] = '获得HPC典型实验信息失败';
			$data['jobs_list'] = $jobs_list;
			$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('example/results',$data);
			$this->load->view('include/footer');
			return;
		}
		//var_dump($responce);
		foreach ($responce['info_list'] as $job_detail) {
			$job_id = $job_detail['job_id'];
			if( ! array_key_exists($job_id, $jobs_list)){
				continue;
			}
			$jobs_list[$job_id]['start_time']= $job_detail['start_time'];
			$jobs_list[$job_id]['state']= $job_detail['state'];
			$jobs_list[$job_id]['end_time'] = $job_detail['end_time'];
			$jobs_list[$job_id]['input'] = $job_detail['inputfile'];
		}
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$data['jobs_list'] = $jobs_list;
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('example/results',$data);
		$this->load->view('include/footer');
	}
	
	public function test_model(){
// 		$type = 'hpcpaas';
// 		$param = array(
// 				'method'=>'submit_app_job',
// 				'site'=> 'hust',
// 				'user_name' => 'test',
// 				'template_id' => 1,
// 				'node_count' => 2,
// 				'command' => 'namd2 ./alanin',
// 				'input_file' => 'a.in,b.in'
// 				);
// 		$input_file = array(
// 				'a.in' => 'tsatsateea',
// 				'b.in' => 'afadfaa'
// 				);
// 		echo $this->crane_openapi->call_with_input_files($type,$param,$input_file);
		echo $this->hpcjob_info_model->get_userid_by_jobid(149);
		
	}
}
