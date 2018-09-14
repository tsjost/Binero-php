<?php
namespace tsjost\Binero\Test;

use tsjost\Binero;

class DomainListResponseTest extends \PHPUnit_Framework_TestCase
{
	private $response_data = array(
		'Total' => 1,
		'Page' => 1,
		'PageSize' => 25,
		'Items' => array(),
	);
	private $domain_data = array(
		'DomainName' => 'testar.se',
		'ExpireDate' => '2015-03-22T01:00:00',
		'ExpireDateShortString' => '2015-03-22',
		'IsActive' => true,
	);

	public function setUp()
	{
		$Domain = new Binero\Domain($this->domain_data);
		$this->response_data['Items'][] = $Domain;
		$this->DomainListResponse = new Binero\DomainListResponse($this->response_data);
	}

	public function testDataRetainment()
	{
		$this->assertEquals($this->response_data['Total'], $this->DomainListResponse->getNumResults());
		$this->assertEquals($this->response_data['Page'], $this->DomainListResponse->getPageNumber());
		$this->assertEquals($this->response_data['PageSize'], $this->DomainListResponse->getPageSize());

		$Domains = $this->DomainListResponse->getDomains();

		$this->assertEquals($this->domain_data['DomainName'], $Domains[0]->getName());
	}
}
