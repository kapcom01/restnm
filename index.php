<html>
<head>
<title>GNA Network Manager</title>
</head>
<body>

<?php
include 'snmp_work.php';
include 'arp_work.php';
$ini_array = parse_ini_file("switches.ini");

foreach ($ini_array['ip'] as $ip) {
?>

<p>
<table border="1">
<caption>Switch (<?php echo $ip; ?>)</caption>
<thead>
    <tr><th>Port Index</th><th>Port Name</th><th>Mac Address</th><th>IP Address</th></tr>
</thead>

<?php
	$if2mac = ifname_mac($ip);
	$netdiscover = get_mac_ip_vendor();
	foreach ($if2mac as $row) {
		foreach ($netdiscover as $netdiscover_row) {
			if (strcasecmp($netdiscover_row['mac_address'],$row['mac_address']) == 0) {
				$row['ip_address'] = $netdiscover_row['ip_address'];
			}
		}
		echo "<tr><td>" . $row['ifindex'] . "</td><td>" . $row['ifname'] . "</td><td>" . $row['mac_address'] . "</td><td>" . $row['ip_address'] . "</td></tr>";
	}
?>
</table>
</p>

<?php
}
?>

</body>
</html>
