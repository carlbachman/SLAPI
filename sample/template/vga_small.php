<?php

if (!is_file('config.ini')) {
  echo "Oops! Could not find config.ini\n"; 
  exit(1);
}
require_once 'config.ini'; 
require_once 'configuration_template.php'; 
require_once 'auxiliary.php'; 

vga_order_helper($vga_small, $vga_small_extra, $argv[1]);

?>
