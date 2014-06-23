<?php
namespace brajox\Binero;

class Client
{
	private $Connector;

	public function __construct(Connector $Connector)
	{
		$this->Connector = $Connector;
	}

	public function setAuthToken($auth_token)
	{
		$this->Connector->setAuthToken($auth_token);
	}

	private function call($method_name, $http_method, array $params)
	{
		return $this->Connector->call($method_name, $http_method, $params);
	}

	private function getErrorString($json_ret)
	{
		$error_msg = 'Unknown';

		if (isset($json_ret['error'])) {
			if (isset($json_ret['error_description'])) {
				$error_msg = $json_ret['error_description'] .' ('. $json_ret['error'] .')';
			} else {
				$error_msg = $json_ret['error'];
			}
		} else if (isset($json_ret['Message'])) {
			if (isset($json_ret['MessageDetail'])) {
				$error_msg = $json_ret['MessageDetail'] .' ('. $json_ret['Message'] .')';
			} else {
				$error_msg = $json_ret['Message'];
			}
		}

		return $error_msg;
	}
}
