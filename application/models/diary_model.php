<?php
/**
 * Diary Model
 * 
 * Get the Diary information
 * 
 * @author lycc
 */
class Diary_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * Add diary
	 * @param string/int $user_id
	 * @param string/int $exp_id
	 * @param string $title
	 * @param string $content
	 * @return boolean
	 */
	public function add_diary($user_id,$exp_id,$title,$content){
		date_default_timezone_set('Asia/Shanghai');
		$data = array(
				'user_id' => $user_id,
				'exp_id' => $exp_id,
				'title'=>$title,
				'time' => date("Y-m-j H:i:s"),
				'content' => $content
		);
		$this->db->insert('diary', $data);
		if($this->db->affected_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Update Diary
	 * @param string/int $id
	 * @param string/int $user_id
	 * @param string/int $exp_id
	 * @param string $title
	 * @param string $content
	 * @return boolean
	 */
	public function update_diary($id,$user_id,$exp_id,$title,$content){
		$this->db->where('id',$id);
		$row = $this->db->get('diary')->row();
		if($user_id == $row->user_id){
			$data = array(
					'title' => $title,
					'content' => $content
			);
			$this->db->where('id',$id);
			$this->db->update('diary', $data);
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
	 * Delete the Diary, check the user_id
	 * @param string/int $user_id
	 * @param string/int $id
	 * @return boolean
	 */
	public function delete_diary($user_id,$id){
		$this->db->where('id',$id);
		$query = $this->db->get('diary');
		if($query->num_rows() > 0){
			$row = $query->row();
			if($user_id == $row->user_id){
				$query = $this->db->delete('diary',array('id'=>$id));
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
	 * Get all the diary of the user
	 * @param string/int $user_id
	 * @return multitype:multitype:NULL
	 */
	public function get_all_diary_byuser($user_id){
		$diary_list = array();
		$query = $this->db->get_where('diary',array('user_id' => $user_id));
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
				$diary_list[$row->id] = array(
						'exp_id' => $row->exp_id,
						'title' => $row->title,
						'time' => $row->time,
						'content' => $row->content
				);
			}
		}
		return $diary_list;
	}
	
	public function get_user_diary_by_experiment($user_id,$exp_id){
		$diary_list = array();
		$query = $this->db->get_where('diary',array('user_id' => $user_id,'exp_id'=>$exp_id));
		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $row) {
				$diary_list[$row->id] = array(
						'exp_id' => $row->exp_id,
						'title' => $row->title,
						'time' => $row->time,
						'content' => $row->content
				);
			}
		}
		return $diary_list;
	}
	
	/**
	 * Get one diary item of the user
	 * @param string/int $user_id
	 * @param string/int $id
	 * @return multitype:string |Ambigous <multitype:, multitype:NULL >
	 */
	public function get_one_diary_byid($user_id,$id){		
		$diary= array();
		$this->db->select('diary.*,exp.title as exptitle');
		$this->db->from('diary');
		$this->db->join('experiment as exp','diary.exp_id = exp.id');
		$this->db->where('diary.id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			if($user_id == $row->user_id){
				$diary= array(
						'exp_id' => $row->exp_id,
						'title' => $row->title,
						'time' => $row->time,
						'exptitle' => $row->exptitle,
						'content' => $row->content
				);
			}
			else{
				return array('error'=>"You can't get the diary infomation of others!");
			}
		}
		return $diary;
	}
	
	/**
	 * Get the userid by diaryid
	 * @param string/int $id
	 * @return number
	 */
	public function get_userid_by_diaryid($id){
		$this->db->where('id',$id);
		$query = $this->db->get('diary');
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
	 * Get experiment id by diary id
	 * @param string/int $id
	 * @return number
	 */
	public function get_expid_by_diaryid($id){
		$this->db->where('id',$id);
		$query = $this->db->get('diary');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->exp_id;
		}
		else{
			return -1;
		}
	}
	
	
}