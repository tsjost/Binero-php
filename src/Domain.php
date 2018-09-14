<?php
namespace tsjost\Binero;

class Domain extends StrictStruct
{
	public $DomainName;
	public $ExpireDate;
	public $ExpireDateShortString;
	public $IsActive;

	public function getName()
	{
		return $this->DomainName;
	}

	public function getExpireDate()
	{
		return $this->ExpireDate;
	}

	public function getExpireDateShort()
	{
		return $this->ExpireDateShortString;
	}

	public function isActive()
	{
		return $this->IsActive;
	}

	public function hasExpired($compare_time = null)
	{
		if (is_null($compare_time)) {
			$compare_time = new \DateTime;
		}

		if ( ! ($compare_time instanceof \DateTime)) {
			$compare_time = new \DateTime($compare_time);
		}

		return $compare_time >= new \DateTime($this->getExpireDate());
	}
}
