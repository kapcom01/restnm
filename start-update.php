<?php
error_reporting(0);

include 'snmp_work.php';
include 'arp_work.php';
include 'gnaip-schema.php';

$ini_array = parse_ini_file("switches.ini");

$i=1;
foreach ($ini_array['ip'] as $ip) {
  $swports = get_snmp_data($ip);
  $arptable = get_arp_data();

  // iterate snmp data
  echo "SNMP: (".$i."/". count($ini_array['ip']) . ") getting from Switch: ".$ip ." <br>\n";
  foreach ($swports as $swport) {
    if (count($swport['mac_address'])) {
      foreach ($swport['mac_address'] as $row_mac_address) {
        //echo $ip . " " . ktirio($ip) . " " . orofos($ip) . " " . $swport['ifname'] . " " . $row_mac_address . " " . $arptable[$row_mac_address]['ip_address'] . " " . typos($arptable[$row_mac_address]['ip_address']) . " " . ktirio($arptable[$row_mac_address]['ip_address'])  . " " . orofos($arptable[$row_mac_address]['ip_address'])  . " " . $arptable[$row_mac_address]['vendor'];
        //echo "\n";
        unset($arptable[$row_mac_address]);
      }
    }
  }
  $i++;
}

// iterate remaining arp data
echo "ARP : getting from netdiscover <br>\n";
foreach (array_keys($arptable) as $arp_mac) {
  //echo $ip . " " . ktirio($ip) . " " . orofos($ip) . " " . " " . $arp_mac . " " . $arptable[$arp_mac]['ip_address'] . " " . typos($arptable[$arp_mac]['ip_address']) . " " . ktirio($arptable[$arp_mac]['ip_address'])  . " " . orofos($arptable[$arp_mac]['ip_address'])  . " " . $arptable[$arp_mac]['vendor'];
  //echo "\n";
}

echo "Done.\n";
?>
