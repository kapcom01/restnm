<?php
function get_arp_data(){
        $debug_flag = file_exists("enable_debug");

        if ($debug_flag) $myfile = fopen("debug/netdiscover.out", "r") or die("Unable to open file!");
	else $myfile = fopen("netdiscover.out", "r") or die("Unable to open file!");

	while(! feof($myfile))
	{
		$str = fgets($myfile);
		//$str = " 181.16.105.27   00:0d:ea:01:00:9a      1      60  Kingtel Telecommunication Corp.";
		$str = preg_replace('!\s+!', ' ', $str);
		$str = trim($str);
		$line_result = (explode(" ",$str, 5));
		$netdiscover[$line_result[1]] = array(
			'ip_address' => $line_result[0],
			'vendor' => $line_result[4],
		);
	}
	fclose($myfile);
	return $netdiscover;
}
?>
