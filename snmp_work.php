<?php

// metatrepei tis MAC apo hex se dec
function get_mac_decimal($mac) {
    $clear_mac = preg_replace('/[^0-9A-F]/i','',$mac);
    $mac_decimal = array();
    for ($i = 0; $i < strlen($clear_mac); $i += 2 ):
        $mac_decimal[] = hexdec(substr($clear_mac, $i, 2));
    endfor;
    return implode('.',$mac_decimal);
}

// epistrefei $ifname => $mac gia switch_ip
function ifname_mac($ip) {
/*
OID 1.3.6.1.2.1.17.4.3.1.1
dot1dTpFdbAddress OBJECT-TYPE
SYNTAX MacAddress
ACCESS read-only
STATUS mandatory
DESCRIPTION
"A unicast MAC address for which the bridge has
forwarding and/or filtering information."
REFERENCE
"IEEE 802.1D-1990: Section 3.9.1, 3.9.2"
*/

$dot1dTpFdbAddressArray = snmpwalk($switch_ip, "public", "1.3.6.1.2.1.17.4.3.1.1");
foreach($dot1dTpFdbAddressArray as $dot1dTpFdbAddress) {

	$pos = stripos($dot1dTpFdbAddress, ': ');
	$mac_address = substr($dot1dTpFdbAddress, $pos+2);

	$macdec_address = get_mac_decimal($mac_address);

/*
OID 1.3.6.1.2.1.17.4.3.1.2
dot1dTpFdbPort OBJECT-TYPE
SYNTAX INTEGER
ACCESS read-only
STATUS mandatory
DESCRIPTION
Either the value 0, or the port number of the port on which a frame having a source address equal to the value of the corresponding $
A value of 0 indicates that the port number has not been learned, but that the bridge does have some forwarding/filtering informatio$
Implementors are encouraged to assign the port value to this object whenever it is learned, even for addresses for which the corresp$
*/


	$dot1dTpFdbPort = snmpget($switch_ip, "public", "1.3.6.1.2.1.17.4.3.1.2." . $macdec_address);

        $pos = stripos($dot1dTpFdbPort, ': ');
        $port = substr($dot1dTpFdbPort, $pos+2);


/*
OID 1.3.6.1.2.1.17.1.4.1.2
dot1dBasePortIfIndex OBJECT-TYPE
SYNTAX INTEGER
ACCESS read-only
STATUS mandatory
DESCRIPTION
"The value of the instance of the ifIndex object,
defined in MIB-II, for the interface corresponding
to this port."
*/

	$dot1dBasePortIfIndex = snmpget($switch_ip, "public", "1.3.6.1.2.1.17.1.4.1.2." . $port);

        $pos = stripos($dot1dBasePortIfIndex, ': ');
        $ifindex = substr($dot1dBasePortIfIndex, $pos+2);

/*
OID 1.3.6.1.2.1.31.1.1.1.1
ifName OBJECT-TYPE
SYNTAX DisplayString
MAX-ACCESS read-only
STATUS current
DESCRIPTION
"The textual name of the interface. The value of this
object should be the name of the interface as assigned by
the local device and should be suitable for use in commands
entered at the devices `console. This might be a text
name, such as `le0 or a simple port number, such as `1,
depending on the interface naming syntax of the device. If
several entries in the iftable together represent a single
interface as named by the device, then each will have the
same value of ifName. Note that for an agent which responds
to SNMP queries concerning an interface on some other
(proxied) device, then the value of ifName for such an
interface is the proxied devices local name for it.
If there is no local name, or this object is otherwise not
applicable, then this object contains a zero-length string."
*/
	$ifName = snmpget($switch_ip, "public", "1.3.6.1.2.1.31.1.1.1.1." . $ifindex);

	$pos = stripos($ifName, ': ');
        $ifname = substr($ifName, $pos+2);


	if(array_key_exists($ifindex, $if2mac)) {
		$if2mac[$ifindex][$ifname]=$if2mac[$ifindex][$ifname] . ", " . $mac_address;
	}
	else {
	        $if2mac[$ifindex][$ifname]=$mac_address;
	}
}
return $if2mac;
}
?>
