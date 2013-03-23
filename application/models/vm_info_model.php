<?php
/**
 * 
 */
class Vm_info_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();	    
		$this->load->database();
	}
	
	/**
	 * 
	 * Insert into db when vm is created.no check the uer_id when insert
	 * $data include exp_id,vm_id,user_id,vcpu,memory,image,key
	 * @param unknown_type $data
	 */
	public function add_vm_info($data)
	{
/*	    $exp_id = $config['exp_id'];
	    $vm_id = $config['vm_id'];
	    $vcpu = $config['vcpu'];
	    $memory = $config['memory'];
	    $image = $config['image'];
	    date_default_timezone_set('Asia/Shanghai');
		date_default_timezone_set('Asia/Shanghai');
		$data['start_time'] = date("Y-m-j H:i:s");*/
		$this->db->insert('vm_info', $data);
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Get the user vm data from dabase of all experiments
	 * @param string/int $user_id
	 * @return multitype:multitype:NULL
	 */
	public function get_user_vms_data($user_id)
	{
	    $vm_list = array();
	    $this->db->where('user_id',$user_id);
	    $this->db->select('exp_id,vm_id,key,vcpu,memory,image');
	    $this->db->order_by('vm_id','desc');
	    
	    $query = $this->db->get('vm_info');
	    if($query->num_rows() > 0)
	    {
	        foreach ($query->result() as $row) {
	            $vm_list[$row->vm_id] = array(
	                'exp_id' => $row->exp_id,
	                'vcpu' => $row->vcpu,
	                'memory' => $row->memory,
	                'key' => $row->key,
	                'image' => $row->image
	            );
	        }
	    }
	    return $vm_list;
	}
	
	/**
	 * Get the user vm data from dabase selected by experiment id
	 * @param string/int $user_id
	 * @param string/int $exp_id
	 * @return multitype:multitype:unknown NULL
	 */
	public function get_user_vms_by_experiment($user_id,$exp_id)
	{
	    $vm_list = array();
	    $this->db->where(array('exp_id'=>$exp_id, 'user_id'=>$user_id));
	    $this->db->select('vm_id,key,vcpu,memory,image');
	    $this->db->order_by('vm_id','desc');
	    
	    $query = $this->db->get('vm_info');
	    if($query->num_rows() > 0)
	    {
	        foreach ($query->result() as $row) {
	            $vm_list[$row->vm_id] = array(
	                'exp_id' => $exp_id,
	                'vcpu' => $row->vcpu,
	                'memory' => $row->memory,
	            	'key' => $row->key,
	                'image' => $row->image
	            );
	        }
	    }
	    return $vm_list;
	}
	
	/**
	 * Delete the vm by id
	 * @param string/int $vm_id
	 * @return boolean
	 */
	public function delete_vm($vm_id)
	{
	    $this->db->delete('vm_info',array('vm_id' => $vm_id));
	    if($this->db->affected_rows() > 0){
	        return TRUE;
	    }
	    return FALSE;
	}
	
	/**
	 * Get the user id by vmid
	 * @param string/int $vm_id
	 * @return number
	 */
	public function get_userid_by_vmid($vm_id)
	{
		$this->db->where('vm_id',$vm_id);
		$query = $this->db->get('vm_info');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->user_id;
		}
		else{
			return -1;
		}
	}
	
	
	
	
	
	
	

	public function update_vm_status($config)
	{
		$exp_id = $config['exp_id'];
		$vm_id = $config['vm_id'];
		$data = array(
				'start_time' => $config['start_time'],
				'status' => $config['status']
		);
		$this->db->where(array('exp_id'=>$exp_id,'vm_id'=>$vm_id));
		$this->db->update('vm_info', $data);
		//Let it returns TRUE,in case nothing changes!
		return TRUE;
		/*		if($this->db->affected_rows() > 0)
			{
		return TRUE;
		}
		return FALSE;*/
	}
	
	public function update_vm_port($config)
	{
		$exp_id = $config['exp_id'];
		$vm_id = $config['vm_id'];
		$data = array(
				'port' => $config['port'],
				'ipv6' => $config['ipv6'],
				'dns' => $config['dns']
		);
		$this->db->where(array('exp_id'=>$exp_id,'vm_id'=>$vm_id));
		$this->db->update('vm_info', $data);
		//Let it returns TRUE,in case nothing changes!
		return TRUE;
		/*		if($this->db->affected_rows() > 0)
			{
		return TRUE;
		}
		return FALSE;*/
	}	
	
    public function getbyid($id)
	{
	    $query = $this->db->get_where('experiment_type', array('id' => $id));
	    if(! $query->num_rows())
	    {
	        return 'Error!';
	    }
	    return $query->row()->type;
	}
}