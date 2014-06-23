<?php
namespace brajox\Binero;

interface Connector
{
	const GET  = 1;
	const POST = 2;

	public function setAuthToken($auth_token);
	public function call($method_name, $http_method, array $arguments);
}
