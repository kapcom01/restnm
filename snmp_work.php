<?php
function mac_dec2hex($macdec) {
	$macdec = strval($macdec);
	$parts = explode(".", $macdec);
	foreach ($parts as $decpart) {
		$hexpart = dechex($decpart);
		if (strlen($hexpart)<2) $hexpart = "0".$hexpart;
		$hexparts[]=$hexpart;
	}
	//strtoupper
	return implode(":",$hexparts);
}

function snmp_swports($switch_ip) {
	$debug_flag = file_exists("enable_debug");
	if ($debug_flag) include 'debug/snmp_debug.php';

	// SNMP V1

	// mac => port
	$mac2port = ($debug_flag==false) ? snmprealwalk($switch_ip, "public", "1.3.6.1.2.1.17.4.3.1.2") : $mac2port;

	// ifindex => ifname
	$ifindex2ifname = ($debug_flag==false) ? snmprealwalk($switch_ip, "public", "1.3.6.1.2.1.31.1.1.1.1") : $ifindex2ifname;

	// port => ifindex
	$port2ifindex = ($debug_flag==false) ? snmprealwalk($switch_ip, "public", "1.3.6.1.2.1.17.1.4.1.2") : $port2ifindex;


	foreach ($ifindex2ifname as $key => $value) {
		$pos_last_dot = strripos($key, ".");
		$newkey = substr($key, $pos_last_dot+1);
		$pos_colon = stripos($value, ': ');
		$newvalue = substr($value, $pos_colon+2);
		$ifindex2ifname[$newkey] = $newvalue;
		unset($ifindex2ifname[$key]);
	}

	foreach ($port2ifindex as $key => $value) {
		$pos_last_dot = strripos($key, ".");
		$key = substr($key, $pos_last_dot+1);
		$pos_colon = stripos($value, ': ');
		$value = substr($value, $pos_colon+2);
		$snmp_swports[$key] = array(
			'id' => "",
			'ifindex' => $value,
			'ifname' => $ifindex2ifname[$value],
			//'devices' => array(
			//	'mac_address' => "",
			//	'ip_address' => "",
			//)
		);
	}

	foreach($mac2port as $key => $value) {
		$pos = stripos($key, '1.17.4.3.1.2.');
		$key = substr($key, $pos+13);
		$pos_colon = stripos($value, ': ');
		$value = substr($value, $pos_colon+2);
		$snmp_swports[$value]['devices'][] = array('mac_address' => mac_dec2hex($key), 'ip_address' => "");
	}

	return $snmp_swports;
}
?>
