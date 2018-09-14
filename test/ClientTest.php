<?php
namespace tsjost\Binero\Test;

use tsjost\Binero;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
	public function setUp()
	{
		$this->ConnectorMock = $this->getMockBuilder('tsjost\\Binero\\Connector')->getMock();
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

	public function testGetDomainList()
	{
		$this->ConnectorMock->expects($this->once())
			->method('call')
			->with('api/Domains/GetDomainList', Binero\Connector::GET, array('search' => '', 'page' => 1))
			->will($this->returnValue(array(
				'Total' => 4,
				'Page' => 1,
				'PageSize' => 25,
				'Items' => array(
					0 => array(
						'DomainName' => 'php.se',
						'ExpireDate' => '2015-03-22T00:00:00',
						'IsActive' => true,
						'ExpireDateShortString' => '2015-03-22',
					),
					1 => array(
						'DomainName' => 'binero.se',
						'ExpireDate' => '2014-04-14T00:00:00',
						'IsActive' => false,
						'ExpireDateShortString' => '2014-04-14',
					),
					2 => array(
						'DomainName' => 'wn.se',
						'ExpireDate' => '2014-09-28T00:00:00',
						'IsActive' => true,
						'ExpireDateShortString' => '2014-09-28',
					),
					3 => array(
						'DomainName' => 'git.se',
						'ExpireDate' => '2014-10-28T00:00:00',
						'IsActive' => true,
						'ExpireDateShortString' => '2014-10-28',
					),
				),
			)));

		$ret = $this->Client->getDomainList();

		$this->assertInstanceOf('tsjost\\Binero\\DomainListResponse', $ret);
		$this->assertEquals(4, $ret->getNumResults());

		$Domains = $ret->getDomains();
		$this->assertCount(4, $Domains);
		$this->assertInstanceOf('tsjost\\Binero\\Domain', $Domains[0]);
		$this->assertEquals('php.se', $Domains[0]->getName());
	}

	/**
	 * @expectedException tsjost\Binero\BineroException
	 */
	public function testGetDomainListError()
	{
		$this->ConnectorMock->expects($this->once())
			->method('call')
			->will($this->returnValue(array(
				'error' => 'random_error',
				'error_description' => 'Some Random Error occured!',
			)));

		$this->Client->getDomainList();
	}
}
