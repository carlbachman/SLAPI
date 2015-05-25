<?php

/**
 *
 *   CCI LINUX
 *
 */

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

/**
 *
 *   CCI WINDOWS 
 *
 */

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

/**
 *
 *   BMS LINUX 
 *
 */

$bms_linux_small = new stdClass();
$bms_linux_small_extra = new stdClass();
$bms_linux_small->packageId = 200;
$bms_linux_small->location  = 224092;
$bms_linux_small->quantity  = 1;
$bms_linux_small->presetId  = 64;
// $bms_linux_small->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$bms_linux_small->useHourlyPricing = true;
$bms_linux_small_extra->os = 44992; // 44992 CentOS7_64
$bms_linux_small_extra->hostname = 'foo-linux-small';
$bms_linux_small_extra->domain = 'softlayer-singapore-test.com';
$bms_linux_small_extra->price_id = array(37332, // Single Quad Xeon 1270 3.4G 8M
                                         37344, // 8G
                                         32927, // Non-raid
                                         24713, // 1GbE
                                         34183, // 0G
                                         34807, // 1IP
                                         33483, // SSL VPN
                                         25014, // Reboot/KVM 
                                         );

$bms_linux_medium = new stdClass();
$bms_linux_medium_extra = new stdClass();
$bms_linux_medium->packageId = 200;
$bms_linux_medium->location  = 224092;
$bms_linux_medium->quantity  = 1;
$bms_linux_medium->presetId  = 68;
// $bms_linux_medium->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$bms_linux_medium->useHourlyPricing = true;
$bms_linux_medium_extra->os = 44992; // 44992 CentOS7_64
$bms_linux_medium_extra->hostname = 'foo-linux-medium';
$bms_linux_medium_extra->domain = 'softlayer-singapore-test.com';
$bms_linux_medium_extra->price_id = array(37316, // Dual Hex Xeon 2620 2G 2x15M
                                          37360, // 32G
                                          32927, // Non-raid
                                          24713, // 1GbE
                                          34183, // 0G
                                          34807, // 1IP
                                          33483, // SSL VPN
                                          25014, // Reboot/KVM 
                                          );

$bms_linux_large = new stdClass();
$bms_linux_large_extra = new stdClass();
$bms_linux_large->packageId = 200;
$bms_linux_large->location  = 224092;
$bms_linux_large->quantity  = 1;
$bms_linux_large->presetId  = 70;
// $bms_linux_large->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$bms_linux_large->useHourlyPricing = true;
$bms_linux_large_extra->os = 44992; // 44992 CentOS7_64
$bms_linux_large_extra->hostname = 'foo-linux-large';
$bms_linux_large_extra->domain = 'softlayer-singapore-test.com';
$bms_linux_large_extra->price_id = array(37302, // Dual Octo Xeon 2650 2G 2x20M
                                         37370, // 64G
                                         32927, // Non-raid
                                         24713, // 1GbE
                                         34183, // 0G
                                         34807, // 1IP
                                         33483, // SSL VPN
                                         25014, // Reboot/KVM 
                                         );

/**
 *
 *   BMS WINDOWS 
 *
 */

$bms_win_small = new stdClass();
$bms_win_small_extra = new stdClass();
$bms_win_small->packageId = 200;
$bms_win_small->location  = 224092;
$bms_win_small->quantity  = 1;
$bms_win_small->presetId  = 64;
// $bms_win_small->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$bms_win_small->useHourlyPricing = true;
$bms_win_small_extra->os = 36215; // W2012R2 std 64
$bms_win_small_extra->hostname = 'foo-win-small';
$bms_win_small_extra->domain = 'softlayer-singapore-test.com';
$bms_win_small_extra->price_id =  array(37332, // Single Quad Xeon 1270 3.4G 8M
                                        37344, // 8G
                                        32927, // Non-raid
                                        24713, // 1GbE
                                        34183, // 0G
                                        34807, // 1IP
                                        33483, // SSL VPN
                                        25014, // Reboot/KVM 
                                        );

$bms_win_medium = new stdClass();
$bms_win_medium_extra = new stdClass();
$bms_win_medium->packageId = 200;
$bms_win_medium->location  = 224092;
$bms_win_medium->quantity  = 1;
$bms_win_medium->presetId  = 68;
// $bms_win_medium->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$bms_win_medium->useHourlyPricing = true;
$bms_win_medium_extra->os = 36226; // W2012R2 std 64
$bms_win_medium_extra->hostname = 'foo-win-medium';
$bms_win_medium_extra->domain = 'softlayer-singapore-test.com';
$bms_win_medium_extra->price_id = array(37316, // Dual Hex Xeon 2620 2G 2x15M
                                        37360, // 32G
                                        32927, // Non-raid
                                        24713, // 1GbE
                                        34183, // 0G
                                        34807, // 1IP
                                        33483, // SSL VPN
                                        25014, // Reboot/KVM 
                                        );

$bms_win_large = new stdClass();
$bms_win_large_extra = new stdClass();
$bms_win_large->packageId = 200;
$bms_win_large->location  = 224092;
$bms_win_large->quantity  = 1;
$bms_win_large->presetId  = 70;
// $bms_win_large->imageTemplateGlobalIdentifier  = 'd8a12975-b1e2-4963-9a85-c9886953a851';
$bms_win_large->useHourlyPricing = true;
$bms_win_large_extra->os = 36226; // W2012R2 std 64
$bms_win_large_extra->hostname = 'foo-win-large';
$bms_win_large_extra->domain = 'softlayer-singapore-test.com';
$bms_win_large_extra->price_id = array(37302, // Dual Octo Xeon 2650 2G 2x20M
                                       37370, // 64G
                                       32927, // Non-raid
                                       24713, // 1GbE
                                       34183, // 0G
                                       34807, // 1IP
                                       33483, // SSL VPN
                                       25014, // Reboot/KVM 
                                       );

?>
