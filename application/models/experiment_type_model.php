<?php
/*
 * Experiment type 
 * 
 * Get the experiment type in database
 * 
 * @author lycc
 */
class Experiment_type_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	/**
	 * 
	 * Get the experiment type by id
	 * @param string/int $id
	 */
	public function getbyid($id)
	{
	    $query = $this->db->get_where('experiment_type', array('id' => $id));
	    if(! $query->num_rows())
	    {
	        return 'Error!';
	    }
	    return $query->row()->type;
	}
	
	/**
	 * 
	 * Get all the experiments types, return array of 'id'=>'type'.
	 */
	public function get_type_list()
	{
	    $type_list = array();
	    $this->db->select('id,type')->from('experiment_type');
	    $query = $this->db->get();
	    if($query->num_rows() > 0)
	    {
	        foreach ($query->result() as $row)
	        {
	            $type_list[$row->id] = $row->type;
	        }
	    }
	    return $type_list;
	}
	
	/**
	 * 
	 * Add another type
	 * @param string $type
	 * @param string $detail
	 */
	public function add($type, $detail)
	{
	    $data = array('type' =>$type, 'detail' =>$detail);
	    $this->db->insert('experiment_type', $data);
	    if($this->db->affected_rows() > 0)
	    {
	        return TRUE;
	    }
	    return FALSE;
	}
	
}

	