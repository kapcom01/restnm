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
$swports = snmp_swports($ip);
$arptable = get_mac_ip_vendor();

  foreach ($arptable as $arp_row) {
    if(strcmp($arp_row['ip_address'],$ip)==0)
    {  $swvendor = $arp_row['vendor'];}
  }
?>

<p>
<table border="1">
<tr><td colspan=4 align=center><b> <?php echo $swvendor . " (" .$ip. ")"; ?> </b></td></tr>
<tr><td><b>Interface</b></td><td><b>MAC Address</b></td><td><b>IP Address</b></td><td><b>Vendor</b></td></tr>

<?php
  $tr_bgcolor = "#BDBDBD";
  foreach ($swports as $swport) {
    if (count($swport['devices'])) {
      $tr_bgcolor = ($tr_bgcolor=="#FFFFFF") ? "#BDBDBD" : "#FFFFFF";
      foreach ($swport['devices'] as $row_devices) {
        $mac_address = $row_devices['mac_address'];
        echo "<tr bgcolor=" . $tr_bgcolor . "><td>" . $swport['ifname'] . "</td><td>" . $mac_address . "</td><td>" . $arptable[$mac_address]['ip_address'] . "</td><td>" . $arptable[$mac_address]['vendor'] . "</td></tr>";
        }
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
