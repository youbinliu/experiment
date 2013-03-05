<?php if (!defined('BASEPATH')) die();
class Logs extends Main_Controller {
	
	public function add(){
		$data["menu"] = "logs";
		$data['sidebar'] = "add";
		$data['action'] = "add";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/add',$data);
		$this->load->view('include/footer');
	}
	
	public function doadd(){
		
	}
	
	public function edit($lid){
		
		
	}
	
	public function delete($id){
		
		
	}
	
	public function show($lid){
		
	}
	
	public function showlist(){
		$data["menu"] = "logs";
		$data['sidebar'] = "showlist";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/showlist',$data);
		$this->load->view('include/footer');
	}
	
	public function system(){
		$data["menu"] = "logs";
		$data['sidebar'] = "system";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/system',$data);
		$this->load->view('include/footer');
		
	}
}