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
}
