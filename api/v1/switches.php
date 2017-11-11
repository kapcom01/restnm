<?php
chdir('../../');
include 'snmp_work.php';
include 'arp_work.php';
$ini_array = parse_ini_file("switches.ini");

/*
$switches = array(
  // array field for every switch
  'ip_address' => "",
  'name' = "",
  'ports' => array(
    // array field for every port
    'ifindex' => "",
    'ifname' => "",
    'devices' => array(
    // array field for every connected device
      'mac_address' => "",
      'ip_address' => ""
    )
  )
);
*/

foreach ($ini_array['ip'] as $ip) {
  $swports = snmp_swports($ip);
  $arptable = get_mac_ip_vendor();

  foreach ($swports as $swport) {

    //get ip from arp table
    foreach ($swport['devices'] as $device) {
      $devices[] = array(
        'mac_address' => $device['mac_address'],
        'ip_address' => $arptable[$device['mac_address']]['ip_address']
      );
    }
    $swport['devices'] = $devices;
    $devices = null;

    //convert to array
    $ports[]=$swport;
  }

  $switches[] = array(
    'id' => "",
    'ip_address' => $ip,
    'name' => "",
    'snmp_config' => array(
      'host' => "",
      'port' => "",
      'version' => "",
      'community' => "",
      'username' => "",
      'password' => ""
    ),
    'ports' => $ports
  );

}
echo json_encode($switches);
?>