<?php
namespace brajox\Binero;

class DomainListResponse extends StrictStruct
{
	public $Total;
	public $Page;
	public $PageSize;
	public $Items;

	public function getNumResults()
	{
		return $this->Total;
	}

	public function getPageNumber()
	{
		return $this->Page;
	}

	public function getPageSize()
	{
		return $this->PageSize;
	}

	public function getDomains()
	{
		return $this->Items;
	}
}
