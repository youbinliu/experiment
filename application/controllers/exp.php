<?php if (!defined('BASEPATH')) die();
class Exp extends Main_Controller {
	
	
	public function add(){
		$data["menu"] = "exp";
		$data['sidebar'] = "add";
		$data['action'] = "add";
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp/addexp',$data);
		$this->load->view('include/footer');
		
	}
	
	public function delete($id){
		
	}
	
	public function show($id){
		$data["menu"] = "exp";
		$data['sidebar'] = "show";
		$data['action'] = "show";
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp//addexp',$data);
		$this->load->view('include/footer');
	}
	
	public function edit($id){
		$data["menu"] = "exp";
		$data['sidebar'] = "edit";
		$data['action'] = "edit";
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp/addexp',$data);
		$this->load->view('include/footer');
	}
	
	public function showlist($type = "all"){
		$data["menu"] = "exp";
		$data['sidebar'] = $type;
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('exp/showlist',$data);
		$this->load->view('include/footer');
	}
	
	
}
