<?php
/*
 * Register controller
 * 
 * for user register
 * 
 * @author lycc
 */

class Register extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->helper(array('form','url'));
		$this->load->library(array('form_validation','crane_openapi','session'));
	}
	
	/**
	 * Create the salt for password
	 * @return string
	 */
	protected function _create_salt()
	{
		$this->load->helper('string');
		return sha1(random_string('alnum',16));
	}
	
	/**
	 * Check the register action by openapi
	 */
	public function check_register()
	{
		$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');		
		if( $this->form_validation->run('register') == FALSE)
		{
      		$this->load->view('include/header');
	    	$this->load->view('user/register');
	    	$this->load->view('include/footer');
		}
		else
		{
			$username = $this->input->post('username');
			$salt = $this->_create_salt();
			$password = md5($salt.$this->input->post('password'));
			$email = $this->input->post('email');
			
			//the openapi register interface
			$para_data = array(
                'method'=>'register',
                'new_name'=>$this->input->post('username'),
                'site'=>'hust',
			    'user_site' => 'hust',
			    'password'=> $this->input->post('password'),
			    'mailbox' => $this->input->post('email'),
			    'service' => 'IaaS,Hpc',
			    'tenement' => 'CommonUser',
			    'is_global' => 'false'
         	);
         	$responce =$this->crane_openapi->request_usermanage($para_data);
         	if( array_key_exists('error', $responce))
         	{
         	    $data['error']= $responce['error'];
		    	$this->load->view('include/header');
	    		$this->load->view('user/register',$data);
	    		$this->load->view('include/footer');
	    		return;         	    
         	}
         	elseif($this->user_model->add_user($username, $password, $email,$salt))
			{
				redirect("home/show_login");
			}
			else
			{
				$data['error']="注册用户错误！";
		    	$this->load->view('include/header');
	    		$this->load->view('user/register',$data);
	    		$this->load->view('include/footer');				
			}
		}
	}	
	
	/**
	 * Show the register web page
	 */
	public function show_register(){
		if( $this->session->userdata('login_in')){
			redirect("exp/showlist");
		}
		$this->load->view('include/header');
		$this->load->view('user/register');
		$this->load->view('include/footer');
	}
	
	/**
	 * Check the username to see if valid
	 * @param string $username
	 * @return boolean
	 */
	public function username_exists($username)
	{
	    //
	    return TRUE;
		if( $this->user_model->username_exists($username))
		{
			$this->form_validation->set_message('username_exists','用户名已存在');
			return FALSE;
		}
		return TRUE;
	}
	
	/**
	 * Check the email to see if valid
	 * @param string/int $email
	 * @return boolean
	 */
	public function email_exists($email)
	{
	    //
	    return TRUE;
		if($this->user_model->email_exists($email))
		{
			$this->form_validation->set_message('email_exists','邮箱已被注册');
			return FALSE;
		}
		return TRUE;
	}
	
}