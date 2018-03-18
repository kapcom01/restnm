<?php

function ktirio($ip_address){
  $ip_byte = explode(".",$ip_address);
  if ($ip_byte[0] != '172' || $ip_byte[1] != '16') return '';

  if (strlen($ip_byte[2]) > 2)
    $ktirio = substr($ip_byte[2], 0, 2);
  else
    $ktirio = substr($ip_byte[2], 0, 1);

  return $ktirio;
}

function orofos($ip_address){
  $ip_byte = explode(".",$ip_address);
  if ($ip_byte[0] != '172' || $ip_byte[1] != '16') return '';

  if (strlen($ip_byte[2]) > 2)
    $orofos = substr($ip_byte[2], 2, 1);
  else
    $orofos = substr($ip_byte[2], 1, 1);

  return $orofos;
}

function type($ip_address){
  $ip_byte = explode(".",$ip_address);
  if ($ip_byte[0] != '172' || $ip_byte[1] != '16') return '';

  if ($ip_byte[3] < 100) $type = 'pc';
  elseif ($ip_byte[3] < 200) $type = 'printer';
  else $type = 'other_device';

  return $type;
}

?>
