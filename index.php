<html>
<head>
<title>GNA Network Manager</title>
</head>
<body>

<?php
include 'snmp_work.php';
include 'arp_work.php';
include 'gnaip-schema.php';

$ini_array = parse_ini_file("switches.ini");


foreach ($ini_array['ip'] as $ip) {
$swports = snmp_swports($ip);
$arptable = get_mac_ip_vendor();

  foreach ($arptable as $arp_row) {
    if(strcmp($arp_row['ip_address'],$ip)==0)
    {  $swvendor = $arp_row['vendor'];}
  }
?>

<p>
<table border="1">
<tr><td colspan=10 align=center><b> <?php echo $swvendor . " (" .$ip. ")"; ?> </b></td></tr>
<tr><td><b>switch ip</b></td><td><b>switch ktirio</b></td><td><b>switch orofos</b></td><td><b>switch port</b></td><td><b>MAC Address</b></td><td><b>IP Address</b></td><td><b>IP ktirio</b></td><td><b>IP orofos</b></td><td><b>Vendor</b></td></tr>

<?php
  $tr_bgcolor = "#BDBDBD";
  // iterate snmp data
  foreach ($swports as $swport) {
    if (count($swport['mac_address'])) {
      $tr_bgcolor = ($tr_bgcolor=="#FFFFFF") ? "#BDBDBD" : "#FFFFFF";
      foreach ($swport['mac_address'] as $row_mac_address) {
        echo "<tr bgcolor=" . $tr_bgcolor . "><td>" . $ip . "</td><td></td><td></td><td>" . $swport['ifname'] . "</td><td>" . $row_mac_address . "</td><td>" . $arptable[$row_mac_address]['ip_address'] . "</td><td>" . ktirio($arptable[$row_mac_address]['ip_address'])  . "</td><td>" . orofos($arptable[$row_mac_address]['ip_address'])  . "</td><td>" . $arptable[$row_mac_address]['vendor'] . "</td></tr>";
        echo "\n";
        unset($arptable[$row_mac_address]);
        }
      }
    } 

  // iterate arp data
  foreach (array_keys($arptable) as $arp_mac) {
    $tr_bgcolor = ($tr_bgcolor=="#FFFFFF") ? "#BDBDBD" : "#FFFFFF";
    echo "<tr bgcolor=" . $tr_bgcolor . "><td>" . $ip . "</td><td></td><td></td><td></td><td>" . $arp_mac . "</td><td>" . $arptable[$arp_mac]['ip_address'] . "</td><td>" . ktirio($arptable[$arp_mac]['ip_address'])  . "</td><td>" . orofos($arptable[$arp_mac]['ip_address'])  . "</td><td>" . $arptable[$arp_mac]['vendor'] . "</td></tr>";
    echo "\n";
  }
?>
</table>
</p>

<?php
}
?>

</body>
</html>
