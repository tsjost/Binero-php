<?php

namespace tsjost\Binero;

class Client
{
	private $Connector;

	public function __construct(Connector $Connector = null)
	{
		if (is_null($Connector)) {
			$Connector = new HttpConnector('https://mobileapi.binero.se/');
		}

		$this->Connector = $Connector;
	}

	public function setAuthToken($auth_token)
	{
		$this->Connector->setAuthToken($auth_token);
	}

	public function login($username, $password)
	{
		$ret = $this->request('Token', Connector::POST, array(
			'grant_type' => 'password',
			'username'   => $username,
			'password'   => $password,
		));

		if (isset($ret['access_token'])) {
			$this->setAuthToken($ret['access_token']);

			return array('success' => true, 'token' => $ret['access_token']);
		} else {
			return array('success' => false, 'message' => $this->getErrorString($ret));
		}
	}

	public function getDomainList($search = '', $page = 1)
	{
		$ret = $this->request('api/Domains/GetDomainList', Connector::GET, array(
			'search' => $search,
			'page'   => $page,
		));

		if (!isset($ret['Items'])) {
			throw new BineroException($this->getErrorString($ret));
		}

		foreach ($ret['Items'] as &$Item) {
			$Item = ClassCaster::Cast($Item, 'Domain');
		}

		return ClassCaster::Cast($ret, 'DomainListResponse');
	}

	protected function request($method_name, $http_method, array $params)
	{
		return $this->Connector->request($method_name, $http_method, $params);
	}
	protected function getErrorString($json_ret)
	{
		$error_msg = 'Unknown';

		if (isset($json_ret['error'])) {
			if (isset($json_ret['error_description'])) {
				$error_msg = $json_ret['error_description'] . ' (' . $json_ret['error'] . ')';
			} else {
				$error_msg = $json_ret['error'];
			}
		} else if (isset($json_ret['Message'])) {
			if (isset($json_ret['MessageDetail'])) {
				$error_msg = $json_ret['MessageDetail'] . ' (' . $json_ret['Message'] . ')';
			} else {
				$error_msg = $json_ret['Message'];
			}
		}

		return $error_msg;
	}
}
