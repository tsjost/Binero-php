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
}
