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

<p style="font-size:160%;">Switch (<?php echo $ip; ?>):</p>

<table border="1">
<tr><td>Port Index</td><td>Port Name</td><td>MAC Address</td></tr>

<?php
	$if2mac = ifname_mac($ip);
	foreach ($if2mac as $index => $name_mac) {
		echo "<tr><td>$index</td><td>" . key($name_mac) . "</td><td>" . $name_mac[key($name_mac)] . "</td></tr>";
	}
?>
</table>

<?php
}
?>

</body>
</html>
