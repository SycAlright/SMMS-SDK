<?php
namespace syc\sdk;

/**
 * smms-sdk (api_v2)
 * SM.MS图床的PHP_SDK，使用v2版本api
 * Author: Syc <www.php.wf>
 * PHP_Version > 5.5
 */

class smms {
	
	private static $time_out = 30;
	private static $upload_time_out = 100;
	private static $api = 'https://sm.ms/api/v2/';
 	private static $Authorization;
	
	/**
     * __construct
     * @param string $_auth
     * @return string null(success) / Info(error)
     */
	public function __construct($_auth)
	{
		if(null == $_auth) {
			exit('Authorization Error');
		}
		$this->Authorization = $_auth;
	}
	
	/**
     * User_Profile
     * @param string $_format
     * @return string $result(success) / $http_status(error)
     */
	public function User_Profile($_format='json')
	{
		$result = $this->curl_post('profile?format='.$_format);
		return $result;
	}
	
	/**
     * Temporary History - IP Based Temporary Upload History
     * @param string $_format
     * @return string $result(success) / $http_status(error)
     */
	public function Image_UploadHistoryByIp($_format='json')
	{
		$result = $this->curl_get('history?format='.$_format);
		return $result;
	}
	
	/**
     * Clear Temporary History - Clear IP Based Temporary Upload History
     * @param string $_format
     * @return string $result(success) / $http_status(error)
     */
	public function Image_UploadHistoryByIp_Clear($_format='json')
	{
		$result = $this->curl_get('clear?format='.$_format);
		return $result;
	}
	
	/**
     * Deletion - Image Deletion
	 * @param string $_hash
     * @param string $_format
     * @return string $result(success) / $http_status(error)
     */
	public function Image_Delete($_hash, $_format='json')
	{
		if(null == $_hash) {
			exit("Require Item Hash");
		}
		$result = $this->curl_get('delete/'.$_hash.'?format='.$_format);
		return $result;
	}
	
	/**
     * Upload History - Upload History
     * @param string $_format
     * @return string $result(success) / $http_status(error)
     */
	public function Image_UploadHistory($_format='json')
	{
		$result = $this->curl_get('upload_history?format='.$_format);
		return $result;
	}
	
	public function Image_Upload($_path, $_format='json')
	{
		$result = $this->curl_upload('upload?format='.$_format, $_path);
		return $result;
	}
	
	/** Private Function */

	/**
     * Curl_Get
     * @param string $_uri
     * @return string $result(success) / $http_status(error)
     */
    private function curl_get($_uri)
	{
        $header = array(
            'Authorization: '.$this->Authorization,
            'Content-Type: multipart/form-data'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$api . $_uri);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT,"smms-sdk_v2(Syc)");
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$time_out);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if(200 == $http_status)
        {
            return $result;
        }
        return $http_status;
    }
	
	/**
     * Curl_Post
     * @param string $_uri
     * @param array $_data
     * @return string $result(success) / $http_status(error)
     */
    private function curl_post($uri, $_data=array())
	{
        $header = array(
            'Authorization: '.$this->Authorization,
            'Content-Type: multipart/form-data'
        );
        $data = json_encode($_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$api . $uri);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT,"smms-sdk_v2(Syc)");
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$time_out);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if(200 == $http_status)
        {
            return $result;
        }
        return $http_status;
    }
	
	/**
     * Curl_Upload
     * @param string $_uri
     * @param array $_path
     * @return string $result(success) / $http_status(error)
     */
	public function curl_upload($uri, $_path)
	{
		$name = basename($_path);
		preg_match('/(.*?)\\.[A-Za-z0-9]+/', $name, $m);
		$name = $m[0];
		$type = mime_content_type($_path);
		$bits = new \CURLFile($_path, $type, $name);
		$data = array (
			'smfile' => $bits
		);
		//var_dump($data);
		$header = array(
            'Authorization:'.$this->Authorization,
            'Content-Type:multipart/form-data'
        );
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$api . $uri);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT,"smms-sdk_v2(Syc)");
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$upload_time_out);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if(200 == $http_status)
        {
            return $result;
        }
        return $http_status;
	}
}