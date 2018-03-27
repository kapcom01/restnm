<?php
include 'snmp_work.php';
include 'arp_work.php';
include 'gnaip-schema.php';

$ini_array = parse_ini_file("switches.ini");

header('Access-Control-Allow-Origin: *');

$i=0;

foreach ($ini_array['ip'] as $ip) {
  $swports = get_snmp_data($ip);
  $arptable = get_arp_data();

  // iterate snmp data
  foreach ($swports as $swport) {
    if (count($swport['mac_address'])) {
      foreach ($swport['mac_address'] as $row_mac_address) {
        if($swport['uplink']==1) {
		continue;
	}
	else {
		$data[] = array(
        	  'id' => $i++, // temp workaround for ui grouping
	          'switch_ip' => $ip,
	          'switch_ktirio' => ktirio($ip),
	          'switch_orofos' => orofos($ip),
	          'switch_ifname' => $swport['ifname'],
	          'switch_uplink_port' => $swport['uplink'],
	          'device_macaddress' => $row_mac_address,
        	  'device_ipaddress' => $arptable[$row_mac_address]['ip_address'],
	          'device_typos' => typos($arptable[$row_mac_address]['ip_address']),
	          'device_ktirio' => ktirio($arptable[$row_mac_address]['ip_address']),
	          'device_orofos' => orofos($arptable[$row_mac_address]['ip_address']),
	          'device_vendor' => $arptable[$row_mac_address]['vendor']
	        );
	}
        unset($arptable[$row_mac_address]);
      }
    }
  }
}

// iterate arp data
foreach (array_keys($arptable) as $arp_mac) {
  if($swport['uplink']==1) continue;
  $data[] = array(
    'id' => $i++, // temp workaround for ui grouping
    'switch_ip' => "",
    'switch_ktirio' => "",
    'switch_orofos' => "",
    'switch_ifname' => "",
    'switch_uplink_port' => "",
    'device_macaddress' => $arp_mac,
    'device_ipaddress' => $arptable[$arp_mac]['ip_address'],
    'device_typos' => typos($arptable[$arp_mac]['ip_address']),
    'device_ktirio' => ktirio($arptable[$arp_mac]['ip_address']),
    'device_orofos' => orofos($arptable[$arp_mac]['ip_address']),
    'device_vendor' => $arptable[$arp_mac]['vendor']
  );
}

echo json_encode($data);
?>
