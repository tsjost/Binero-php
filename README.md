Binero
======

A PHP library to communicate with [Binero](https://www.binero.se)'s mobile API.

Example
-------

```php
<?php
use brajox\Binero;

$username = 'my@username.se';
$password = 'my_password';

$Binero = new Binero\Client(new Binero\HttpConnector('https://mobileapi.binero.se/'));

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
