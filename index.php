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
	$if2mac = ifname_mac($ip);
	foreach ($if2mac as $row) {
		echo "<tr><td>" . $row['ifindex'] . "</td><td>" . $row['ifname'] . "</td><td>" . $row['mac_address'] . "</td></tr>";
	}
?>
</table>
</p>

<?php
}
?>

</body>
</html>
