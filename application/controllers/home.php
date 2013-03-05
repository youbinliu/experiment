<?php if (!defined('BASEPATH')) die();
class Home extends Main_Controller {

   public function index()
	{
      redirect("exp/showlist");
	}
	
	public function register()
	{
      	$this->load->view('include/header');
	    $this->load->view('user/register');
	    $this->load->view('include/footer');
	}
	
	public function doregister(){
		redirect("home/login");
	}
	
	public function login(){
		$this->load->view('include/header');
	    $this->load->view('user/login');
	    $this->load->view('include/footer');
	}
	
	public function dologin(){
		redirect("home/");
	}
	
	public function logout(){
		redirect("home/login");
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
