<?php
include 'snmp_work.php';

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('gnanm.db');
    }
}

function db_recreate(){
	$db = new MyDB;
        $create_table_sql = "CREATE TABLE snmp_table (
                id INTEGER primary key not null,
                switch_ip STRING,
                switch_ifname STRING,
                switch_uplink_port STRING,
                device_macaddress STRING
        )";

        $db->exec("DROP TABLE snmp_table");
        $db->exec($create_table_sql);
}
function db_put_arp(){
}

function db_put_snmp($ip){
  $db = new MyDB;
  $swports = get_snmp_data($ip);

  // iterate snmp data
  foreach ($swports as $swport) {
    if (count($swport['mac_address'])) {
      foreach ($swport['mac_address'] as $row_mac_address) {
        if($swport['uplink']) {
                continue;
        }
        else {
                $insert_row_sql = "INSERT INTO snmp_table (switch_ip,switch_ifname,switch_uplink_port,device_macaddress) VALUES(
                  '". $ip ."',
                  '". $swport['ifname'] ."',
                  '". $swport['uplink'] ."',
                  '". $row_mac_address ."'
                )";
                $db->exec($insert_row_sql);
        }
      }
    }
  }
}

function db_get_snmp(){
  $db = new MyDB;
  $results = $db->query('SELECT * FROM snmp_table');
  $snmp_data = [];
    while ($row = $results->fetchArray()) {
      $snmp_data[] = $row;
  }
  return $snmp_data;
}

?>
