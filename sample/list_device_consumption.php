<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client = SoftLayer_SoapClient::getClient('SoftLayer_Account', null, SLAPI_USER, SLAPI_KEY);

try {
  $hourly = $client->getHourlyVirtualGuests();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

try {
  $monthly = $client->getMonthlyVirtualGuests();
} catch (Exception $e) {
  die('Oops! Something went wrong: ' . $e->getMessage() . "\n");
}

echo "Hours used\tHourly recurring fee\tRecurring fee (USD)\tNext bill date\t\t\tFQDN\n\n";
foreach ($hourly as $k) {
  echo $k->billingItem->hoursUsed . "\t\t" .
       $k->billingItem->hourlyRecurringFee . "\t\t\t" .
       $k->billingItem->recurringFee . "\t\t\t" .
       $k->billingItem->nextBillDate . "\t" .
       $k->fullyQualifiedDomainName . "\n";
}

echo "\nMonthly recurring fee\tNext bill date\t\t\tFQDN\n\n";
foreach ($monthly as $k) {
  echo $k->billingItem->recurringFee . "\t\t\t" .
       $k->billingItem->nextBillDate . "\t" .
       $k->fullyQualifiedDomainName . "\n";
}
?>
