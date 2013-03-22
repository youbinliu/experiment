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
		if( $this->session->userdata('login_in')){
			$data['islogin'] = 1;
		}	
		$data['experiment'] = $this->experiment_model->get_one_experiment_byid($exp_id);
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
		    $data = array(
		    	'userid' => $this->user_model->get_user_id($username),
				'username' => $username,
				'login_in' => TRUE				
			);
			$this->session->set_userdata($data);
			
		    redirect("exp/showlist");

/*			$para_data = array(
                'method'=>'register',
                'new_name'=>'lycc',
                'site'=>'hust',
			    'user_site' => 'hust',
			    'password'=> '111',//$this->input->post('password')
			    'mailbox' => $this->input->post('email'),
			    'service' => 'IaaS,Hpc',
			    'tenement' => 'CommonUser',
			    'is_global' => 'false',
         	);
         	var_dump($this->crane_openapi->request_usermanage($para_data));*/
		    //var_dump($this->crane_openapi->get_auth());
		    //var_dump($this->crane_openapi->get_token_key());
/*			$data = array(
				'username' => $this->input->post('login_username'),
				'login_in' => TRUE				
			);
			$this->session->set_userdata($data);
			$auth = array(
				'refresh_key'=>'6c7d0e2d9adb539f84727bd97dd637d3',
				'client_id'=>urlencode('45715739559e2f6194b4c2959657910a')
			);
			$auth_data = http_build_query($auth, NULL, '&');
			$url = 'https://cranebeta.hustcloud.com/auth';
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_data);
			$response = curl_exec($ch);
			if(curl_errno($ch)){
				echo curl_error($ch);
			}			
			curl_close($ch);
			//$responce = $this->curl->simple_post('',$auth);
			$post_data = json_decode($response,TRUE);
			$token = $post_data['access_token'];
			echo $token;			
			$ch = curl_init();
			$action_url = 'https://cranebeta.hustcloud.com/crane/usermanage';
         	curl_setopt($ch, CURLOPT_URL, $action_url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $para_data);
			$response = curl_exec($ch);
			if(curl_errno($ch)){
				echo curl_error($ch);
			}			
			curl_close($ch);
			var_dump(array($para_data,$response));
			print_r(json_decode($response));			
			//$responce = $this->curl->simple_post('',$auth);
			//print_r(json_decode($response,TRUE));
			//var_dump($token['access_token']);
			//$data['content'] = json_decode($responce);
			//$data['content'] = 'test';
			//$this->load->view('testview',$data);
			//redirect("exp/showlist");
 
			 */
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

