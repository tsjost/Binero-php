<?php
use tsjost\Binero;
use PHPUnit\Framework\TestCase;

class ConcreteStrictStruct extends Binero\StrictStruct
{
	public $declared;
	public $foo;
	public $bar;
	public $baz;
}

class StrictStructTest extends TestCase
{
	public function testUndeclared()
	{
		$this->expectException(DomainException::class);

		$strictStruct = new \ConcreteStrictStruct;

		$strictStruct->undeclared = "property doesn't exist";
	}

	public function testDeclared()
	{
		$strictStruct = new \ConcreteStrictStruct;

		$strictStruct->declared = "property exists";

		$this->assertTrue(true);
	}

	public function testPassedUndeclared()
	{
		$this->expectException(DomainException::class);

		$values = array(
			'also_undeclared' => "that doesn't exist",
		);

		new \ConcreteStrictStruct($values);
	}

	public function testPassedValues()
	{
		$values = array(
			'foo' => 1337,
			'bar' => 'FooBar',
			'baz' => 3.14159265,
		);

		$strictStruct = new \ConcreteStrictStruct($values);

		foreach ($values as $key => $value) {
			$this->assertEquals($value, $strictStruct->{$key});
		}

		$this->assertNull($strictStruct->declared);
	}
}
