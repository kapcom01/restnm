<?php
function get_mac_decimal($mac) {
    $clear_mac = preg_replace('/[^0-9A-F]/i','',$mac);
    $mac_decimal = array();
    for ($i = 0; $i < strlen($clear_mac); $i += 2 ):
        $mac_decimal[] = hexdec(substr($clear_mac, $i, 2));
    endfor;
    return implode('.',$mac_decimal);
}


$dot1dTpFdbAddressArray = snmpwalk("127.0.0.1", "public", "1.3.6.1.2.1.17.4.3.1.1");
foreach($dot1dTpFdbAddressArray as $dot1dTpFdbAddress) {
	$pos = stripos($dot1dTpFdbAddress, ': ');
	$mac_address = substr($dot1dTpFdbAddress, $pos+2);
	$macdec_address = get_mac_decimal($mac_address);
	$dot1dTpFdbPort = snmpget("127.0.0.1", "public", "1.3.6.1.2.1.17.4.3.1.2." . $macdec_address);
	$dot1dBasePortIfIndex = snmpget("127.0.0.1", "public", "1.3.6.1.2.1.17.1.4.1.2." . $dot1dTpFdbPort);
	$ifName = snmpget("127.0.0.1", "public", "1.3.6.1.2.1.31.1.1.1.1." . $dot1dBasePortIfIndex);
	$if2mac[] = $ifName . "->" . $mac_address;
}
?>

<html>
<head>
<title>Manolis SNMP in PHP</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<h1>Manolis SNMP in PHP</h1>

<?php foreach($if2mac as $well) {
 print "<div class='well'>$well</div>";
}
?>

</body>
</html>

