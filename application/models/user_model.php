<?php
/*
 * User_model
 * 
 * For users register and login checking.
 * 
 * @author lycc
 */
class User_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();	    
		$this->load->database();
	}
	
	/**
	 * Add a new user
	 * 
	 * This function create a new user.
	 * 
	 * @todo
	 * 
	 * @param string username
	 * @param string password
	 * @param string email
	 * @param string salt
	 */
	public function add_user($username, $password, $email, $salt)
	{
		$data = array('username'=>$username, 'password'=>$password, 'email'=>$email, 'salt'=>$salt);
		$this->db->insert('user', $data);
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Get the user id by username
	 * @param string $username
	 * @return number
	 */
	public function get_user_id($username)
	{
		$this->db->select('id')->from('user')->where('username', $username);
		$query = $this->db->get();
		if( !$query->num_rows()){
			return -1;
		}
		else{
			return $query->row()->id;
		}
	}
	
	public function get_username_list(){
		$username_list = array();
		$this->db->select('username,id')->from('user');
		$query = $this->db->get();
		if( $query->num_rows()){
			foreach ($query->result() as $row) {
				$username_list[$row->id] = $row->username;
			}
		}
		return $username_list;
	}
	
	/**
	 * 
	 * Check if the password is correct.
	 * 
	 * @param string $username
	 * @param string $password
	 */
	public function password_check($username, $password)
	{
		$query = $this->db->get_where('user', array('username' => $username));
		if( !$query->num_rows())
		{
			return FALSE;	
		}
		$salt = $query->row()->salt;
		$true_password = $query->row()->password;
		
		if($true_password == md5($salt.$password))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * 
	 * Check if the user exists
	 * @param string $username
	 */
	public function username_exists($username)
	{
		$query = $this->db->get_where('user',array('username' => $username));
		return $query->num_rows() ? TRUE : FALSE;
	}
	
	/**
	 * 
	 * Check if the email given exists
	 * @param string $email
	 */
	public function email_exists($email)
	{
		$query = $this->db->get_where('user',array('email' => $email));
		return $query->num_rows() ? TRUE : FALSE;
	}
}
