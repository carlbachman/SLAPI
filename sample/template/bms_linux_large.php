<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 
require_once 'configuration_template.php'; 
require_once 'auxiliary.php'; 

bms_order_helper($bms_linux_large, $bms_linux_large_extra, $argv[1]);

?>
