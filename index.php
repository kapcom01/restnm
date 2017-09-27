<html>
<head>
<title>GNA Network Manager</title>
</head>
<body>

<?php
include 'snmp_work.php';
$ini_array = parse_ini_file("switches.ini");

foreach ($ini_array['ip'] as $ip) {
?>

<p>
<table border="1">
<caption>Switch (<?php echo $ip; ?>)</caption>
<thead>
    <tr><th>Interface</th><th>MAC Address</th></tr>
</thead>

<?php
	$swports = snmp_swports($ip);
	$tr_bgcolor = "#F2F2F2";
	foreach ($swports as $swport) {
		if (count($swport['mac_address']))
			$tr_bgcolor = ($tr_bgcolor=="#FFFFFF") ? "#F2F2F2" : "#FFFFFF";
		foreach ($swport['mac_address'] as $row_mac_address) {
			echo "<tr bgcolor=" . $tr_bgcolor . "><td>" . $swport['ifname'] . "</td><td>" . $row_mac_address . "</td></tr>";
		}
	}
?>
</table>
</p>

<?php
}
?>

</body>
</html>
