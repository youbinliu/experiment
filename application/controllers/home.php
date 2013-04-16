<?php if (!defined('BASEPATH')) die();
/*
 * Home controller for user login
 * 
 * for user login
 * 
 * @author lycc
 */
class Home extends Main_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('user_model','experiment_model'));
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation','curl','session','crane_openapi'));
	}
	
	
	public function index(){
		$data['islogin'] = 0;
		if( $this->session->userdata('login_in')){
			$data['islogin'] = 1;
		}	
		
		$data['experiment_list'] = $this->experiment_model->get_all_experiments();
		$this->load->view('homepage/homehead',$data);
		$this->load->view('homepage/allexplist',$data);
		$this->load->view('include/footer');
	}
	
	public function show($exp_id){
		$data['islogin'] = 0;
		$user_id="";
		if( $this->session->userdata('login_in')){
			$data['islogin'] = 1;
			$user_id=$this->session->userdata('userid');
		}	
		if($rating=$this->experiment_model->get_user_rating($exp_id,$user_id)){
			$data['score']=$rating['score'];
			if(!empty($rating['user_in']))
				$data['user_in']=$rating['user_in'];
		}
		if($data['islogin']==0){
			$data['user_in']=true;
		}
		$content = $this->experiment_model->get_one_experiment_byid($exp_id);
		$relative = $this->experiment_model->get_experiments_relative_bystr($content->keywords,$exp_id);
		$data['experiment'] = $content;
		$data['relativexp'] = $relative;
		$data['from']="home";
		$this->load->view('homepage/homehead',$data);
		$this->load->view('homepage/showexp',$data);
		$this->load->view('include/footer');
	}
	
	
	/**
	 * Create the salt,random string to set the password
	 * @return string
	 */
	protected function _create_salt()
	{
		$this->load->helper('string');
		return sha1(random_string('alnum',16));
	}
	
	/**
	 * Show the login
	 */
	public function show_login(){
		if( $this->session->userdata('login_in')){
			redirect("exp/showlist");
		}			
		$this->load->view('include/header');
	    $this->load->view('user/login');
	    $this->load->view('include/footer');
	}
	
	/**
	 * Deal with the login action
	 */
	public function login(){
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
		if($this->form_validation->run('login') == FALSE)
		{
			$this->load->view('include/header');
			$this->load->view('user/login');
			$this->load->view('include/footer');
		}
		else
		{
		    $username = $this->input->post('login_username');
			$password = md5($this->input->post('login_password'));
			$access_array = $this->crane_openapi->user_get_access_token($username,$password);
		    if( empty($access_array)){
		    	$data['error'] = '远程认证错误！';
				$this->load->view('include/header');
				$this->load->view('user/login',$data);
				$this->load->view('include/footer');
				return;
			}
		    $data = array(
		    	'userid' => $this->user_model->get_user_id($username),
				'username' => $username,
				'client_id' => $access_array['client_id'],
				'access_token' => $access_array['access_token'],
				'login_in' => TRUE
			);
			$this->session->set_userdata($data);
			
		    redirect("exp/showlist");
		}
	}
	
	/**
	 * Logout
	 */
	public function logout(){
		$this->session->sess_destroy();
		redirect("home");
	}
	
	/**
	 * Check the username to see if valid
	 * @param string $username
	 * @return boolean
	 */
	public function username_check($username)
	{
		if( !$this->user_model->username_exists($username))
		{
			$this->form_validation->set_message('username_check','用户名不存在');
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * Check the email to see if valid
	 * @param string $password
	 * @return boolean
	 */
	public function password_check($password)
	{
		if($this->user_model->password_check($this->input->post('login_username'), $password))
		{
			return TRUE;
		}
		else {
			$this->form_validation->set_message('password_check', '用户名或密码不正确');
			return FALSE;
		}
	}
	
}

