<?php
include 'snmp_work.php';
include 'arp_work.php';
include 'gnaip-schema.php';

$ini_array = parse_ini_file("switches.ini");

header('Access-Control-Allow-Origin: *');

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('mysqlitedb.db');
    }
}

$db = new MyDB();

$create_table_sql = "CREATE TABLE snmp_table (
        id INTEGER primary key not null,
        switch_ip STRING,
        switch_ktirio STRING,
        switch_orofos INTEGER,
        switch_ifname STRING,
        switch_uplink_port STRING,
        device_macaddress STRING,
        device_ipaddress STRING,
        device_typos STRING,
        device_ktirio INTEGER,
        device_orofos INTEGER,
        device_vendor STRING

)";

$db->exec("DROP TABLE snmp_table");
$db->exec($create_table_sql);

$i=1;
foreach ($ini_array['ip'] as $ip) {
  echo "SNMP: (".$i++."/". count($ini_array['ip']) . ") populating db for Switch: ".$ip ." <br>\n";

  $swports = get_snmp_data($ip);
  $arptable = get_arp_data();

  // iterate snmp data
  foreach ($swports as $swport) {
    if (count($swport['mac_address'])) {
      foreach ($swport['mac_address'] as $row_mac_address) {
        if($swport['uplink']) {
                continue;
        }
        else {
		$insert_row_sql = "INSERT INTO snmp_table (switch_ip,switch_ktirio,switch_orofos,switch_ifname,switch_uplink_port,device_macaddress,device_ipaddress,device_typos,device_ktirio,device_orofos,device_vendor) VALUES (
        	  '". $ip ."',
	          '". ktirio($ip) ."',
	          '". orofos($ip) ."',
	          '". $swport['ifname'] ."',
	          '". $swport['uplink'] ."',
	          '". $row_mac_address ."',
	       	  '". $arptable[$row_mac_address]['ip_address'] ."',
	          '". typos($arptable[$row_mac_address]['ip_address']) ."',
        	  '". ktirio($arptable[$row_mac_address]['ip_address']) ."',
	          '". orofos($arptable[$row_mac_address]['ip_address']) ."',
	          '". $arptable[$row_mac_address]['vendor'] ."'
	        )";
		$db->exec($insert_row_sql);
	        unset($arptable[$row_mac_address]);
	}
      }
    }
  }
}

echo "ARP: now you must run: 'netdiscover -P -L -r 172.16.0.0/16 >netdiscover.out'\n"; 
?>
