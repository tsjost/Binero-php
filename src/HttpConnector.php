<?php
namespace tsjost\Binero;

class HttpConnector implements Connector
{
	private $auth_token;
	private $api_endpoint;

	public function __construct($api_endpoint)
	{
		$this->api_endpoint = $api_endpoint;
	}

	public function setAuthToken($auth_token)
	{
		$this->auth_token = $auth_token;
	}

	public function request($method_name, $http_method, array $params)
	{
		$full_uri = $this->api_endpoint . $method_name;
		$params_string = http_build_query($params);

		$o = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
		);

		if ( ! empty($this->auth_token)) {
			$o[CURLOPT_HTTPHEADER][] = 'Authorization: Bearer '. $this->auth_token;
		}

		if ($http_method == Connector::POST) {
			$o[CURLOPT_POSTFIELDS] = $params_string;
		} else {
			$full_uri .= '?'. $params_string;
		}

		$c = curl_init($full_uri);
		curl_setopt_array($c, $o);
		$ret = curl_exec($c);
		curl_close($c);

		$json = json_decode($ret, true);

		return $json;
	}
}
