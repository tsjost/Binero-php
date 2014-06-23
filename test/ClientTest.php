<?php
namespace brajox\Binero\Test;

use brajox\Binero;

class ClientTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->ConnectorMock = $this->getMock('brajox\\Binero\\Connector');
		$this->Client = new Binero\Client($this->ConnectorMock);
	}

	public function testLogin()
	{
		$username = 'foo';
		$password = 'bar';
		$auth_token = 'sample_auth_token';

		$this->ConnectorMock->expects($this->once())
			->method('call')
			->with('Token', Binero\Connector::POST, array(
				'grant_type' => 'password',
				'username' => $username,
				'password' => $password,
			))
			->will($this->returnValue(array(
				'.expires' => 'Tue, 24 Jun 2014 02:53:22 GMT',
				'.issued' => 'Mon, 23 Jun 2014 14:53:22 GMT',
				'access_token' => $auth_token,
				'expires_in' => 43199,
				'token_type' => 'bearer',
				'userName' => $username,
			)));

		$ret = $this->Client->login($username, $password);

		$this->assertTrue($ret['success']);
		$this->assertEquals($auth_token, $ret['token']);
	}

	public function testLoginIncorrect()
	{
		$username = 'foo';
		$password = 'bar';

		$this->ConnectorMock->expects($this->once())
			->method('call')
			->with('Token', Binero\Connector::POST, array(
				'grant_type' => 'password',
				'username' => $username,
				'password' => $password,
			))
			->will($this->returnValue(array(
				'error' => 'invalid_grant',
				'error_description' => 'The user name or password is incorrect.',
			)));

		$ret = $this->Client->login($username, $password);

		$this->assertFalse($ret['success']);
		$this->assertEquals('The user name or password is incorrect. (invalid_grant)', $ret['message']);
	}
}
