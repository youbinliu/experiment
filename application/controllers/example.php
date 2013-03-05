<?php if (!defined('BASEPATH')) die();
class Example extends Main_Controller {
	
	public function template(){
		$data["menu"] = "example";
		$data['sidebar'] = "template";
		
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('example/template',$data);
		$this->load->view('include/footer');
	}
	
	public function add($template){
		$data["menu"] = "example";
		$data['sidebar'] = "";
		
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('example/add',$data);
		$this->load->view('include/footer');
		
	}
	
	public function results(){
		
		$data["menu"] = "example";
		$data['sidebar'] = "results";
		
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('example/results',$data);
		$this->load->view('include/footer');
	}
}
