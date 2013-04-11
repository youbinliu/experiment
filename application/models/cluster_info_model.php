<?php
/**
 * 
 */
class Cluster_info_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function add_cluster_info($data)
	{
		$this->db->insert('cluster_info', $data);
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	public function get_user_clusters_data($user_id)
	{
		$cluster_list = array();
		$this->db->where('user_id',$user_id);
		$this->db->select('exp_id,cluster_id,master_vcpu,master_mem,slave_vcpu,slave_mem,slave_count');
		$this->db->order_by('cluster_id','desc');
		
		$query = $this->db->get('cluster_info');
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
				$cluster_list[$row->cluster_id] = array(
						'exp_id' => $row->exp_id,
						'master_vcpu' => $row->master_vcpu,
						'master_mem' => $row->master_mem,
						'slave_vcpu' => $row->slave_vcpu,
						'slave_mem' => $row->slave_mem,
						'slave_count' => $row->slave_count
				);
			}
		}
		return $cluster_list;
	}
	
	public function get_clusterid_by_userid($user_id)
	{
		$cluster_list= array();
		$this->db->where('user_id',$user_id);
		$this->db->select('cluster_id');
		$query = $this->db->get('cluster_info');
		$this->db->order_by('cluster_id','desc');
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row){
				$cluster_list[] = $row->cluster_id;
			}
		}
		return $cluster_list;
	}
	
	public function get_user_clusters_by_experiment($user_id,$exp_id)
	{
		$cluster_list = array();
		$this->db->where(array('exp_id'=>$exp_id, 'user_id'=>$user_id));
		$this->db->select('exp_id,cluster_id,master_vcpu,master_mem,slave_vcpu,slave_mem,slave_count');
		$query = $this->db->get('cluster_info');
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
				$cluster_list[$row->cluster_id] = array(
						'exp_id' => $row->exp_id,
						'master_vcpu' => $row->master_vcpu,
						'master_mem' => $row->master_mem,
						'slave_vcpu' => $row->slave_vcpu,
						'slave_mem' => $row->slave_mem,
						'slave_count' => $row->slave_count
				);
			}
		}
		return $cluster_list;
	}
	
	public function delete_cluster($cluster_id)
	{
		$this->db->delete('cluster_info',array('cluster_id' => $cluster_id));
		if($this->db->affected_rows() > 0){
			return TRUE;
		}
		return FALSE;
	}
	
	public function get_userid_by_clusterid($cluster_id)
	{
		$this->db->where('cluster_id',$cluster_id);
		$query = $this->db->get('cluster_info');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->user_id;
		}
		else{
			return -1;
		}
	}

	public function experiment_has_resources($exp_id){
		$this->db->where('exp_id',$exp_id);
		$query = $this->db->get('cluster_info');
		if($query->num_rows() > 0 ){
			return TRUE;
		}
		return FALSE;
	}
	
	
}