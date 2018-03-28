<html>
<head>
<title>GNA Network Manager</title>
</head>
<body>

<p>
<table border="1">
<tr><td><b>Switch IP</b></td><td><b>Switch Ktirio</b></td><td><b>Switch Orofos</b></td><td><b>Switch Port</b></td><td><b>Device MAC Address</b></td><td><b>Devive IP Address</b></td><td><b>Device Type</b></td><td><b>Device Ktirio</b></td><td><b>Device Orofos</b></td><td><b>Device Vendor</b></td></tr>

<?php
$tr_bgcolor = "#BDBDBD";

$api_url = 'http://10.207.25.228/';
$content = file_get_contents($api_url);
$json = json_decode($content, true);

foreach ($json as $row) {
  $tr_bgcolor = ($tr_bgcolor=="#FFFFFF") ? "#BDBDBD" : "#FFFFFF";
  echo "<tr bgcolor=" . $tr_bgcolor . "><td>" . $row['switch_ip'] . "</td><td>" . $row['switch_ktirio'] . "</td><td>" . $row['switch_orofos'] . "</td><td>" . $row['switch_ifname'] . "</td><td>" . $row['device_macaddress'] . "</td><td>" . $row['device_ipaddress'] . "</td><td>" . $row['device_typos'] . "</td><td>" . $row['device_ktirio']  . "</td><td>" . $row['device_orofos']  . "</td><td>" . $row['device_vendor'] . "</td></tr>";
  echo "\n";
}
?>

</table>
</p>

</body>
</html>
