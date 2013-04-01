<?php
/**
 * 
 */
class Iaas_util_model extends CI_Model
{
	
	private $cluster_template_list = array();
	private $job_template_list = array();
	
	public function __construct()
	{
		parent::__construct();	    
		$this->load->library(array('crane_openapi','session'));
	}
	
	/**
	 * Get key list,by openapi
	 * @param string $user_name
	 * @return multitype:|multitype:unknown
	 */
	public function get_key_list($user_name)
	{
	    $key_list = array();
	    $para_data = array(
            'method'=>'query_key',
            'site'=>'hust',
			'client_id' => $this->session->userdata('client_id'),
			'access_token' => $this->session->userdata('access_token')
     	);
     	$responce = $this->crane_openapi->request_iaas($para_data);
     	if( array_key_exists('error', $responce))
     	{
     	    return $key_list;
     	}
     	else
     	{
     	    foreach ($responce['key_list'] as $key_item){
     	        $key_list[] = $key_item[1];
     	    }
     	    return $key_list;
     	}
	}
	
	/**
	 * Get the image list , by openapi
	 * @param string $user_name
	 * @return unknown
	 */
	public function get_image_list($user_name)
	{
	    $image_list = array();
	    $para_data = array(
            'method'=>'get_image_list',
            'site'=>'hust',
			'client_id' => $this->session->userdata('client_id'),
			'access_token' => $this->session->userdata('access_token')
     	);
     	$responce = $this->crane_openapi->request_iaas($para_data);
	    if( array_key_exists('error', $responce))
     	{
     	    return $image_list;
     	}
     	else
     	{
     	    foreach ($responce['image_list'] as $key_item){
     	        $image_list[] = $key_item;
     	    }
     	    return $image_list;
     	}
	}
	
	public function get_cluster_template_list($user_name)
	{
		$cluster_template_list = array();
		$para_data = array(
				'method' => 'query_cluster_template',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
				);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);
		if( array_key_exists('error', $responce))
		{
			return $cluster_template_list;
		}
		else{
			foreach ($responce['info_list'] as $template_item){
				$cluster_template_list[$template_item['id']] = $template_item;
			}
			return $cluster_template_list;
		}
	}
	
	public function get_hpc_job_template($user_name)
	{
		$hpc_job_template = array();
		$para_data = array(
				'method' => 'get_mpi_image_list',
				'site' => 'hust',
				'client_id' => $this->session->userdata('client_id'),
				'access_token' => $this->session->userdata('access_token')
				);
		$responce = $this->crane_openapi->request_hpcpaas($para_data);
		if( array_key_exists('error', $responce)){
			return $hpc_job_template;
		}
		else{
			foreach ($responce['info_list'] as $hpc_job){
				$hpc_job_template[$hpc_job['id']] = $hpc_job;
			}
			return $hpc_job_template;
		}
	}
}