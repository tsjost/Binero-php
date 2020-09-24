<?php

namespace tsjost\Binero;

interface Connector
{
	const GET  = 1;
	const POST = 2;

	public function setAuthToken($auth_token);
	public function request($method_name, $http_method, array $arguments);
}
