<html>
<head>
<title>Manolis SNMP in PHP</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Manolis SNMP in PHP test</div>
  <table class="table">

<?php
include 'snmp_work.php';

$ini_array = parse_ini_file("switches.ini");
foreach ($ini_array['ip'] as $ip) {
        print("<p> Refreshing SNMP of $ip ...</p>");
	$if2mac = ifname_mac($ip);
	foreach ($if2mac as $interface => $mac) {
		print "<tr><td>$interface</td><td>$mac</td></tr>";
	}
}

?>
  </table>
</div>
</body>
</html>
