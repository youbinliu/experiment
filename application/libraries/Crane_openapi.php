<?php defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * CodeIgniter User's Class of crane_openapi
 *
 * Take the authentication,and get data from Crane's OpenAPI
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	lycc
 */


/* End of file Crane_opanapi.php */
/* Location: ./application/libraries/Crane_opanapi.php */



class Crane_openapi
{
    private $_ci;                                                 // CodeIgniter instance
    private $baseurl = 'https://cranebeta.hustcloud.com/';        // Base url for crane openapi
    //Note that the public_client_id and public_refresh_key are used when user register and auth,you can do nothing other than these
    private $public_client_id = '92000ab0a3e82738629874287346fbd2';      // Needed by openapi authentication
    private $public_refresh_key = '0e7e5jur8473ht911f9f8a9bad29072a';    // Needed by openapi authentication
    private $public_token_key = '';
    
    private $response = '';                                       // Assumed to be the post responces info
    

	function __construct()
	{
		$this->_ci = & get_instance();
		log_message('debug', 'Crane_openapi Class Initialized');
	}
	
	//Take the authentication ,use the static client_id and refresh_key
	private function get_auth($method = 'auth')
	{
	    $auth = array(
	        'refresh_key' => $this->public_refresh_key,
	        'client_id'   => $this->public_client_id
	    );
	    $auth_data = http_build_query($auth, NULL, '&');
	    $url = $this->baseurl.$method;
	    
	    $auth_curl = curl_init();
	    curl_setopt( $auth_curl, CURLOPT_URL, $url);
	    curl_setopt( $auth_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt( $auth_curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt( $auth_curl, CURLOPT_POST, 1);
	    curl_setopt( $auth_curl, CURLOPT_POSTFIELDS, $auth_data);
	    
	    $response = curl_exec( $auth_curl);
	    if( curl_errno($auth_curl)){
	        $this->public_token_key = '';
	        return;
	    }
	    curl_close($auth_curl);
	    $post_data = json_decode( $response, TRUE);
	    $temp_tokey = array_key_exists('access_token', $post_data);
	    $this->public_token_key = $temp_tokey? $post_data['access_token']: '';
	}
	
	private function get_access_token($client_id, $refresh_token)
	{
		$auth = array(
			'refresh_key' => $refresh_token,
			'client_id' => $client_id
		);
	    $auth_data = http_build_query($auth, NULL, '&');
	    $url = $this->baseurl.'auth';
	    $auth_curl = curl_init();
	    curl_setopt( $auth_curl, CURLOPT_URL, $url);
	    curl_setopt( $auth_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt( $auth_curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt( $auth_curl, CURLOPT_POST, 1);
	    curl_setopt( $auth_curl, CURLOPT_POSTFIELDS, $auth_data);
	    
	    $response = curl_exec( $auth_curl);
	    if( curl_errno($auth_curl)){
	        return '';
	    }
	    curl_close($auth_curl);
	    $post_data = json_decode( $response, TRUE);
	    $temp_tokey = array_key_exists('access_token', $post_data);
	    return $temp_tokey? $post_data['access_token']: '';		
	}

	public function user_get_register($param){
		//If not take authentication,take it
	    if( ! $this->is_auth())
	    {
	        $this->get_auth();
	    }
	    //If the authentication with wrong, return error
	    if( ! $this->is_auth())
	    {
			return array('error'=>'Error When Get Public Auth!');
	    }
		$param['client_id'] = $this->public_client_id;
		$param['access_token']= $this->public_token_key;
		$register_data = http_build_query($param, NULL, '&');
		$url = $this->baseurl.'crane/usermanage';
		
		$register_curl = curl_init();
		curl_setopt( $register_curl, CURLOPT_URL, $url);
	    curl_setopt( $register_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt( $register_curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt( $register_curl, CURLOPT_POST, 1);
	    curl_setopt( $register_curl, CURLOPT_POSTFIELDS, $register_data);
	    
	    $response = curl_exec( $register_curl);
		if( curl_errno( $register_curl)){
			return array('error'=>'Curl Error When Register!');
		}
		curl_close($register_curl);
		$post_data = json_decode( $response, TRUE);
		if( array_key_exists('error', $post_data)){
			return array('error'=>'Error Register!');
		}
	    return $post_data['register_status'];
	}
	
	public function user_get_access_token($username,$password)
	{
		//If not take authentication,take it
	    if( ! $this->is_auth())
	    {
	        $this->get_auth();
	    }
	    //If the authentication with wrong, return error
	    if( ! $this->is_auth())
	    {
	        return '';
	    }
		$auth = array(
			'client_id' => $this->public_client_id,
			'access_token' => $this->public_token_key,
			'method' =>  'check_user',
			'site' => 'hust',
			'user_name' => $username,
			'pass_word' => $password
		);
		$auth_data = http_build_query($auth, NULL, '&');
		$url = $this->baseurl.'crane/usermanage';
		
		$auth_curl = curl_init();
		curl_setopt( $auth_curl, CURLOPT_URL, $url);
	    curl_setopt( $auth_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt( $auth_curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt( $auth_curl, CURLOPT_POST, 1);
	    curl_setopt( $auth_curl, CURLOPT_POSTFIELDS, $auth_data);
	    
	    $response = curl_exec( $auth_curl);
		if( curl_errno( $auth_curl)){
			return '';
		}
		curl_close($auth_curl);
		$post_data = json_decode( $response, TRUE);
		if( array_key_exists('error', $post_data)){
			return 'error';
		}
		$client_id = $post_data['client_id'];
		$refresh_token = $post_data['client_key'];
		// return array($client_id,$refresh_token);
		$auth_array = array(
			'client_id' => $client_id,
			'access_token' => $this->get_access_token($client_id, $refresh_token)
		);
	    return $auth_array;
	}
	
	public function __call($method, $arguments)
	{
	    if (in_array($method, array('request_iaas','request_hpcpaas','request_webpaas','request_report')))
	    {
	        //Take off the 'request_' and past iaas/hpc/user/webpaas to _simple_call
	        $verb = str_replace('request_', '', $method);
	        array_unshift($arguments, $verb);
	        return call_user_func_array(array($this, '_simple_call'), $arguments);
	    }
	}
    
	
	/*
	 * SIMPLE METHODS
	 * Using these methods you can get the iaas/hpc/webpass data and operations by openapi
	 */
	public  function _simple_call($method, $params = array())
	{
	    //If not take authentication,take it
	    if( ! $this->is_auth())
	    {
	        $this->get_auth();
	    }
	    //If the authentication with wrong, return error
	    if( ! $this->is_auth())
	    {
	        return array('error' => 'Get openapi authentication error!');
	    }
	    //Generate the post url
	    $url = $this->baseurl.'crane/'.$method;
	    
	    //Add access_token and client_id to arguments    
	    $method_data = http_build_query($params, NULL, '&');
	    $method_curl = curl_init();
	    curl_setopt( $method_curl, CURLOPT_URL, $url);
	    curl_setopt( $method_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt( $method_curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt( $method_curl, CURLOPT_POST, 1);
	    curl_setopt( $method_curl, CURLOPT_POSTFIELDS, $params);
	    
	    $response = curl_exec( $method_curl);
	    if( curl_errno($method_curl)){
	        return array('error'=>'Get openapi data curl error!');
	    }
	    curl_close($method_curl);
		$result = json_decode( $response, TRUE);
	    return $result == null ? array('error' => 'Error decoding JSON') : $result;    
	}
	
	private function is_auth()
	{
	    return $this->public_token_key ? TRUE : FALSE;
	}
	
	
}