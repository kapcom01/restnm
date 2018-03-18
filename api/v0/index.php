<?php

function dispatch_get($noun, $param)
{
    echo "ok get";
}

function dispatch_put($noun, $param)
{
    echo "update resourse ".$noun.": ".$param." is not implemented yet.";
}

function dispatch_post($noun, $param)
{
    echo "create resourse ".$noun.": ".$param." is not implemented yet.";
}

function dispatch_delete($noun, $param)
{
    echo "delete resourse ".$noun.": ".$param." is not implemented yet.";
}

// το 6 αφορα το τωρινο path και πρεπει να βρω αλλη λυση
// παραδειγμα path: http://gnanm.local/api/v1/?/switch/5hiu
$req = (explode("/",$_SERVER['REQUEST_URI'], 6));
$req = preg_replace('/[^A-Za-z0-9\-]/', '', $req);
$noun = $req[4];
$param = $req[5];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        dispatch_get($noun, $param);
        break;
    case 'PUT':
        dispatch_put($noun, $param);
        break;
    case 'POST':
        dispatch_post($noun, $param);
        break;
    case 'DELETE':
        dispatch_delete($noun, $param);
        break;
}

?>
