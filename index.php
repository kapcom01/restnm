<?php
include_once 'db_work.php';
include 'arp_work.php';
include 'gnaip-schema.php';

header('Access-Control-Allow-Origin: *');

$arptable = get_arp_data();

// fetch snmp_table
$snmp_data = db_get_snmp();
foreach ($snmp_data as $data_row) {
        //if($data_row['uplink']) {
	//	continue;
	//}
	//else {
		$device_mac = $data_row['device_macaddress'];
		$id = $data_row['id'];

		$data[] = array(
        	  'id' => $data_row['id'],
	          'switch_ip' => $data_row['switch_ip'],
	          'switch_ktirio' => ktirio($data_row['switch_ip']),
	          'switch_orofos' => orofos($data_row['switch_ip']),
	          'switch_ifname' => $data_row['switch_ifname'],
	          'switch_uplink_port' => $data_row['switch_uplink_port'],
	          'device_macaddress' => $device_mac,
        	  'device_ipaddress' => $arptable[$device_mac]['ip_address'],
	          'device_typos' => typos($arptable[$device_mac]['ip_address']),
	          'device_ktirio' => ktirio($arptable[$device_mac]['ip_address']),
	          'device_orofos' => orofos($arptable[$device_mac]['ip_address']),
	          'device_vendor' => $arptable[$device_mac]['vendor']
	        );
		unset($arptable[$device_mac]);
	//}
}

// iterate arp data
foreach (array_keys($arptable) as $arp_mac) {
  $data[] = array(
    'id' => ++$id, // temp workaround for ui grouping
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
