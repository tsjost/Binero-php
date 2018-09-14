Binero
======

[![Build Status](https://travis-ci.com/tsjost/Binero-php.svg?branch=master)](https://travis-ci.com/tsjost/Binero-php)

A PHP library to communicate with [Binero](https://www.binero.se)'s (private & undocumented) mobile API.

Example
-------

```php
<?php
use tsjost\Binero;

$username = 'my@username.se';
$password = 'my_password';

$Binero = new Binero\Client;

$login = $Binero->login($username, $password);
if ( ! $login['success']) {
  die('Unable to log in: '. $login['message']);
}

$DomainList = $Binero->getDomainList();

echo "There are ". $DomainList->getNumResults() ." domains!\n";
foreach ($DomainList->getDomains() as $Domain) {
	echo " * ". $Domain->getName() ." (". $Domain->getExpireDateShort() .")\n";
}
```
