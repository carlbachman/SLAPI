<?php

$cci_linux_small = new stdClass();
$cci_linux_small->datacenter['name'] = 'sng01';
$cci_linux_small->hostname = 'foo-linux-small';
$cci_linux_small->domain = 'softlayer-singapore-test.com';
$cci_linux_small->startCpus = 1;
$cci_linux_small->maxMemory = 1024;
$cci_linux_small->hourlyBillingFlag = true;
$cci_linux_small->operatingSystemReferenceCode = 'DEBIAN_7_64';
$cci_linux_small->localDiskFlag = false;
$cci_linux_small->networkComponents[0]['maxSpeed'] = 100;

$cci_linux_medium = new stdClass();
$cci_linux_medium->datacenter['name'] = 'sng01';
$cci_linux_medium->hostname = 'foo-linux-medium';
$cci_linux_medium->domain = 'softlayer-singapore-test.com';
$cci_linux_medium->startCpus = 2;
$cci_linux_medium->maxMemory = 4096;
$cci_linux_medium->hourlyBillingFlag = true;
$cci_linux_medium->operatingSystemReferenceCode = 'DEBIAN_7_64';
$cci_linux_medium->localDiskFlag = false;
$cci_linux_medium->networkComponents[0]['maxSpeed'] = 100;

$cci_linux_large = new stdClass();
$cci_linux_large->datacenter['name'] = 'sng01';
$cci_linux_large->hostname = 'foo-linux-large';
$cci_linux_large->domain = 'softlayer-singapore-test.com';
$cci_linux_large->startCpus = 4;
$cci_linux_large->maxMemory = 16384;
$cci_linux_large->hourlyBillingFlag = true;
$cci_linux_large->operatingSystemReferenceCode = 'DEBIAN_7_64';
$cci_linux_large->localDiskFlag = false;
$cci_linux_large->networkComponents[0]['maxSpeed'] = 1000;

$cci_win_small = new stdClass();
$cci_win_small->datacenter['name'] = 'sng01';
$cci_win_small->hostname = 'foo-windos-small';
$cci_win_small->domain = 'softlayer-singapore-test.com';
$cci_win_small->startCpus = 1;
$cci_win_small->maxMemory = 4096;
$cci_win_small->hourlyBillingFlag = true;
$cci_win_small->operatingSystemReferenceCode = 'WIN_2008-STD-R2_64';
$cci_win_small->localDiskFlag = false;
$cci_win_small->networkComponents[0]['maxSpeed'] = 100;

$cci_win_medium = new stdClass();
$cci_win_medium->datacenter['name'] = 'sng01';
$cci_win_medium->hostname = 'foo-windos-medium';
$cci_win_medium->domain = 'softlayer-singapore-test.com';
$cci_win_medium->startCpus = 2;
$cci_win_medium->maxMemory = 8192;
$cci_win_medium->hourlyBillingFlag = true;
$cci_win_medium->operatingSystemReferenceCode = 'WIN_2008-STD-R2_64';
$cci_win_medium->localDiskFlag = false;
$cci_win_medium->networkComponents[0]['maxSpeed'] = 1000;

$cci_win_large = new stdClass();
$cci_win_large->datacenter['name'] = 'sng01';
$cci_win_large->hostname = 'foo-windos-large';
$cci_win_large->domain = 'softlayer-singapore-test.com';
$cci_win_large->startCpus = 4;
$cci_win_large->maxMemory = 16384;
$cci_win_large->hourlyBillingFlag = true;
$cci_win_large->operatingSystemReferenceCode = 'WIN_2008-STD-R2_64';
$cci_win_large->localDiskFlag = false;
$cci_win_large->networkComponents[0]['maxSpeed'] = 1000;

?>
