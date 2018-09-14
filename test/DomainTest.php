<?php
namespace tsjost\Binero\Test;

use tsjost\Binero;

class DomainTest extends \PHPUnit_Framework_TestCase
{
	private $domain_data = array(
		'DomainName' => 'testar.se',
		'ExpireDate' => '2015-03-22T01:00:00',
		'ExpireDateShortString' => '2015-03-22',
		'IsActive' => true,
	);

	public function setUp()
	{
		$this->Domain = new Binero\Domain($this->domain_data);
	}

	public function testDataRetainment()
	{
		$this->assertEquals($this->domain_data['DomainName'], $this->Domain->getName());
		$this->assertEquals($this->domain_data['ExpireDate'], $this->Domain->getExpireDate());
		$this->assertEquals($this->domain_data['ExpireDateShortString'], $this->Domain->getExpireDateShort());
		$this->assertEquals($this->domain_data['IsActive'], $this->Domain->isActive());
	}

	/**
	 * @dataProvider hasExpiredProvider
	 */
	public function testHasExpired($datetime, $expected_result)
	{
		$this->assertEquals($expected_result, $this->Domain->hasExpired($datetime));
	}
	public function hasExpiredProvider()
	{
		return array(
			array('2014-02-02', false),
			array('2015-03-22', false),
			array('2015-03-22T00:59:59', false),
			array('2015-03-22T01:00:00', true),
			array('2015-03-23', true),
			array(new \DateTime('2014-01-05'), false),
			array(new \DateTime('2015-03-23'), true),
		);
	}
}
