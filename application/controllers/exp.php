<?php if (!defined('BASEPATH')) die();
/*
 * Experiment Controller
 * 
 * Monitor the experiment here,you can add an experiment,update an exist experiment or delete an experiment.
 * 
 * @author lycc
 */
class Exp extends Main_Controller {

    private $experiment_types = array();
    	
	public function __construct()
	{
		parent::__construct();
		
		$this->validLogin();
		$this->load->helper(array('form','url'));
		$this->load->model(array('experiment_type_model','experiment_model'));
		$this->load->library(array('session','form_validation',));
		$this->experiment_types = $this->experiment_type_model->get_type_list();
		
	}
	
	public function index(){
		$this->showlist();
	}
	
	/**
	 * Show the add experiment page
	 * @param array $data
	 */
	public function add($data = array()){
		$data["menu"] = "exp";
		$data['sidebar'] = "add";
		$data['action'] = "add";
		$data['extra_not_show'] = TRUE;
		$data['experiment_type'] = $this->experiment_types;
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp/addexp',$data);
		$this->load->view('include/footer');
		
	}
	
	/**
	 * Deal with the add experiment action
	 */
	public function doadd(){
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('add_experiment') == FALSE)
		{
            $this->add();
		}
		else
		{
			 $user_id = $this->session->userdata('userid');
		     $title = $this->input->post('experiment_title');
		     $type_id = $this->input->post('experiment_type');
		     $status = $this->input->post('experiment_status');
		     $describe = $this->input->post('experiment_describe');
		     $keyword = $this->input->post('experiment_keyword');
		     if($this->experiment_model->add_experiment($title,$user_id,$type_id,$status,$describe,$keyword))
		     {
                redirect("exp/showlist");
		     }
		     else {
		         $data['error']= '插入数据库错误';
		         $this->add($data);
		     }
		} 
	}
	
	/**
	 * Delete the experiment
	 * @param string/int $id
	 */
	public function delete($id){
		$user_id = $this->session->userdata('userid');		
		if($this->experiment_model->delete_experiment($user_id,$id)){
            redirect("exp/showlist");		    
		}
		else{
			$username = $this->session->userdata('username');
			$data['username'] = $username ? $username : '无法获得';
			$user_id = $this->session->userdata('userid');
			$data["menu"] = "exp";
		    $data['error'] = '数据库删除错误';
		    $data['sidebar'] = 'all';
		    $data['all_experiments'] = $this->experiment_model->get_all_experiments_byuser($user_id,'all');
		    $data['experiment_types'] = $this->experiment_types;
		    
		    $this->load->view('include/header');
		    $this->load->view('templates/menu',$data);
		    $this->load->view('exp/showlist',$data);
		    $this->load->view('include/footer');
		}
	}
	
	/**
	 * Show the experiment page,which you can't edit
	 * @param string/int $id
	 */
	public function show($id){
		$data["menu"] = "exp";
		$data['sidebar'] = "show";
		$data['action'] = "show";
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$content = $this->experiment_model->get_one_experiment_byid($id);
		$relative = $this->experiment_model->get_experiments_relative_bystr($content->keywords,$id);
		
		if(key_exists('error', $content)){
			$data['sidebar'] = 'all';
			$data['all_experiments'] = $this->experiment_model->get_all_experiments_byuser($user_id,'all');
			$data['experiment_types'] = $this->experiment_types;
			$data['error'] = $content['error'];
			
			$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('exp/showlist',$data);
			$this->load->view('include/footer');
			return;
		}

		$data['experiment'] = $content;
		$data['relativexp'] = $relative;
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp/showexp',$data);
		//$this->load->view('testview',$data);
		$this->load->view('include/footer');
	}
	
	/**
	 * Show the edit experiment page
	 * @param string/int $id
	 */
	public function edit($id){
		$data["menu"] = "exp";
		$data['sidebar'] = "edit";
		$data['action'] = "edit";
		
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$content = $this->experiment_model->get_one_experiment_byid($id);
		if(key_exists('error', $content)){
			$data['sidebar'] = 'all';
			$data['all_experiments'] = $this->experiment_model->get_all_experiments_byuser($user_id,'all');
			$data['experiment_types'] = $this->experiment_types;
			$data['error'] = $content['error'];
				
			$this->load->view('include/header');
			$this->load->view('templates/menu',$data);
			$this->load->view('exp/showlist',$data);
			$this->load->view('include/footer');
			return;
		}
		$data['default'] = array(
		    'title' => $content->title,
		    'status' => $content->status,
		    'type_id' => $content->type_id,
			'describe' => $content->describe,
			'tools' => $content->tools,
			'result' => $content->result,
			'papers' => $content->papers,
		    'id' => $id,
			'keywords' => $content->keywords
		);
		$data['experiment_type'] = $this->experiment_types;
		
	    $this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp/addexp',$data);
		$this->load->view('include/footer');
	}
	
	/**
	 * Deal with the edit experiment action
	 * @param string/int $id
	 */
	public function doedit($id)
	{
		$user_id = $this->session->userdata('userid');
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('update_experiment') == FALSE)
		{
            $this->edit($id);
		}
		else
		{
			$para = array(
					'title' => $this->input->post('experiment_title'),
					'type_id' => $this->input->post('experiment_type'),
					'status' => $this->input->post('experiment_status'),
					'describe' => $this->input->post('experiment_describe'),
					'tools' => $this->input->post('experiment_tools'),
					'result' => $this->input->post('experiment_result'),
					'papers' => $this->input->post('experiment_papers')
					);
		     if($this->experiment_model->update_experiment($id,$user_id,$para))
		     {
                redirect("exp/showlist");
		     }
		     else {
		         $data['error']= '更新数据库错误';
		         //not $this->edit($data), add has para data
		         $this->add($data);
		     }
		} 	    
	}
	
	/**
	 * Show the experiments list of users
	 * @param string $type
	 */
	public function showlist($type = "all"){
		$username = $this->session->userdata('username');
		$data['username'] = $username ? $username : '无法获得';
		$user_id = $this->session->userdata('userid');
		$data["menu"] = "exp";
		$data['sidebar'] = $type;
		$data['all_experiments'] = $this->experiment_model->get_all_experiments_byuser($user_id,$type);
		$data['experiment_types'] = $this->experiment_types;
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp/showlist',$data);
		$this->load->view('include/footer');
	}
	
	
}
