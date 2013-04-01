<?php if (!defined('BASEPATH')) die();
class Diary extends Main_Controller {
	
	public function __construct()
	{
		parent::__construct();
	
		$this->validLogin();
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation','crane_openapi','session'));
		$this->load->model(array('experiment_model','diary_model','cluster_info_model'));
	}
	
	public function add($data = array()){
		$data["menu"] = "diary";
		$data['sidebar'] = "add";
		$data['action'] = "add";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');

		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/add',$data);
		$this->load->view('include/footer');
	}
	
	public function doadd(){
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('add_diary') == FALSE)
		{
			$this->add();
		}
		else
		{
			$user_id = $this->session->userdata('userid');
			$exp_id = $this->input->post('diary_eid');
			$title = $this->input->post('diary_title');
			$content = $this->input->post('diary_content');
			if($this->diary_model->add_diary($user_id,$exp_id,$title,$content))
			{
				redirect("diary/showlist");
			}
			else {
				$data['error']= '插入数据库错误';
				$this->add($data);
			}
		}		
	}
	
	public function edit($id){
		$data["menu"] = "diary";
		$data['sidebar'] = "show";
		$data['action'] = "show";
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$content = $this->diary_model->get_one_diary_byid($user_id,$id);
		if(key_exists('error', $content)){
			var_dump($content['error']);
			return;
		}
		$exp_id = $content['exp_id'];
		$data['default'] = array(
				'title' => $content['title'],
				'content' => $content['content'],
				'id' => $id
		);
		
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/add',$data);
		$this->load->view('include/footer');		
	}
	
	public function doedit($id){
		$user_id = $this->session->userdata('userid');
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		// add_diary and update_diary form_validation are same
		if($this->form_validation->run('add_diary') == FALSE)
		{
			$this->edit($id);
		}
		else
		{
			$exp_id = $this->input->post('diary_eid');
			$title = $this->input->post('diary_title');
			$content = $this->input->post('diary_content');
			if($this->diary_model->update_diary($id,$user_id,$exp_id,$title,$content))
			{
				redirect("diary/showlist");
			}
			else {
				$data['error']= '更新数据库错误';
				//not $this->edit($data), add has para data
				$this->add($data);
			}
		}
	}
	
	public function delete($id){
		$user_id = $this->session->userdata('userid');
		if($this->diary_model->delete_diary($user_id,$id)){
			redirect("diary/showlist");
		}
		else{
			$username = $this->session->userdata('username');
			$data['username'] = $username ? $username : '无法获得';
			$data["menu"] = "diary";
			$data['sidebar'] = "showlist";
			
			$data['all_diary'] = $this->diary_model->get_all_diary_byuser($user_id);
			$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
			$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('logs/showlist',$data);
			$this->load->view('include/footer');
		}
	}
	
	public function show($id){
		$data["menu"] = "diary";
		$data['sidebar'] = "show";
		$data['action'] = "show";
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$content = $this->diary_model->get_one_diary_byid($user_id,$id);
		if(key_exists('error', $content)){
			var_dump($content['error']);
			return;
		}
		$data['diary'] = $content;

		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/showlog',$data);
		$this->load->view('include/footer');
	}
	
	public function showlist(){
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$data["menu"] = "diary";
		$data['sidebar'] = "showlist";
		
		$exp_id = $this->input->post('experiment_id');
		if( !$exp_id){
			$diary_list = $this->diary_model->get_all_diary_byuser($user_id);
		}
		else{
			$data['eid'] = $exp_id;
			$diary_list = $this->diary_model->get_user_diary_by_experiment($user_id,$exp_id);
		}
		$data['all_diary'] = $diary_list;
		$data['experiment_list'] = $this->experiment_model->get_experiments_id_title($user_id);
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/showlist',$data);
		$this->load->view('include/footer');
	}
	
	//@todo get system log by openapi
	public function system(){
		$data["menu"] = "diary";
		$data['sidebar'] = "system";
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		
		$cluster_list = $this->cluster_info_model->get_clusterid_by_userid($user_id);

		$system_log = array();
		foreach ($cluster_list as $cluster_id){
			$para_data = array(
					'method' => 'get_cluster_log',
					'site' => 'hust',
					'cluster_id' => $cluster_id,
					'client_id' => $this->session->userdata('client_id'),
					'access_token' => $this->session->userdata('access_token')
			);
			$responce = $this->crane_openapi->request_hpcpaas($para_data);
			if( array_key_exists('error', $responce)){
				$data['error'] = 'Get system from openapi error!';		
			}
			else{
				$system_log[$cluster_id] = $responce['log_list'];
			}
		}
		$data['system_log'] = $system_log;
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/system',$data);
		$this->load->view('include/footer');
		
	}
	
	public function test_model(){
		//$data = $this->diary_model->add_diary(6,20,'haha','hehe');
		//$data = $this->diary_model->update_diary(2,6,1,'hahaha','hehehe');
		//$data = $this->diary_model->delete_diray(2,6,20);
		//$data = $this->diary_model->get_all_diary_byuser(6);
		$data = $this->diary_model->get_one_diary_byid(6,7);
		//$data = $this->diary_model->get_userid_by_diaryid(2);
		var_dump($data);
	}
}