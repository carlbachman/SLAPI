<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 

$client_cci = SoftLayer_SoapClient::getClient('SoftLayer_Virtual_Guest', '', SLAPI_USER, SLAPI_KEY);
$client_bms = SoftLayer_SoapClient::getClient('SoftLayer_Hardware_Server', '', SLAPI_USER, SLAPI_KEY);

try { 
  $my_items_cci = $client_cci->getCreateObjectOptions(); 
} catch (Exception $e) { 
  die('Unable to retrieve package list: ' . $e->getMessage()); 
}

try { 
  $my_items_bms = $client_bms->getCreateObjectOptions(); 
} catch (Exception $e) { 
  die('Unable to retrieve package list: ' . $e->getMessage()); 
}

printf("\n%s\n\n", '[[ CCI ]]');

printf("%s\t%s\t%s", 'Hourly',
                     'Monthly',
                     "operatingSystemReferenceCode\n\n");

foreach ($my_items_cci->operatingSystems as $os) {
  printf("%s\t%s\t%s\n", $os->itemPrice->hourlyRecurringFee,
                         $os->itemPrice->recurringFee,
                         $os->template->operatingSystemReferenceCode);
}

printf("\n%s\n\n", '[[ BMS ]]');

printf("%s\t%s\t%s", 'Hourly',
                     'Monthly',
                     "operatingSystemReferenceCode\n\n");

foreach ($my_items_bms->operatingSystems as $os) {
  printf("%s\t%s\t%s\n", $os->itemPrice->hourlyRecurringFee,
                         $os->itemPrice->recurringFee,
                         $os->template->operatingSystemReferenceCode);
}
?>
