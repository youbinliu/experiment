<?php if (!defined('BASEPATH')) die();
class Diary extends Main_Controller {
	
	public function add(){
		$data["menu"] = "diary";
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
		$data["menu"] = "diary";
		$data['sidebar'] = "showlist";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/showlist',$data);
		$this->load->view('include/footer');
	}
	
	public function system(){
		$data["menu"] = "diary";
		$data['sidebar'] = "system";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('logs/system',$data);
		$this->load->view('include/footer');
		
	}
}