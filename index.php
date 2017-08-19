<html>
<head>
<title>Manolis SNMP in PHP</title>
</head>
<body>

<?php
include 'snmp_work.php';
$ini_array = parse_ini_file("switches.ini");

foreach ($ini_array['ip'] as $ip) {
        print("<p>Switch ($ip):</p>");
	$if2mac = ifname_mac($ip);
	print("<table>");
	foreach ($if2mac as $interface => $mac) {
		print "<tr><td>$interface</td><td>$mac</td></tr>";
	}
	print("</table>");
}
?>
</body>
</html>
