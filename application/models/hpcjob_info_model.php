<?php
/**
 * 
 */
class Hpcjob_info_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function add_job_info($para){
		$this->db->insert('hpcjob_info', $para);
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	public function get_user_jobs_data($user_id){
		$jobs_list = array();
		$this->db->select('hpcjob_info.*,exp.title as exptitle');
		$this->db->from('hpcjob_info');
		$this->db->join('experiment as exp','hpcjob_info.exp_id = exp.id');
		$this->db->where('hpcjob_info.user_id',$user_id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row){
				$jobs_list[$row->job_id] = array(
						'job_id' =>$row->job_id,
						'exptitle' => $row->exptitle,
						'template_id' => $row->template_id,
						'command' => $row->command,
						'node_count' => $row->node_count,
						'user_id' => $row->user_id,
						'exp_id' => $row->exp_id
				);
			}
		}
		return $jobs_list;
	}
	
	public function get_user_jobs_by_experiment($user_id,$exp_id){
		$jobs_list = array();
		$this->db->select('hpcjob_info.*,exp.title as exptitle');
		$this->db->from('hpcjob_info');
		$this->db->join('experiment as exp','hpcjob_info.exp_id = exp.id');
		$this->db->where(array('hpcjob_info.exp_id'=>$exp_id, 'hpcjob_info.user_id'=>$user_id));
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row){
				$jobs_list[$row->job_id] = array(
						'job_id' =>$row->job_id,
						'exptitle' => $row->exptitle,
						'template_id' => $row->template_id,
						'command' => $row->command,
						'node_count' => $row->node_count,
						'user_id' => $row->user_id,
						'exp_id' => $row->exp_id
				);
			}
		}
		return $jobs_list;
	}
	
	public function delete_job($job_id){
		$this->db->delete('hpcjob_info',array('job_id' => $job_id));
		if($this->db->affected_rows() > 0){
			return TRUE;
		}
		return FALSE;
	}
	
	public function get_userid_by_jobid($job_id){
		$this->db->where('job_id',$job_id);
		$query = $this->db->get('hpcjob_info');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->user_id;
		}
		else{
			return -1;
		}
	}
	
}