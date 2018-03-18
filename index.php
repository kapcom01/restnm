<html>
<head>
<title>GNA Network Manager</title>
</head>
<body>

<p>
<table border="1">
<tr><td><b>Switch IP</b></td><td><b>Switch Ktirio</b></td><td><b>Switch Orofos</b></td><td><b>Switch Port</b></td><td><b>Device MAC Address</b></td><td><b>Devive IP Address</b></td><td><b>Device Type</b></td><td><b>Device Ktirio</b></td><td><b>Device Orofos</b></td><td><b>Device Vendor</b></td></tr>

<?php
include 'snmp_work.php';
include 'arp_work.php';
include 'gnaip-schema.php';

$ini_array = parse_ini_file("switches.ini");

foreach ($ini_array['ip'] as $ip) {
  $swports = snmp_swports($ip);
  $arptable = get_mac_ip_vendor();

  $tr_bgcolor = "#BDBDBD";

  // iterate snmp data
  foreach ($swports as $swport) {
    if (count($swport['mac_address'])) {
      $tr_bgcolor = ($tr_bgcolor=="#FFFFFF") ? "#BDBDBD" : "#FFFFFF";
      foreach ($swport['mac_address'] as $row_mac_address) {
        echo "<tr bgcolor=" . $tr_bgcolor . "><td>" . $ip . "</td><td>" . ktirio($ip) . "</td><td>" . orofos($ip) . "</td><td>" . $swport['ifname'] . "</td><td>" . $row_mac_address . "</td><td>" . $arptable[$row_mac_address]['ip_address'] . "</td><td>" . typos($arptable[$row_mac_address]['ip_address']) . "</td><td>" . ktirio($arptable[$row_mac_address]['ip_address'])  . "</td><td>" . orofos($arptable[$row_mac_address]['ip_address'])  . "</td><td>" . $arptable[$row_mac_address]['vendor'] . "</td></tr>";
        echo "\n";
        unset($arptable[$row_mac_address]);
        }
      }
    }

  // iterate arp data
  foreach (array_keys($arptable) as $arp_mac) {
    $tr_bgcolor = ($tr_bgcolor=="#FFFFFF") ? "#BDBDBD" : "#FFFFFF";
    echo "<tr bgcolor=" . $tr_bgcolor . "><td>" . $ip . "</td><td>" . ktirio($ip) . "</td><td>" . orofos($ip) . "</td><td></td><td>" . $arp_mac . "</td><td>" . $arptable[$arp_mac]['ip_address'] . "</td><td>" . typos($arptable[$arp_mac]['ip_address']) . "</td><td>" . ktirio($arptable[$arp_mac]['ip_address'])  . "</td><td>" . orofos($arptable[$arp_mac]['ip_address'])  . "</td><td>" . $arptable[$arp_mac]['vendor'] . "</td></tr>";
    echo "\n";
  }
}
?>

</table>
</p>

</body>
</html>
