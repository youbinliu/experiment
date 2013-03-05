<?php if (!defined('BASEPATH')) die();
class Resource extends Main_Controller {
	
	
	public function info(){
		
		$data["menu"] = "resource";
		$data['sidebar'] = "info";
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/info',$data);
		$this->load->view('include/footer');
		
	}
	
	public function add($eid=0){
		
		$data["menu"] = "resource";
		$data['sidebar'] = "add";
		$data['eid'] = $eid;
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/add',$data);
		$this->load->view('include/footer');
	}
	
	public function show($eid){
		$data["menu"] = "resource";
		$data['sidebar'] = "show";
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('addexp',$data);
		$this->load->view('include/footer');
	}
	
	
	
	public function showlist(){
		$data["menu"] = "resource";
		$data['sidebar'] = "showlist";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/showlist',$data);
		$this->load->view('include/footer');
	}
	
	public function addcluster($eid=0){
		
		$data["menu"] = "resource";
		$data['sidebar'] = "addcluster";
		$data['eid'] = $eid;
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/addcluster',$data);
		$this->load->view('include/footer');
	}
		
	
	public function showclusterlist(){
		$data["menu"] = "resource";
		$data['sidebar'] = "allcluster";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/showclusterlist',$data);
		$this->load->view('include/footer');
	}
	
	
	public function createkey(){
		$data["menu"] = "resource";
		$data['sidebar'] = "createkey";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/createkey',$data);
		$this->load->view('include/footer');
	}
	
	public function keylist(){
		$data["menu"] = "resource";
		$data['sidebar'] = "keylist";
		
		$this->load->view('include/header');
		$this->load->view('templates/menu',$data);
		$this->load->view('resource/keylist',$data);
		$this->load->view('include/footer');
	}
	
}
