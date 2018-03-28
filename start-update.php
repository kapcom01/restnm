<?php
include_once 'db_work.php';

db_recreate();

$debug_flag = file_exists("enable_debug");

if ($debug_flag) $ini_array = parse_ini_file("debug/switches.ini");
else $myfile = $ini_array = parse_ini_file("switches.ini");

$i=1;
foreach ($ini_array['ip'] as $ip) {
  echo "SNMP: (".$i++."/". count($ini_array['ip']) . ") populating db for Switch: ".$ip ." <br>\n";
  db_put_snmp($ip);
}

echo "ARP: running netdiscover for 172.16.0.0/16 <br>\n";
if($debug_flag==0) exec("netdiscover -P -N -r 172.16.0.0/16 >netdiscover.out");

echo "Done. <br>\n";
echo "Visit: http://" . getHostByName(getHostName()) . "/ui.php\n";
?>
