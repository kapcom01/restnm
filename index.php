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
    <tr><th>Port Index</th><th>Port Name</th><th>Mac Address</th></tr>
</thead>

<?php
	$swports = snmp_swports($ip);
	foreach ($swports as $row) {
		foreach ($row['mac_address'] as $row_mac_address) {
			echo "<tr><td>" . $row['ifindex'] . "</td><td>" . $row['ifname'] . "</td><td>" . $row_mac_address . "</td></tr>";
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
