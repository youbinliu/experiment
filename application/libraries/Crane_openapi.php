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
    private $client_id = '45715739559e2f6194b4c2959657910a';      // Needed by openapi authentication
    private $refresh_key = '6c7d0e2d9adb539f84727bd97dd637d3';    // Needed by openapi authentication
    private $token_key = '';                                      // Get after openapi authentication
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
	        'refresh_key' => $this->refresh_key,
	        'client_id'   => $this->client_id
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
	        $this->token_key = '';
	        return;
	    }
	    curl_close($auth_curl);
	    $post_data = json_decode( $response, TRUE);
	    $temp_tokey = array_key_exists('access_token', $post_data);
	    $this->token_key = $temp_tokey? $post_data['access_token']: '';
	}
	
	public function __call($method, $arguments)
	{
	    if (in_array($method, array('request_iaas','request_hpcpaas','request_usermanage','request_webpaas','request_report')))
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
	    $params['access_token'] = $this->token_key;
	    $params['client_id'] = $this->client_id;	    
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
	    return json_decode( $response, TRUE);	    	    
	}
	
	public function call_with_input_files($type,$params, $inputfiles)
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
		$url = $this->baseurl.'crane/'.$type;
		 
		//Add access_token and client_id to arguments
		$params['access_token'] = $this->token_key;
		$params['client_id'] = $this->client_id;
		$method_data = http_build_query($params, NULL, '&');
		return $url.'?'.$method_data;
	}
	
	private function is_auth()
	{
	    return $this->token_key ? TRUE : FALSE;
	}
	
	//Just for test, must delete after test OK!
	public function get_token_key()
	{
	    return $this->token_key;
	}
	
}