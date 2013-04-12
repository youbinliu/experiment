<?php
/*
 * Experiment Model
 * 
 * Get the experiment list.
 * 
 * @author lycc
 */
class Experiment_model extends CI_Model
{
    private $_ci;                                                 // CodeIgniter instance
    private $experiment_type_list = array();                      // Type id and type detail list
    
    /**
     * 
     * Set the private value experiment_type_list
     */
    private function get_experiment_types()
    {
        $this->experiment_type_list =$this->experiment_type_model->get_type_list();
    }
    
	public function __construct()
	{
		parent::__construct();
		$this->_ci = & get_instance();
	    $this->load->database();
	    $this->load->model(array('experiment_type_model','vm_info_model','hpcjob_info_model','cluster_info_model'));
	    $this->get_experiment_types();
	}
	
	/**
	 * 
	 * Add an experiment
	 * @param string $title
	 * @param string/int $user_id
	 * @param string/int $type_id
	 * @param string $status
	 * @param string $describe
	 * @param string $keyword
	 */
	public function add_experiment($title,$user_id,$type_id,$status,$describe,$keyword="")
	{
	    date_default_timezone_set('Asia/Shanghai');
		$data = array(
			'title'=>$title, 
			'type_id'=>$type_id,
			'user_id' => $user_id,
		    'start_time' => date("Y-m-j H:i:s"), 
			'status'=>$status, 
			'describe'=>$describe,
		    'keywords'=>$keyword
		);
		$this->db->insert('experiment', $data);
		//Let it returns TRUE,in case nothing changes!
		return TRUE;
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * 
	 * Update an experiment's description,check the user at the same time
	 * @param string/int $id
	 * @param string/int $user_id
	 * @param array $para
	 * @return boolean
	 */
	public function update_experiment($id,$user_id,$para)
	{
		$this->db->where('id',$id);
		$row = $this->db->get('experiment')->row();
		if($user_id == $row->user_id){
			$this->db->where('id',$id);
			$this->db->update('experiment', $para);
			//Let it returns TRUE,in case nothing changes!
			return TRUE;
			/*		if($this->db->affected_rows() > 0)
			 {
			return TRUE;
			}
			return FALSE;*/
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * 
	 * Delete an existing experiment,check the user at the same time
	 * @param string/int $user_id
	 * @param string/int $id
	 */
	public function delete_experiment($user_id,$id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('experiment');
		if($query->num_rows() > 0){
			$row = $query->row();
			if($user_id == $row->user_id){
				$query = $this->db->delete('experiment',array('id'=>$id));
				if($this->db->affected_rows() > 0)
				{
					return TRUE;
				}
				return FALSE;
			}
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * 
	 * Get the experiment detail list by type and user_id,check the user at the same time
	 * @param string/int $user_id
	 * @param string $type
	 */
	public function get_all_experiments_byuser($user_id,$type)
	{
	    $experiment_list = array();
	    $this->db->select('exp.*,type.type');
	    $this->db->from('experiment as exp');
	    $this->db->join('experiment_type as type','exp.type_id = type.id');
	    $this->db->order_by('exp.id','desc');
	    
	    if($type == 'all')
	    {
	        $this->db->where('user_id', $user_id);
	    }
	    elseif ($type == 'finished')
	    {
	    	$this->db->where('user_id',$user_id);
	        $this->db->where('status','Done');
	    }
	    else
	    {
	    	$this->db->where('user_id',$user_id);
	        $this->db->where('status !=','Done');	        
	    }
	    $query = $this->db->get();
	    if($query->num_rows() > 0)
	    {
	        foreach ($query->result() as $row) {
	            $experiment_list[$row->id] = array(
	                'type_id' => $row->type_id,
	            	'type' => $row->type,
	                'title' => $row->title,
	                'status' => $row->status,
	                'start_time' => $row->start_time,
	                'describe' => $row->describe //mb_substr($row->describe, 0, 30, 'utf-8')
	            );
	        }
	    }
	    return $experiment_list;
	}
	
	
	public function get_all_experiments()
	{
		$experiment_list = array();
		$this->db->select('exp.*,type.type,user.username');
		$this->db->from('experiment as exp');
		$this->db->join('experiment_type as type','exp.type_id = type.id');
		$this->db->join('user','exp.user_id = user.id');
		$this->db->order_by('exp.id','desc');
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
				$experiment_list[$row->id] = array(
						'user_id' => $row->user_id,
						'type_id' => $row->type_id,
						'type' => $row->type,
						'username' => $row->username,
						'title' => $row->title,
						'status' => $row->status,
						'start_time' => $row->start_time,
						'describe' => $row->describe //mb_substr($row->describe, 0, 30, 'utf-8')
				);
			}
		}
		return $experiment_list;
	}

	/**
	 * Get one experiment detail by id and user_id,check the user at the same time
	 * @param string/int $id
	 * @return multitype:string |Ambigous <multitype:, multitype:NULL >
	 */
	public function get_one_experiment_byid($id)
	{
		$experiment= array();
		$this->db->select('exp.*,type.type,user.username');
		$this->db->from('experiment as exp');
		$this->db->join('experiment_type as type','exp.type_id = type.id');
		$this->db->join('user','exp.user_id = user.id');
		$this->db->where('exp.id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$experiment= $query->row();
		}
		return $experiment;
	}
	
	public function get_userid_by_expid($exp_id)
	{
		$this->db->where('id',$exp_id);
		$query = $this->db->get('experiment');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->user_id;
		}
		else{
			return -1;
		}
	}
	
	/**
	 * get the id and title list owned by the user_id
	 * @param string/int user_id
	 * @return multitype:NULL
	 */
	public function get_experiments_id_title($user_id)
	{
	    $experiment_list = array();
	    $this->db->where('user_id',$user_id);
	    $this->db->select('id,title');
	    $query = $this->db->get('experiment');	        
	    if($query->num_rows() > 0)
	    {
	        foreach ($query->result() as $row) {
	            $experiment_list[$row->id] = $row->title;
	        }
	    }
	    return $experiment_list;
	}
	
	/**
	 * get the id and title list relative to current experiment by keywords
	 * @param string keywords,int/string id
	 * @return multitype:NULL
	 */
	public function get_experiments_relative_bystr($keywords,$id)
	{
		
		$experiment_list = array();
		if(!$keywords)return $experiment_list;
		//str_replace("，", ",", $keywords);
		//$keys=explode(",",trim($keywords));
		$keys=explode(" ",trim($keywords));
		$sql="select id,title from experiment where ";
		/*if ($keys) {
			$this->db->like('keywords',$keys[0]);
			for($i=1;$i<count($keys);$i++){
				$this->db->or_like('keywords',$keys[$i]);
			}
			$this->db->where('id<>',$id);
			$this->db->select('id,title');
			$query = $this->db->get('experiment');
			
			if($query->num_rows() > 0)
	    	{
	       		foreach ($query->result() as $row) {
	            	$experiment_list[$row->id] = $row->title;
	        	}
	    	}
		}*/
		if($keys){
			$sql.="keywords like '%".$keys[0]."%' ";
			for($i=1;$i<count($keys);$i++){
				$sql.="or keywords like '%".$this->db->escape_like_str($keys[$i])."%' ";
			}
			$sql.=";";
			$query = $this->db->query($sql);
			if($query->num_rows() > 0)
	    	{
	       		foreach ($query->result() as $row) {
	       			if($row->id!=$id)
	            		$experiment_list[$row->id] = array('title'=>$row->title);
	            	
	        	}
	    	}
		}
		return $experiment_list;
}

	public function experiment_has_resources($exp_id){
		$result = FALSE;
		$result = $result||$this->vm_info_model->experiment_has_resources($exp_id);
		$result = $result||$this->cluster_info_model->experiment_has_resources($exp_id);		
		$result = $result||$this->hpcjob_info_model->experiment_has_resources($exp_id);
		return $result;
//>>>>>>> 6556bcc028f5c833521070c85e95fa84b02a43e0
	}
}