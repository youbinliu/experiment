<?php
class Main_Controller extends MY_Controller 
{
   
   public  $userdata;
   function __construct()
   {
      
      parent::__construct();
      $this->userdata = array();
   }    
   
   public function validLogin(){
      $this->load->library('session');
	  $username = $this->session->userdata('username');
	  
      if(isset($username) && !empty($username))
      {
          $userdata["username"] = $username;
          return true;
      }else{
          redirect("home/show_login");
      }
           
   }
}
