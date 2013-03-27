<?php if (!defined('BASEPATH')) die();
class Ssh extends Main_Controller {
	
	public function __construct()
	{
		parent::__construct();
	
		$this->validLogin();
	}
	
	public function index(){
		$data["menu"] = "ssh";
		$this->load->view('templates/ssh',$data);
	}
	
}